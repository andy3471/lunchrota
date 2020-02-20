# Configuration

## About

All system settings are stored in the .env file, this guide will go through any of the settings, and explain how they are configured.

Please keep in mind that settings are cached, and any time you update them, you should update the cache:  
`php artisan optimize`

## Config

### APP_NAME

The name of the site, can be any string. Should be in single quotes if there is a space in it.

### APP_ENV

Should not change, laravel default setting.

### APP_KEY

Generated using  
`php artisan key:generate`

Should not be changed manually, but must not be null.

### APP_DEBUG

Enhanced debugging. Recommended to be false for live environments.

### APP_URL

The full URL of the site, for example https://rotademo.andyh.app

### APP_DEMO_MODE

Enabled demo mode, which does a nightly data refresh. This should almost always be false.

### LOG_CHANNEL

Configures how LunchRota logs it's config. Can be configured to any [laravel supported logging driver](https://laravel.com/docs/6.x/logging)

### CACHE_DRIVER

Configures how LunchRota caches. This can be configured to any [laravel supported logging driver](https://laravel.com/docs/6.x/cache). We recommend installing and using redis. 

### QUEUE_CONNECTION

Not currently in use

### BROADCAST_DRIVER

Not currently in use

### SESSION_DRIVER

How sessions will be stored, we support all [laravel supported session drivers](https://laravel.com/docs/6.x/session).

### SESSION_LIFETIME

How long sessions last, recommended is 120 minutes.

### APP_REGISTER_ENABLED
Enable user registrations, and register button. If not, the admin can manually add these. Should be true to start with, and can be later turned off.

### APP_RESET_PASSWORD_ENABLED

Allow password resets, requires the SMTP set up below

### APP_ROLES_ENABLED

Enables or disabled roles. Only disable if you only want to use LunchRota as a system to picking and chosing lunch rotas.

### APP_DEFAULT_ROLE

The default role for the scheduler. This is the role that users will be before it has been manually updated.

### APP_FOOTER_TEXT

The text that appears in the footer.


## Lunch Slots

### LUNCH_SLOT_CALCLULATED
Configures if the lunch slots should be calculated by the number of 'Available' roles. This is recommended. If you set to false, you can manually set how many users can configure lunch slots. if you have "App_roles_enabled" set to false, this must also be false.

### LUNCH_SLOT_CALCULATED_RATIO=0.33
Only used if lunch_slot_calculated is true, this will set the ratio of Available users that can take lunch slots. 0.33 means that for every 3 users available, 1 user can be on lunch at a time.

## Database Connections

We support any [laravel supported DB driver](https://laravel.com/docs/6.x/database). We recommend MySQL.

### DB_CONNECTION

Driver Name, as in the above laravel guide.

### DB_HOST

DB Server Name

### DB_PORT

DB Port

### DB_DATABASE

Database Name

### DB_USERNAME

Database username

### DB_PASSWORD

Database password

## Redis

If you use redis for any of the above Session/Cache drivers, this will ned to be configured. This will not need changing if you have installed locally, but you will need to update the following strings if you are hosting redis elsewhere:

### REDIS_HOST

Hostname of redis server

### REDIS_PASSWORD

Redis server password, if configured

### REDIS_PORT

Port for redis

## Email

In order to use password resets, you should set up an SMTP server, the following details should be provided from your email provider. You can set up [Gmail](https://stackoverflow.com/questions/32515245/how-to-to-send-mail-using-gmail-in-laravel-5-1)

### MAIL_DRIVER

Should always be SMTP for live

### MAIL_HOST

Provided by your SMTP provider

### MAIL_PORT

Provided by your SMTP provider

### MAIL_USERNAME

Provided by your SMTP provider

### MAIL_PASSWORD

Provided by your SMTP provider

### MAIL_ENCRYPTION

Provided by your SMTP provider

### MAIL_FROM_NAME

The name of the sender when emails are received (Normally the site name)
