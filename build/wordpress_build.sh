#!/bin/bash

BUILD=`pwd`;

echo 'Building WordPress plugin.';

echo -n 'What is the version number? ';
read VERSION;
echo "$VERSION";

cd $BUILD/../;

###
# Change Version Number
###
echo "Updating version to $VERSION";
sed -i '' "s|\* Version:           *.*.*|\* Version:           $VERSION|" plugin.php

###
# Make directory of files to import
###
mkdir plugin/;
rsync -av --files-from=build/wordpress-files.txt . plugin/

###
# Move vendor files to lib folder
###
mkdir lib;
rsync -vah vendor/ plugin/lib/

###
# Change autoload
###
echo "Changing location of autoload";
sed -i '' "s|require_once 'vendor/autoload.php'|require_once 'lib/autoload.php'|" plugin/plugin.php

###
# Return Home; We're Complete
###
cd $BUILD;
echo 'Build Complete.';