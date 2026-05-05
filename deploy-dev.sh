#!/usr/bin/env bash
set -e

echo "▶ Deploy DEV gestartet..."

# Sicherstellen, dass wir committed sind
if ! git diff --quiet || ! git diff --cached --quiet; then
  echo "❌ Nicht alle Änderungen sind committed!"
  exit 1
fi

# Optional: sicherstellen, dass main aktuell ist
git pull --rebase

# Deploy per rsync
rsync -av --delete \
  --exclude=".git" \
  --exclude=".vscode" \
  --exclude="node_modules" \
  --exclude=".DS_Store" \
  --exclude="deploy-dev.sh" \
  --exclude="config.php" \
  ./ \
  ssh-w0215e47@w0215e47.kasserver.com:/www/htdocs/w0215e47/mantd.org/

echo "✅ Deploy DEV abgeschlossen"