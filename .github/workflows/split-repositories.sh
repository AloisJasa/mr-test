#!/bin/bash

set -eo pipefail

GH_TOKEN=$1
PACKAGE=$2
BRANCH=$3
TMP="tmp_split/${RANDOM}"
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
git push "${URL}.git" ${BRANCH} --dry-run --verbose
git push "${URL}.git" ${BRANCH} --tags --dry-run --verbose

echo "git push"
git push "${URL}.git" ${BRANCH} --verbose
git push "${URL}.git" ${BRANCH} --tags --verbose
