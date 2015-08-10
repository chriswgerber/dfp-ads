#!/bin/bash
####
# Build Script
####
source "src/cd_plugin_dir";
REPO_DIR='repo';
BUILD_DIR='bin';
echo 'Building WordPress plugin.'
echo -n 'What is the version number? ';
read VERSION;
echo "$VERSION";
### Revert vendor files to remove dev
cd_plugin_dir
echo "Updating Composer packages to release packages.";
composer update --no-dev
echo "Running Gulp build.";
### Make directory of files to import
rsync -Pav --exclude ".*/" --files-from=bin/wordpress-files.txt . "$REPO_DIR/trunk"
### Updating Repo
cd $REPO_DIR;
svn stat
echo -n "Is it okay to commit this to the WordPress repo? (y/n) "
read CONFIRM
if [ "$CONFIRM" == 'y' ]; then
    echo "Please enter the commit message.";
    read MESSAGE;
    svn ci -m "$MESSAGE";
    ### Add New Release
    echo -n "Is this a release version? (y/n) "
    read CONFIRM_VER
    if [ "$CONFIRM_VER" == 'y' ]; then
        svn cp trunk tags/"$VERSION";
        svn ci -m "Version $VERSION";
    fi
fi
### Revert vendor files to remove dev
echo "Reverting composer packages back to development.";
composer update
### Documentation
cd_plugin_dir
php vendor/bin/phpdoc run -f ./plugin.php -d ./includes -t build/docs/
### Return Home; We're Complete
echo 'Build Complete.';