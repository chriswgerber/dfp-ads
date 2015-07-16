#!/bin/bash

BUILD=`pwd`;
REPO_DIR='repo';

### Getting back to the plugin root
cd_plugin_dir
{
    cd "$BUILD/../";
}

echo 'Building WordPress plugin.';
echo -n 'What is the version number? ';
read VERSION;
echo "$VERSION";

### Revert vendor files to remove dev
cd_plugin_dir
echo "Updating Composer packages to release packages.";
composer update --no-dev

### Make directory of files to import
rsync -hav --exclude ".*/" --files-from=bin/wordpress-files.txt . "$REPO_DIR/trunk"

### Change Version Number
echo "Updating version to $VERSION";
sed -i '' "s|\* Version:           *.*.*|\* Version:           $VERSION|" "$REPO_DIR/trunk/plugin.php"
sed -i '' "s|Stable tag: *.*.*|Stable tag: $VERSION|" "$REPO_DIR/trunk/readme.txt"

### Updating Repo
cd $REPO_DIR;
svn stat
echo -n "Is it okay to commit this to the WordPress repo? (y/n) "
read CONFIRM
if [ "$CONFIRM" == 'y' ]; then
    echo "Please enter the commit message.";
    read MESSAGE;
    svn ci -m "$MESSAGE";
fi

### Add New Release
echo -n "Is this a release version? (y/n) "
read CONFIRM_VER
if [ "$CONFIRM_VER" == 'y' ]; then
    svn cp trunk tags/"$VERSION";
    svn ci -m "Version $VERSION";
fi

### Documentation
cd_plugin_dir
php vendor/bin/phpdoc run -f ./plugin.php -d ./includes -t build/docs/

### Revert vendor files to remove dev
echo "Reverting composer packages back to development.";
composer update

### Return Home; We're Complete
cd $BUILD;
echo 'Build Complete.';