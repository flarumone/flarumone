#!/usr/bin/env bash

base=${PWD}
ext_name=noslug
tar_dir=/tmp/flarum-ext
release_dir=$tar_dir/$ext_name

# Unzip an archive of the latest committed code
cd /tmp
rm -rf $release_dir
mkdir $release_dir
git archive --format zip --worktree-attributes HEAD > /tmp/extension-release/release.zip
cd $release_dir
unzip release.zip -d ./
rm release.zip

# Install all Composer dependencies
cd $release_dir/flarum
composer install --prefer-dist --optimize-autoloader --ignore-platform-reqs --no-dev

# Compile JavaScript
# Assumes: npm install -g gulp flarum-gulp babel-core
cd $release_dir/js
for app in forum admin; do
  cd "${release_dir}/js/${app}"
  npm link gulp flarum-gulp babel-core
  gulp --production
  rm -rf "${release_dir}/js/${app}/node_modules"
done

cd $tar_dir
tar -cjvf $ext_name.tar.bz2 $ext_name