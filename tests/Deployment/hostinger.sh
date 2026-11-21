#!/usr/bin/env bash
# Exercise release switching using a PHP stub; never connect to a real database.
set -Eeuo pipefail

project_root=$(cd -- "$(dirname -- "${BASH_SOURCE[0]}")/../.." && pwd)
fixture=$(mktemp -d "$HOME/.codevatech-deploy-test.XXXXXX")
cleanup() {
    # The verified mktemp directory is the only recursive cleanup target.
    [[ $fixture == "$HOME/".codevatech-deploy-test.* && -d $fixture ]] && rm -rf -- "$fixture"
}
trap cleanup EXIT

mkdir -p "$fixture/app/shared/storage" "$fixture/source/vendor/composer" "$fixture/source/public/build" "$fixture/source/storage/framework/views" "$fixture/source/bootstrap/cache"
touch "$fixture/app/.codevatech-deploy-root"
printf 'APP_KEY=fixture-only\n' > "$fixture/app/shared/.env"
printf 'existing storage\n' > "$fixture/app/shared/storage/sentinel.txt"
for path in artisan vendor/autoload.php vendor/composer/platform_check.php public/index.php public/build/manifest.json; do
    printf 'fixture\n' > "$fixture/source/$path"
done
printf '*\n!.gitignore\n' > "$fixture/source/storage/framework/views/.gitignore"
tar -czf "$fixture/release.tar.gz" -C "$fixture/source" .
cat > "$fixture/php-stub" <<'PHP_STUB'
#!/usr/bin/env bash
if [[ ${FAIL_PREFLIGHT:-0} == 1 && ${1:-} == scripts/hostinger-preflight.php ]]; then
    exit 1
fi
PHP_STUB
chmod +x "$fixture/php-stub"

bash "$project_root/scripts/deploy-hostinger.sh" "$fixture/release.tar.gz" "$fixture/app" first "$fixture/php-stub"
[[ $(readlink "$fixture/app/current") == "$fixture/app/releases/first" ]]
[[ $(cat "$fixture/app/current/.env") == APP_KEY=fixture-only ]]
[[ $(cat "$fixture/app/current/storage/sentinel.txt") == 'existing storage' ]]

if FAIL_PREFLIGHT=1 bash "$project_root/scripts/deploy-hostinger.sh" "$fixture/release.tar.gz" "$fixture/app" failed "$fixture/php-stub"; then
    echo 'A failed preflight must block activation.' >&2
    exit 1
fi
[[ $(readlink "$fixture/app/current") == "$fixture/app/releases/first" ]]

bash "$project_root/scripts/deploy-hostinger.sh" "$fixture/release.tar.gz" "$fixture/app" second "$fixture/php-stub"
[[ $(readlink "$fixture/app/current") == "$fixture/app/releases/second" ]]
[[ -f $fixture/app/releases/first/artisan ]]
[[ $(cat "$fixture/app/shared/.env") == APP_KEY=fixture-only ]]
[[ $(cat "$fixture/app/shared/storage/sentinel.txt") == 'existing storage' ]]

mkdir -p "$fixture/uninitialized"
if bash "$project_root/scripts/deploy-hostinger.sh" "$fixture/release.tar.gz" "$fixture/uninitialized" third "$fixture/php-stub"; then
    echo 'An uninitialized directory must be rejected.' >&2
    exit 1
fi
echo 'Deployment checks passed: activation, failure isolation, data preservation, and target validation.'
