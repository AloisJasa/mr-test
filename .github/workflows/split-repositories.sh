#!/bin/bash

set -eo pipefail

PACKAGE=$1
GH_TOKEN=$2
TMP=tmp_split
URL="https://${GH_TOKEN}@github.com/aloisjasa/${PACKAGE}"

set -u

PWD=`pwd`

echo "Monorepo Split – ${PACKAGE}"

echo "Init environment"
cd ${PWD}
echo "mkdir -p ${PWD}/${TMP}/${PACKAGE}"
mkdir -p ${PWD}/${TMP}/${PACKAGE}

echo "clone --bare .git ${PWD}/${TMP}/${PACKAGE}"
git clone --bare .git ${PWD}/${TMP}/${PACKAGE}

echo "cd ${PWD}/${TMP}/${PACKAGE}"
cd ${PWD}/${TMP}/${PACKAGE}

git filter-repo --subdirectory-filter packages/${PACKAGE} --force

echo "dry-run"
git push "${URL}.git" main --dry-run --force --verbose

echo "git push"
git push "${URL}.git" main --force --verbose
