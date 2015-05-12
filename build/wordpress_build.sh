#!/bin/bash

BUILD=`pwd`;
PLUGIN_DIR='dfp-ads';

echo 'Building WordPress plugin.';

echo -n 'What is the version number? ';
read VERSION;
echo "$VERSION";

cd $BUILD/../;

###
# Make directory of files to import
###
mkdir "$PLUGIN_DIR/";
rsync -av --files-from=build/wordpress-files.txt . "$PLUGIN_DIR/"

###
# Move vendor files to lib folder
###
mkdir lib;
rsync -vah vendor/ "$PLUGIN_DIR/lib"

###
# Change Version Number
###
echo "Updating version to $VERSION";
sed -i '' "s|\* Version:           *.*.*|\* Version:           $VERSION|" "$PLUGIN_DIR/plugin.php"

###
# Change autoload
###
echo "Changing location of autoload";
sed -i '' "s|require_once 'vendor/autoload.php'|require_once 'lib/autoload.php'|" "$PLUGIN_DIR/plugin.php"

###
# Zip plugin for distribution
###
zip -r -X dfp-ads.zip "$PLUGIN_DIR/"
rm -rf "$PLUGIN_DIR/"

###
# Return Home; We're Complete
###
cd $BUILD;
echo 'Build Complete.';