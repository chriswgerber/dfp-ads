#!/bin/bash
# Build Script
# Runs the WordPress deployment.
source "src/cd_plugin_dir";
source "src/cp_plugin_files";
red=`tput setaf 1`
green=`tput setaf 2`
reset=`tput sgr0`
SCRIPT_DIR=`pwd`;
REPO_DIR='repo';
echo "${green}Building WordPress plugin.${reset}"
echo "${green}Updating Composer packages to non-dev packages.${reset}";
cd $SCRIPT_DIR && cd ../
composer install --no-dev
echo "${green}Running Gulp build.${reset}";
gulp
echo "${green}Copying files into SVN directory.${reset}";
rsync -Pav --exclude=".*/" --files-from=bin/wordpress-files.txt . "$REPO_DIR/trunk"
echo "${green}Copying Directories and removing hidden files${reset}";
cp_plugin_files assets
cp_plugin_files includes
cp_plugin_files vendor
cd "$REPO_DIR/trunk"
echo "${green}Remove missing or deleted files from SVN.${reset}";
svn rm $( svn status | sed -e '/^!/!d' -e 's/^!//' );
find . -type f -name ".*" -delete
find . -type d -name ".git" -delete
echo "${green}Stage files to be uploaded to SVN.${reset}"
svn add * --force
echo "${green}SVN Status:${reset}";
svn stat
echo -n "${red}Is it okay to commit this to the WordPress repo? (y/N) ${reset}"
read CONFIRM
if [ "$CONFIRM" == 'y' ]; then
    echo "${red}Please enter the commit message.${reset}";
    read MESSAGE;
    svn ci -m "$MESSAGE";
    echo -n "${red}Is this a release version? (y/N) ${reset}"
    read CONFIRM_VER
    if [ "$CONFIRM_VER" == 'y' ]; then
        echo -n "${red}What is the version number? ${reset}";
        read VERSION;
        echo "$VERSION";
        svn cp trunk tags/"$VERSION";
        svn ci -m "Version $VERSION";
    fi
fi
echo "${green}Reverting composer packages back to development.${reset}";
cd $SCRIPT_DIR && cd ../
composer install
echo -n "${red}Build Documentation? (y/N) ${reset}"
read DOC_CONFIRM
if [ "$DOC_CONFIRM" == 'y' ]; then
    php vendor/bin/phpdoc run -f ./plugin.php -d ./includes -t build/docs/
fi
echo "${green}Build Complete.${reset}";