#!/bin/sh

git merge --no-ff --no-commit dev
git reset HEAD deploy.sh
git checkout -- deploy.sh
git commit -m "merged dev"
git push