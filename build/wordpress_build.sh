#!/bin/bash

BUILD=`pwd`;
REPO_DIR='repo/trunk';

echo 'Building WordPress plugin.';
echo -n 'What is the version number? ';
read VERSION;
echo "$VERSION";

cd $BUILD/../;

###
# Move vendor files to lib folder
###
rsync -vah --exclude ".*/" vendor/ "$REPO_DIR/lib"

###
# Make directory of files to import
###
rsync -hav --exclude ".*/" --files-from=build/wordpress-files.txt . "$REPO_DIR/"

###
# Change Version Number
###
echo "Updating version to $VERSION";
sed -i '' "s|\* Version:           *.*.*|\* Version:           $VERSION|" "$REPO_DIR/plugin.php"

###
# Change autoload
###
echo "Changing location of autoload";
sed -i '' "s|require_once 'vendor/autoload.php'|require_once 'lib/autoload.php'|" "$REPO_DIR/plugin.php"

###
# Return Home; We're Complete
###
cd $BUILD;
echo 'Build Complete.';