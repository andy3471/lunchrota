# Installation

We recommend that you read the [Laravel Deployment Docs](https://laravel.com/docs/6.x/deployment) before proceeding

# Ubuntu

## Requirements

You require PHP7+, MySQL (Or an Alternative DB Server supported by laravel), A Web Server (We will be using Apache), and Composer.

`sudo apt get install apache2 mysql-server php-pear php-fpm php-dev php-zip php-curl php-xmlrpc php-gd php-mysql php-mbstring php-xml libapache2-mod-php composer`

This guide assumes that you have already created the MySQL database.

## Install

### LunchRota

Clone laravel into a web folder, for example (/var/www/lunchrota):
`cd /var/www`

You can transfer the files one of two ways, cloing the repository, or downloading the latest release and copying the folder to the server. here we will be using git to clone the repository.

Install git:  
`sudo apt get install git`

Clone the git repository:  
`git clone github.com/andy3471/lunchrota.git`

Go Into Directory (Or open folder in VS Code, and use terminal -> new terminal):  
`cd lunchrota`

Install Composer Dependancies:  
`composer install --optimize-autoloader --no-dev`

Copy .env.example File:  
`cp .env.example .env`

You will need to edit the .env file to set your connection string settings:  
`nano .env`

Enter the DB username, password and server that you have set up. IPlease see the [Configuration Guide](./CONFIG.md) to set up your settings.

Build the database:  
`php artisan migrate`

Generate Key:  
`php artisan key:generate`

Cache the settings:  
`php artisan optimize`

### Scheduler

You'll need to set up Cron for the scheduler. To edit the cron file, run:  
`crontab -e`

Add the following line to the Cron file, being sure to update the project folder if you have installed elsewhere:  
`* * * * * cd /var/www/lunchrota && php artisan schedule:run >> /dev/null 2>&1`

### Configure Apache

You'll need to configure Apache (or alternative) to use the Public directory. To do so, you'll need to either create a new site, or edit the default one in Apache. In this guide we'll edit the default.

`cd /etc/apache2/sites-available`

edit the default site file:  
`sudo nano 000-default.conf`

Set the document root to the public folder created above, for example:  
`DocumentRoot /var/www/lunchrota/public`

Restart Apache  
`sudo service apache2 restart`

### Updating

We recommend you take a full back up of the site files and the database before running an update.

This guide assumes you are using git for version management. If you have manually downloaded the files on the initial install, then you can download the new release from github manually again, and overwrite the files. In our case, we will pull the latest version:  
`cd /var/www/lunchrota`  
`git pull`

We then need to update the database:  
`php artisan migrate`

We should then clear the cache, and cache any new settings:  
`php artisan optimize`

The upgrade should now be complete

# Windows

Installation instructions to be added

# Config

The site should now work. Any issues then please feel free to raise an issue on [GitHub](https://github.com/andy3471/lunchrota/issues/new/choose). Please see the [Configuration Guide](./CONFIG.md) to set up your settings.
