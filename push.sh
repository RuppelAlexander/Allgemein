#!/bin/bash
# Robust push: staged + deletions, Commit nur bei Bedarf, Upstream nutzen
set -euo pipefail

REPO="/c/Users/RuppelA/Documents/Projekte/Github"
cd "$REPO"

# 1) sicher im Repo
git rev-parse --is-inside-work-tree >/dev/null

# 2) Branch prüfen
BRANCH="$(git branch --show-current || true)"
[ -n "$BRANCH" ] || { echo "Kein Branch (detached HEAD)."; exit 1; }

# 3) Änderungen inkl. Löschungen
git add -A

# 4) Commit nur wenn staged
if ! git diff --cached --quiet; then
  git commit -m "${1:-Update}"
else
  echo "Keine Änderungen zum Commit."
fi

# 5) Push mit Upstream
if ! git rev-parse --abbrev-ref --symbolic-full-name "@{u}" >/dev/null 2>&1; then
  git push -u origin "$BRANCH"
else
  git push
fi
