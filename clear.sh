#!/bin/bash
# Löscht alles außer .git und den Starter-/Hilfsdateien, committet und pusht
set -euo pipefail

REPO="/c/Users/RuppelA/Documents/Projekte/Github"
cd "$REPO"

[ -d ".git" ] || { echo ".git fehlt"; exit 1; }

echo "Lösche Inhalte ..."

# Alles löschen außer .git, Skripten, .gitignore, .bat
find . -mindepth 1 \
  ! -regex '^./\.git\(/.*\)?' \
  ! -name 'push.sh' \
  ! -name 'clear.sh' \
  ! -name '.gitignore' \
  ! -name 'GitPush.bat' \
  ! -name 'Clear.bat' \
  -print0 | xargs -0 rm -rf --

# Stage + Commit + Push
git add -A
if ! git diff --cached --quiet; then
  git commit -m "Clear working tree"
  if ! git rev-parse --abbrev-ref --symbolic-full-name "@{u}" >/dev/null 2>&1; then
    git push -u origin "$(git branch --show-current)"
  else
    git push
  fi
else
  echo "Nichts zu committen."
fi
