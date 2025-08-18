#!/bin/sh
# Scaffold Laravel into temp then sync to project root
TMP_DIR="/tmp/laravel_project"

# Remove temp if exists
rm -rf "$TMP_DIR"

# Create project in temporary directory
composer create-project --prefer-dist laravel/laravel "$TMP_DIR"

# Sync to mounted volume (host)
rsync -a "$TMP_DIR"/ /var/www/

# Clean up temp
test -d "$TMP_DIR" && rm -rf "$TMP_DIR"
