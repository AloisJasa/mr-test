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
mkdir -p ${PWD}/${TMP}/${PACKAGE}
git clone --bare .git ${PWD}/${TMP}/${PACKAGE}
cd ${PWD}/${TMP}/${PACKAGE}

git filter-repo --subdirectory-filter packages/${PACKAGE} --force

echo "dry-run"
git push "${URL}${PACKAGE}.git" main --dry-run --force --verbose

echo "git push"
cd ${PWD}/${TMP}/${PACKAGE}
git push "${URL}${PACKAGE}.git" main --force --verbose
