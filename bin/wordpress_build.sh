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
rsync -vah --exclude ".*/" vendor/ "$REPO_DIR/vendor"

###
# Make directory of files to import
###
rsync -hav --exclude ".*/" --files-from=bin/wordpress-files.txt . "$REPO_DIR/"

###
# Change Version Number
###
echo "Updating version to $VERSION";
sed -i '' "s|\* Version:           *.*.*|\* Version:           $VERSION|" "$REPO_DIR/plugin.php"

###
# Updating Repo
###
cd repo;
svn stat
echo -n "Is it okay to commit this to the WordPress repo? (y/n) "
read CONFIRM
if [ "$CONFIRM" == 'y' ]; then
    echo "Please enter the commit message.";
    read MESSAGE;
    svn ci -m "$MESSAGE";
fi

###
# Add New Release
###
echo -n "Is this a release version? (y/n) "
read CONFIRM_VER
if [ "$CONFIRM_VER" == 'y' ]; then
    svn cp trunk tags/"$VERSION";
    svn ci -m "Version $VERSION";
fi

###
# Return Home; We're Complete
###
cd $BUILD;
echo 'Build Complete.';