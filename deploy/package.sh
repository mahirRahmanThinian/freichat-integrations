#!/usr/bin/env bash

# Init
CURR_DIR="$( cd "$( dirname "${BASH_SOURCE[0]}" )" && pwd )"
BASE_DIR=${CURR_DIR}/..
VERSION=1.0.2
INTEG_DIR=$BASE_DIR/integrations

# Cleanup
cd $BASE_DIR/bin
rm -rf *.zip

# Package
cd $INTEG_DIR/joomla
NAME=mod_freichat
zip -r $BASE_DIR/bin/${NAME}.v${VERSION}.zip .

cd $INTEG_DIR/humhub
NAME=humhub_freichat
zip -r $BASE_DIR/bin/${NAME}.v${VERSION}.zip .

cd $INTEG_DIR/codoforum
NAME=codoforum_freichat
zip -r $BASE_DIR/bin/${NAME}.v${VERSION}.zip .

cd $INTEG_DIR/elgg
NAME=elgg_freichat
zip -r $BASE_DIR/bin/${NAME}.v${VERSION}.zip .

cd $INTEG_DIR/wordpress
NAME=wordpress_freichat
zip -r $BASE_DIR/bin/${NAME}.v${VERSION}.zip .
