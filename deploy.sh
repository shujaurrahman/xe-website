#!/usr/bin/env bash
# Deploys the site to Hostinger over SSH — key auth via the `xterra` host in ~/.ssh/config.
#
#   ./deploy.sh            build, preview what will change, confirm, upload
#   ./deploy.sh --dry      preview only — nothing is uploaded
#   ./deploy.sh --yes      skip the confirmation prompt
#   ./deploy.sh --delete   also remove server files that no longer exist locally
#
# Target without editing this file:  REMOTE_DIR=domains/example.com/public_html ./deploy.sh
set -euo pipefail

HOST="${DEPLOY_HOST:-xterra}"
REMOTE_DIR="${REMOTE_DIR:-domains/xterraedze.com/public_html}"   # relative to the account's home
DOMAIN="$(printf '%s' "$REMOTE_DIR" | sed -nE 's#^(.*/)?domains/([^/]+)/.*#\2#p')"

cd "$(dirname "$0")"

DRY=0; YES=0; DELETE=0
for a in "$@"; do
  case "$a" in
    --dry|-n)  DRY=1 ;;
    --yes|-y)  YES=1 ;;
    --delete)  DELETE=1 ;;
    -h|--help) sed -n '2,9p' "$0" | sed -E 's/^# ?//'; exit 0 ;;
    *) echo "unknown option: $a  (see ./deploy.sh --help)" >&2; exit 2 ;;
  esac
done

say()  { printf '\033[1m%s\033[0m\n' "$*"; }
note() { printf '  %s\n' "$*"; }
die()  { printf '\033[31m✗ %s\033[0m\n' "$*" >&2; exit 1; }

# Never uploaded: dev tooling, docs, OS junk, and the per-section sources
# (pages load the bundles build.php writes into assets/).
EXCLUDES=(
  .git/ .gitignore .DS_Store Thumbs.db .vscode/ .claude/ node_modules/
  '*.md' /docs/ /tools/ /build.php /deploy.sh
  '/sections/*.css' '/sections/*.js'
  # files Hostinger manages on the server — excluded, so --delete leaves them alone
  /.well-known/ /.user.ini /error_log /cgi-bin/
)
[ -f .htaccess ] || EXCLUDES+=(/.htaccess)   # keep the server's unless the repo ships one

RSYNC=(rsync -rltz -e "ssh -o BatchMode=yes -o ConnectTimeout=15")
for x in "${EXCLUDES[@]}"; do RSYNC+=(--exclude="$x"); done
[ "$DELETE" = 1 ] && RSYNC+=(--delete)

# 1. build ---------------------------------------------------------------------
say "→ Building section bundles"
php build.php | sed 's/^/  /'

if git rev-parse --git-dir >/dev/null 2>&1; then
  REV="$(git rev-parse --short HEAD)"
  DIRTY="$(git status --porcelain | wc -l | tr -d ' ')"
  note "commit $REV$([ "$DIRTY" = 0 ] || echo " + $DIRTY uncommitted change(s), deployed as they are on disk")"
fi

# 2. preflight -----------------------------------------------------------------
say "→ Checking $HOST:$REMOTE_DIR"
rc=0; ssh -o BatchMode=yes -o ConnectTimeout=15 "$HOST" "test -d '$REMOTE_DIR'" || rc=$?
[ "$rc" = 255 ] && die "Can't connect to '$HOST' over SSH. Test with: ssh $HOST"
[ "$rc" = 0 ]   || die "'$REMOTE_DIR' doesn't exist on the server. Add the domain in hPanel first, or set REMOTE_DIR."

# 3. preview -------------------------------------------------------------------
say "→ Changes"
PLAN="$("${RSYNC[@]}" --dry-run --itemize-changes ./ "$HOST:$REMOTE_DIR/")"
CHANGES="$(printf '%s\n' "$PLAN" | grep -E '^(<f|>f|cd|\*deleting)' | grep -vE '^cd\.' || true)"
COUNT="$(printf '%s' "$CHANGES" | grep -c . || true)"

if [ "$COUNT" = 0 ]; then say "✓ Server is already up to date."; exit 0; fi
printf '%s\n' "$CHANGES" | sed -E 's/^\*deleting +/  − /; s/^[<>]f\+{7,} +/  + /; s/^[<>]f[^ ]* +/  ~ /; s/^cd\+{7,} +/  + /' | head -80
[ "$COUNT" -gt 80 ] && note "… and $((COUNT - 80)) more"
note "$COUNT change(s)   (+ new  ~ updated  − deleted)"

[ "$DRY" = 1 ] && { say "Dry run — nothing uploaded."; exit 0; }

if [ "$YES" != 1 ]; then
  read -r -p "Deploy to ${DOMAIN:-$HOST:$REMOTE_DIR}? [y/N] " ok
  [[ "$ok" =~ ^[Yy]$ ]] || { echo "Cancelled."; exit 1; }
fi

# 4. upload --------------------------------------------------------------------
say "→ Uploading"
"${RSYNC[@]}" ./ "$HOST:$REMOTE_DIR/"

# New files take the server umask (644/755); this only repairs anything group/world
# writable, which Hostinger's PHP handler can refuse to serve.
ssh -o BatchMode=yes "$HOST" "cd '$REMOTE_DIR' && \
  find . \\( -path ./cgi-bin -o -path ./.well-known \\) -prune -o -type d -perm /022 -exec chmod 755 {} + && \
  find . \\( -path ./cgi-bin -o -path ./.well-known \\) -prune -o -type f -perm /022 -exec chmod 644 {} +"

say "✓ Deployed $COUNT change(s) in ${SECONDS}s"

# 5. smoke check ---------------------------------------------------------------
if [ -n "$DOMAIN" ]; then
  code="$(curl -s -o /dev/null -w '%{http_code}' --max-time 15 "https://$DOMAIN/" || true)"
  case "$code" in
    200) note "https://$DOMAIN/ → 200 OK" ;;
    *)   note "https://$DOMAIN/ → ${code:-no response} (check DNS/SSL if the domain is new)" ;;
  esac
fi
