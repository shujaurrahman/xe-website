#!/bin/bash
# Commit ONLY the listed paths and push, serialised across parallel agents with flock.
#   tools/xe-commit.sh "message" path [path ...]
# Other agents' uncommitted work in the tree is never swept into the commit (pathspec = --only).
set -u
cd "$(dirname "$0")/.."
MSG="$1"; shift
[ "$#" -gt 0 ] || { echo "no paths given"; exit 2; }
BR=$(git rev-parse --abbrev-ref HEAD)
exec 9>/tmp/xe-git.lock
flock -w 600 9 || { echo "could not take the git lock"; exit 3; }
git add -A -- "$@" || exit 4
if git diff --cached --quiet -- "$@"; then echo "nothing to commit for these paths"; exit 0; fi
git commit -q -m "$MSG

Co-Authored-By: Claude Opus 5.5 <noreply@anthropic.com>
Claude-Session: https://claude.ai/code/session_01XkExqVFSNhm9GvaU3vc6up" -- "$@" || exit 5
git log --oneline -1
for d in 2 4 8 16; do
  git push -q origin "$BR" 2>&1 && { echo "pushed to $BR"; exit 0; }
  python3 -c "import time; time.sleep($d)"
done
echo "PUSH FAILED — commit is local"; exit 6
