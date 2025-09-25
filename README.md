# Martin's comments 2025-09-25:

## General

This codespace delivers a fully functional Wordpress environment for development of new plugins or themes in a GIt Codespace with VSCode.

The environment is built using Wordpress VIP Codespaces by Automattic, see https://github.com/Automattic/vip-codespaces    
It sports a modular approach with various features that can be enabled or disabled via `devcontainer.json`.:

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

## Manual post-installation options:

### (Recommended) Access WordPress Core files
By default, WordPress Core files are *not* exposed in the VS Code interface. If needed, these files can be surfaced for reference in the VS Code Explorer panel.

Enter the VS Code Command Palette by either:
- Right-clicking anywhere in the Explorer panel and selecting “Add Folder to Workspace…“.
- Or selecting the key combination ⇧⌘P on the keyboard, then enter the prompt Add folder to workspace.
- In the Command Palette field, highlight any existing values and replace them by entering the path value `/wp`.

Wordpress Core files remain read-only, with the exception of the `/wp/config` folder where you'll have write permissions.

### (Recommended) Modify wp-config to allow plugin and theme downloads.
Wordpress core files support editing wp-config settings via  `/wp/config` folder.

By default, the WordPress installation does *not* allow to install new plugins or themes via wp-admin interface. This can be changed by modifying the wp config files.    
In `/wp/config/wp-config-defaults.php` set the DISALLOW_FILE_MODS setting to *false*:
```bash
    if ( ! defined( 'DISALLOW_FILE_MODS' ) ) {
        define( 'DISALLOW_FILE_MODS', false );
    }
```

### (Recommeded) Edit .gitignore to exclude all plugins and themes except the one bing developed

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
## Development folders

By default the container is configured for plugin or theme development on top of a "plain vanilla" installation of Wordpress.    
To that end, the repository provides folders for `/plugins/` and `/themes/` where you can place your code.

### Creating a new Plugin
```bash
mkdir wp-content/plugins/my-plugin
cd wp-content/plugins/my-plugin
# Create your plugin files
wp plugin activate my-plugin --allow-root
```

### Creating a new Theme
```bash
mkdir wp-content/themes/my-theme
cd wp-content/themes/my-theme
# Create style.css and index.php
wp theme activate my-theme --allow-root
```



WordPress settings can be configured in .devcontainer/wp-setup.sh, i.e. the site name, and admin user account details. You can also specify a space-separated list of WordPress plugins to automatically install as well. By setting WP_RESET to true, the container will rebuild the WordPress instalation from scratch every time it is loaded.

## References/documentation

- Wordpress VIP Codespaces at Github: https://github.com/Automattic/vip-codespaces
- Wordpress VIP Codespaces documentaiton: https://docs.wpvip.com/local-development/github-codespaces/  


# Upgrading Legacy WordPress Projects: Modernize Workflows and Codebase
This is the repository for the LinkedIn Learning course `Upgrading Legacy WordPress Projects: Modernize Workflows and Codebase`. The full course is available from [LinkedIn Learning][lil-course-url].

![lil-thumbnail-url]

## Course Description

In this course, developer and WordPress enthusiast Daisy Olsen highlights essential strategies and techniques for modernizing legacy WordPress projects. Learn how to assess existing codebases, use Git-based version control and branching strategies, and implement automated testing. Find out how to refactor for improved maintainability, integrate modern frameworks, and optimize performance. Explore technical debt management, stakeholder reporting, and Agile project management methodologies. Plus, gain hands-on experience in applying these concepts to real-world scenarios, ensuring that you can confidently approach legacy project retrofitting in your own work. When you complete this course, you'll have a comprehensive toolkit for breathing new life into older WordPress projects.

### Instructor

Daisy Olsen

Developer | WordPress Enthusiast | Open-Source Contributor

                            

Check out my other courses on [LinkedIn Learning](https://www.linkedin.com/learning/instructors/daisy-olsen?u=104).



[0]: # (Replace these placeholder URLs with actual course URLs)

[lil-course-url]: https://www.linkedin.com/learning/upgrading-legacy-wordpress-projects-modernize-workflows-and-codebase
[lil-thumbnail-url]: https://media.licdn.com/dms/image/v2/D4D0DAQEV5oXtu69iqw/learning-public-crop_675_1200/B4DZWvvFK.H4AY-/0/1742410110356?e=2147483647&v=beta&t=8z7UiqteFSn4qxX5bZ_KCgm5mbzwzkbVoA1frO-0Lkc

