#!/usr/bin/env bash
set -Eeuo pipefail

archive=${1:?Usage: deploy-hostinger-ssh.sh /path/to/codevatech.tar.gz}
for name in SSH_HOST SSH_USER SSH_PORT SSH_PRIVATE_KEY SSH_KNOWN_HOSTS DEPLOY_ROOT RELEASE_ID APP_URL; do
    if [[ -z ${!name:-} ]]; then
        printf 'Missing deployment setting: %s\n' "$name" >&2
        exit 1
    fi
done
[[ -f $archive ]] || { echo 'Release archive not found.' >&2; exit 1; }
[[ $SSH_HOST =~ ^[a-zA-Z0-9][a-zA-Z0-9.-]*$ ]] || exit 1
[[ $SSH_USER =~ ^[a-zA-Z0-9_][a-zA-Z0-9_.-]*$ ]] || exit 1
[[ $SSH_PORT =~ ^[0-9]+$ ]] && (( SSH_PORT >= 1 && SSH_PORT <= 65535 )) || exit 1
[[ $DEPLOY_ROOT =~ ^/[a-zA-Z0-9_./-]+$ && $DEPLOY_ROOT != *'/../'* && $DEPLOY_ROOT != */.. ]] || exit 1
[[ $RELEASE_ID =~ ^[a-zA-Z0-9-]+$ ]] || exit 1
[[ $APP_URL =~ ^https://[a-zA-Z0-9][a-zA-Z0-9.-]*/?$ ]] || { echo 'APP_URL must be the production HTTPS domain.' >&2; exit 1; }
PHP_BIN=${PHP_BIN:-php}
[[ $PHP_BIN =~ ^[a-zA-Z0-9_./-]+$ ]] || exit 1

umask 077
ssh_dir=$(mktemp -d)
remote_dir=
ssh_options=(-p "$SSH_PORT" -i "$ssh_dir/key" -o BatchMode=yes -o IdentitiesOnly=yes -o StrictHostKeyChecking=yes -o "UserKnownHostsFile=$ssh_dir/known_hosts" -o ConnectTimeout=20)
scp_options=(-P "$SSH_PORT" -i "$ssh_dir/key" -o BatchMode=yes -o IdentitiesOnly=yes -o StrictHostKeyChecking=yes -o "UserKnownHostsFile=$ssh_dir/known_hosts" -o ConnectTimeout=20)
destination="$SSH_USER@$SSH_HOST"
cleanup() {
    local status=$?
    if [[ -n $remote_dir ]]; then
        ssh "${ssh_options[@]}" "$destination" "rm -f -- '$remote_dir/release.tar.gz' '$remote_dir/deploy.sh'; rmdir -- '$remote_dir'" >/dev/null 2>&1 || true
    fi
    rm -f -- "$ssh_dir/key" "$ssh_dir/known_hosts"
    rmdir -- "$ssh_dir" || true
    exit "$status"
}
trap cleanup EXIT
printf '%s\n' "$SSH_PRIVATE_KEY" | tr -d '\r' > "$ssh_dir/key"
printf '%s\n' "$SSH_KNOWN_HOSTS" > "$ssh_dir/known_hosts"
unset SSH_PRIVATE_KEY SSH_KNOWN_HOSTS

upload_dir=$(ssh "${ssh_options[@]}" "$destination" 'umask 077; mktemp -d "$HOME/.codevatech-upload.XXXXXX"')
[[ $upload_dir =~ ^/home/[a-zA-Z0-9_.-]+/\.codevatech-upload\.[a-zA-Z0-9]+$ ]] || { echo 'Unexpected upload directory.' >&2; exit 1; }
remote_dir=$upload_dir
scp "${scp_options[@]}" "$archive" "$destination:$remote_dir/release.tar.gz"
scp "${scp_options[@]}" scripts/deploy-hostinger.sh "$destination:$remote_dir/deploy.sh"
ssh "${ssh_options[@]}" "$destination" "bash '$remote_dir/deploy.sh' '$remote_dir/release.tar.gz' '$DEPLOY_ROOT' '$RELEASE_ID' '$PHP_BIN'"
