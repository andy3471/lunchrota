# LunchRota

![GitHub Workflow Status](https://img.shields.io/github/workflow/status/andy3471/lunchrota/build%20our%20image)
![Docker Pulls](https://img.shields.io/docker/pulls/andy3471/lunchrota)

LunchRota is a complete grounds up rewrite of  Commrota (by Curtis Reet), which has been completely rewritten for the Laravel framework by Andrew Hargrave. The application is to be used by teams, in order to keep track of daily work roles, as well as claim available lunch slots. The original application was built on PHP5, and required further development, so I decided to rewrite this in Laravel to allow me to continue development of the application

The roles can be assigned to users either via a UI built with VueJS, or uploaded via CSV.

The site can be configured to either use a set number of available lunch slots, or be autocalculated using the number of user roles that are marked as 'available'. This is used, for example, if certain roles need to be on the phones, and you require a certain number of people who are on phones to be available at any time

LunchRota contains a full admin panel for editing Users, LunchSlots, Roles and User Roles. These use a Vue JS interface, to allow you to bulk edit.

![ScreenShot](https://raw.github.com/andy3471/rota/master/docs/img/lunchrota-home.jpg)
[Try Out the Demo](https://lunchrota.andyh.app)

## Technologies

Built on the Laravel PHP Framework, with Vue JS.

All development environments are running MySQL, Redis and Nginx. Laravel offers support for other DB and web servers, however these are untested.

## Install

We recommend installing Keyshare using Docker and Docker-compose. Please see the below example docker-compose file:

```yml
version: '3'
services:
  web:
    image: andy3471/lunchrota
    restart: unless-stopped
    tty: true
    ports:
      - "8002:80"
    environment:
      APP_KEY: base64:+7JBw8tEr0aalfJbXOzc6CDxbNKVAKYFEDzXWuVGEVU=
      DB_HOST: db
      DB_DATABASE: homestead
      DB_PASSWORD: secret
      DB_DATABASE: homestead
      APP_URL: http://lunchrota.com
      ASSET_URL: http://lunchrota.com
    volumes:
      - ./logs:/app/storage/logs
    depends_on:
      - db
      - redis
  scheduler:
    image: andy3471/lunchrota
    restart: unless-stopped
    tty: true
    environment:
      APP_KEY: base64:+7JBw8tEr0aalfJbXOzc6CDxbNKVAKYFEDzXWuVGEVU=
      DB_HOST: db
      DB_DATABASE: homestead
      DB_PASSWORD: secret
      DB_DATABASE: homestead
      CONTAINER_ROLE: scheduler
      APP_DEFAULT_ROLE: 'In Office'
    volumes:
      - ./logs:/app/storage/logs
    depends_on:
      - db
      - redis
  db:
    image: mysql:5.7.30
    restart: unless-stopped
    tty: true
    environment:
      MYSQL_DATABASE: homestead
      MYSQL_USER: homestead
      MYSQL_PASSWORD: secret
      MYSQL_ROOT_PASSWORD: secret
      SERVICE_TAGS: dev
      SERVICE_NAME: mysql
    volumes:
      - ./database/mysql:/var/lib/mysql
```
Once you have saved this docker-compose file, and run it, you should see the website on localhost:3473. Then register as a normal user, and run:

```sh
docker-compose exec lunchrota php artisan admin:make your@email.com
```
Sign out and back in, and you should now be an admin.

### Configuration

The below are all the environment variables that can be passed to the docker-compose file:

Variable | Description
------------ | -------------
APP_NAME | Title of the website
APP_ENV | Environment being run on, can be set to local for test environments
APP_KEY | Unique base64 string. Run ``` sudo docker run -e "CONTAINER_ROLE=keygen" -e "APP_ENV=local" andy3471/lunchrota ``` to generate one, and paste it in.
APP_DEBUG | Enables debug logging
APP_URL | External URL you will access the site from
ASSET_URL | External URL that assets are loaded from
REDIRECT_HTTPS | Boolean value, Used if you're running keyshare behind a proxy, if the site is using HTTP and the proxy is using HTTPS.
APP_REGISTER_ENAMED | Boolean, whether users can register
APP_RESET_PASSWORDS_ENABLED | Boolean, allows users to reset their own passwords
APP_ROLES_ENABLED | Boolean, disabled or enables setting users as specific daily roles. Disable if you just want this to be a way of claiming lunch slots.
APP_DEFAULT_ROLE | String, must match a role created already. Must be asigned to both the web server and the scheduler.
LUNCH_SLOT_CALCULATED | Boolean, roles must be enabled. This will make the available users are lunch calculate automatically. This is designed for instances where a certain number of people need to be on the phones at one time. This will look at the number of users with an available role (as in, a role that means they are available on the phones), and then calculate how many people can go at once, depending on the ratio.
LUNCH_SLOT_RATIO | To be used with LUNCH_SLOT_CALCULATED, defaults at 0.33, this means 1/3 of users with an available role can book one lunch slot. This is too many users who need to be on the phones from booking their own slot.
DB_HOST | MySQL host, usually the container name of the SQL server
DB_PORT | Defaults to 3306, only override if you're using your own DB server
DB_DATABASE | Name of the database
DB_USERNAME | Username for the DB
DB_PASSWORD | Password for the DB user
MAIL_HOST | SMTP host
MAIL_PORT | SMTP Port
MAIL_USERNAME | Email Username
MAIL_PASSWORD | Email Pasword
MAIL_ENCRYPTION | can be set to SSL or TLS, if your mail server requires it.
MAIL_FROM_NAME | Name that emails appear to be sent from.

### Reverse Proxy
You can run the site behind an NGINX reverse proxy, using a config like:
```conf
server {
    server_name 360nohope.co.uk www.360nohope.co.uk;

    location / {
        proxy_pass http://ip:port;
        proxy_set_header Host 360nohope.co.uk
        proxy_set_header X-Forwarded-Proto https;
    }
}
```

If your proxy erver is using HTTPS, be sure to set the REDIRECT_HTTPS environment variable to true. You will also need to set APP_URL to the external URL, and may also need to set ASSET_URL to the same.

### Manual Install

[Manual install guide](docs/INSTALL.md)  
[Configuration guide](docs/CONFIG.md)

## Contributing

[Setting up a dev environment](docs/DEVENVIRONMENT.md)  
[Debugging](docs/DEBUG.md)  
[Contribution guidelines](docs/CONTRIBUTING.md)
