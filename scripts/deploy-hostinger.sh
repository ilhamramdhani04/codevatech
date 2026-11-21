#!/usr/bin/env bash
# Activate a tested release without changing the imported database or its APP_KEY.
set -Eeuo pipefail
umask 027

archive=${1:?Release archive is required}
deploy_root=${2:?Deployment root is required}
release_id=${3:?Release identifier is required}
php_bin=${4:-php}
fail() { printf '%s\n' "$1" >&2; exit 1; }

[[ -f $archive ]] || fail 'Release archive not found.'
[[ $release_id =~ ^[a-zA-Z0-9-]+$ ]] || fail 'Invalid release identifier.'
[[ $deploy_root == /* && $deploy_root != / ]] || fail 'Deployment root must be an absolute application directory.'
deploy_root=$(realpath -e -- "$deploy_root")
account_home=$(realpath -e -- "$HOME")
[[ $deploy_root == "$account_home/"* ]] || fail 'Deployment root must be inside the hosting account home.'
[[ -f $deploy_root/.codevatech-deploy-root ]] || fail 'Deployment root has not been initialized for CODEVA TECH.'
[[ -f $deploy_root/shared/.env && -d $deploy_root/shared/storage ]] || fail 'Shared production environment and storage must be prepared first.'
[[ ! -L $deploy_root/releases && ! -L $deploy_root/shared ]] || fail 'Deployment directories must not be symlinks.'
mkdir -p -- "$deploy_root/releases"
[[ ! -e $deploy_root/current || -L $deploy_root/current ]] || fail 'Refusing to replace an existing non-symlink current directory.'
command -v "$php_bin" >/dev/null || fail 'PHP CLI is unavailable.'
command -v flock >/dev/null || fail 'The hosting account must support flock.'
exec 9>"$deploy_root/.deploy.lock"
flock -n 9 || fail 'Another deployment is running.'

release_dir="$deploy_root/releases/$release_id"
[[ ! -e $release_dir && ! -L $release_dir ]] || fail 'Release already exists; use a new release identifier.'
mkdir -- "$release_dir"
tar -xzf "$archive" -C "$release_dir" --no-same-owner --no-same-permissions
for required in artisan vendor/autoload.php public/index.php public/build/manifest.json; do
    [[ -f $release_dir/$required ]] || fail "Incomplete release: $required is missing."
done
[[ ! -e $release_dir/.env && ! -L $release_dir/.env ]] || fail 'Release archives must not contain .env.'

# Only remove the empty tracked placeholders in this new release.
[[ -d $release_dir/storage && ! -L $release_dir/storage ]] || fail 'Unexpected storage directory in release.'
find "$release_dir/storage" -type f ! -name .gitignore -print -quit | while IFS= read -r entry; do
    printf 'Unexpected runtime data in release: %s\n' "$entry" >&2
    exit 1
done
find "$release_dir/storage" -type f -name .gitignore -delete
find "$release_dir/storage" -depth -type d -empty -delete
[[ ! -e $release_dir/storage ]] || fail 'Release storage contains unexpected files.'
ln -s "$deploy_root/shared/storage" "$release_dir/storage"
ln -s "$deploy_root/shared/.env" "$release_dir/.env"

cd -- "$release_dir"
"$php_bin" -r 'require "vendor/composer/platform_check.php";'
# Read only: validate production settings and the existing imported database.
"$php_bin" scripts/hostinger-preflight.php
# Compiled views belong to this release so an old request cannot overwrite them.
mkdir -p -- "$release_dir/bootstrap/cache/views"
VIEW_COMPILED_PATH="$release_dir/bootstrap/cache/views" "$php_bin" artisan config:cache --no-interaction
"$php_bin" artisan route:cache --no-interaction
"$php_bin" artisan view:cache --no-interaction

link_tmp="$deploy_root/.current-$release_id"
[[ ! -e $link_tmp && ! -L $link_tmp ]] || fail 'Temporary release link already exists.'
ln -s "$release_dir" "$link_tmp"
mv -Tf -- "$link_tmp" "$deploy_root/current"
printf 'Activated CODEVA TECH release %s\n' "$release_id"
printf 'Database schema and seed data were left unchanged.\n'
