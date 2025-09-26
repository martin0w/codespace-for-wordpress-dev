# Martin's comments 2025-09-25:

## General

This codespace template delivers a fully functional Wordpress environment for development of new plugins or themes in a GIt Codespace with VSCode.

The environment is built using Wordpress VIP Codespaces by Automattic, see https://github.com/Automattic/vip-codespaces    
It sports a modular approach with various features that can be enabled, disabled and configured via devcontainer.json:

- base: Base feature for VIP Codespaces
- nginx: Nginx web server
- php: PHP with configurable version
- mariadb: MariaDB database server
- wordpress: WordPress core
- wp-cli: WordPress CLI
- vip-go-mu-plugins: WordPress VIP MY-plugins
- vip-cli: VIP CLI
- elasticsearch: Elasticsearch server
- memcached: Memcached server
- xdebug: Xdebug for PHP debugging
- phpmyadmin: phpMyAdmin for database management
- mailpit: Mail testing tool
- cron: Cron job support

## Installation

Just create a codespace from this repo.


<br><br>
## What you'll get

By default the container is configured for plugin or theme development on top of a "plain vanilla" installation of Wordpress.    
To that end, the repository provides folders for /plugins/ and /themes/ where you can place your code.

Creating a new Plugin:
```bash
mkdir wp-content/plugins/my-plugin
cd wp-content/plugins/my-plugin
# Create your plugin files
wp plugin activate my-plugin --allow-root
```

Creating a new Theme:
```bash
mkdir wp-content/themes/my-theme
cd wp-content/themes/my-theme
# Create style.css and index.php
wp theme activate my-theme --allow-root
```


<br><br>
## Manual post-installation options:
After a succesful installation an test, it is recommended to refine the environment using the following manual steps:

### ✅ Step 1. Access WordPress Core files
By default, WordPress Core files are *not* exposed in the VS Code interface. If needed, these files can be surfaced for reference in the VS Code Explorer panel.
This is arecommeded practice from the coding point of view, as you will be able to find source code for any built-in WP funcitons directly in VSCode.

Enter the VS Code Command Palette by either:
- Right-clicking anywhere in the Explorer panel and selecting “Add Folder to Workspace…“.
- Or selecting the key combination ⇧⌘P on the keyboard, then enter the prompt Add folder to workspace.
- In the Command Palette field, highlight any existing values and replace them by entering the path value /wp.

Wordpress Core files remain read-only, with the exception of the /wp/config folder where you'll have write permissions.

### ✅ Step 2. Modify wp-config to allow plugin and theme downloads.
Wordpress core files support editing wp-config settings via /wp/config folder.

By default, the WordPress installation does *not* allow to install new plugins or themes via wp-admin interface. This can be changed by modifying the wp config files.    
In /wp/config/wp-config-defaults.php, set the DISALLOW_FILE_MODS setting to *false*:
```bash
    if ( ! defined( 'DISALLOW_FILE_MODS' ) ) {
        define( 'DISALLOW_FILE_MODS', false );
    }
```
Caution: any plugins or themes installed via wp-admin will automatically show in your development folders /plugins/ or /themes/ in your repository.
Use .gitignore to exclude them from tracking, using the following instruciton. 

### ✅ Step 3. Edit .gitignore to exclude all plugins and themes except the one bing developed

Ignore all plugins except the one being developed
```bash
    /plugins/*
    !/plugins/copyright-date-block/**
```
Ignore all themes except the one being developed
```bash
    /themes/*
    !/themes/twentytwentyfive/**
```



<br><br>
# References/documentation

- Wordpress VIP Codespaces at Github: https://github.com/Automattic/vip-codespaces
- Wordpress VIP Codespaces documentaiton: https://docs.wpvip.com/local-development/github-codespaces/
- Wordpress CLI commands reference https://developer.wordpress.org/cli/commands/


