# codespace-for-wordpress-dev

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

## Forwarded ports
- 80 - Wordpress frontend
- 81 - phpMyAdmin database admin interface
- 8025 - Mailpit admin interface

## Folder structure

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
# Sass

Sass comes pre-installed via the following directive in devcontainer.json:

```bash
"postCreateCommand": "npm install -g sass",
```

You can then use Sass like this:

```bash
sass src/styles.scss dist/styles.css
```


<br><br>
# Managing MariaDB

By default, MariaDB is installed with root access. The user 'root' requires no password.

The codespace then creates a 'wordpress' database and adds the user wordpress@localhost, with (gently limited) access rights to that database. 
Both Wordpress and phpMyAdmin will use wordpress@localhost to acces the database. While this is ok in Wordpress, it will somewhat limit one's ability to admin the database, so you should extend the GRANT PRIVILEDGES for wordpress@localhost user. 

First log into your MySQL/MariaDB server as a root user using the mysql client. Type the following command:
```bash
mysql -u root -p
# (if prompted for password, just hit *Enter*)
# ...or: 
mysql -u root -h localhost -p mysql
```

Show users along with host name where they are allowed to login
```bash
SELECT User, Host, authentication_string FROM mysql.user;
```

Finding out user rights
```bash
SELECT User, Db, Host from mysql.db;
```

Get current MySQL user
```bash
SELECT USER();
```

Find the privilege(s) granted to a particular MySQL user
```bash
SHOW GRANTS for 'wordpress'@'localhost';
```

Create new user
```bash
CREATE USER 'user'@'localhost';
```

Give the new user access to the database(s):
```bash
GRANT ALL PRIVILEGES ON *.* To 'user'@'localhost' IDENTIFIED BY 'password' WITH GRANT OPTION;
```
Now, the break down.
- GRANT - This is the command used to create users and grant rights to databases, tables, etc.
- ALL PRIVILEGES - This tells it the user will have all standard privileges. This does not include the privilege to use the GRANT command however.
- \*.\* - This instructions MySQL to apply these rights for use in all databases. You can replace the * with specific table names or store routines if you wish.
- TO 'user'@'hostname' - 'user' is the username of the user account you are creating. Note: You must have the single quotes in there. 'hostname' tells MySQL what hosts the user can connect from. If you only want it from the same machine, use localhost
- IDENTIFIED BY 'password' - As you would have guessed, this sets the password for that user.

<br><br>
# Importing test data

The codespace comes with a predefined data set to load your dfatabase with, you you can upload your own .sql database exports if you like.

Any .sql data files should be placed in .devcontainer/mysql folder.

To restore (or reset) the wordpress database from an .sql file:

```bash
mysql -u root -p < .devcontainer/mysql/data.sql
# (if prompted for password, just hit *Enter*)
```

<br><br>
# phpMyAdmin

When enabled, phpMyAdmin will be installed in a password-protected folder with id = *vipgo* and pwd=<randomly generated password>.

Once accessed, phpMyAdmin will automatically connect to the database *wordpress* as user *wordpress@localhost*. 

If needed, you can increase the priviledges of user *wordpress@localhost*, see section **"Managing MariaDB"** for description how to GRANT user priviledges. This, however, will not extend the database list in phpMyAdmin to other databases that *wordpress@localhost* may be authorized to use. This is because the config.inc.php of phpMYAdmin is configured with only_db option.


```bash 
/* phpMyAdmin configuration snippet */

$cfg['Console']['Mode'] = 'collapse';
$cfg['Server']['hide_db'] = '';
$cfg['Server']['only_db'] = 'wordpress';
```

Unfortunately, there's no easy way to change this. In VIP Codespaces, phpMyAdmin installation is part of a preconfigured feature bundled into the container image, and its files are not exposed in the workspace by default.




<br><br>
# References/documentation

- Wordpress VIP Codespaces at Github: https://github.com/Automattic/vip-codespaces
- Wordpress VIP Codespaces documentaiton: https://docs.wpvip.com/local-development/github-codespaces/
- Wordpress CLI commands reference https://developer.wordpress.org/cli/commands/
- MySQL CLI https://dev.mysql.com/doc/refman/8.4/en/mysql.html


