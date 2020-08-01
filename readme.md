# LunchRota

![GitHub Workflow Status](https://img.shields.io/github/workflow/status/andy3471/lunchrota/build%20our%20image)
![Docker Pulls](https://img.shields.io/docker/pulls/andy3471/lunchrota)

LunchRota is a ground up rewrite of an Application that was created for our service desk by Curtis Reet. The application is to be used by teams, in order to keep track of daily work roles, as well as claim available lunch slots. The original application was built on PHP5, and required further development, so I decided to rewrite this in Laravel to allow me to continue development of the application

The roles can be assigned to users either via a UI built with VueJS, or uploaded via CSV.

The site can be configured to either use a set number of available lunch slots, or be autocalculated using the number of user roles that are marked as 'available'. This is used, for example, if certain roles need to be on the phones, and you require a certain number of people who are on phones to be available at any time

LunchRota contains a full admin panel for editing Users, LunchSlots, Roles and User Roles. These use a Vue JS interface, to allow you to bulk edit.

![ScreenShot](https://raw.github.com/andy3471/rota/master/docs/img/lunchrota-home.jpg)
[Try Out the Demo](https://lunchrota.andyh.app)

## Technologies

Built on the Laravel PHP Framework, with Vue JS.

All development environments are running MySQL, Redis and Nginx. Laravel offers support for other DB and web servers, however these are untested.

## Install

[Install Guide](docs/INSTALL.md)  
[Configuration Guide](docs/CONFIG.md)

## Contributing

[Setting up a dev environment](docs/DEVENVIRONMENT.md)  
[Debugging](docs/DEBUG.md)  
[Contribution guidelines](docs/CONTRIBUTING.md)
