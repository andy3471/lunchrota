# LunchRota

Manage daily work roles and lunch slot bookings for your team.

## About

LunchRota is a team management tool for tracking daily work roles and claiming available lunch slots. It supports configurable lunch slot limits — either a fixed number or auto-calculated based on role availability.

Built with [Laravel](https://laravel.com), [Vue.js](https://vuejs.org), and [Inertia.js](https://inertiajs.com). It uses [Tailwind CSS](https://tailwindcss.com) for styling, [Filament](https://filamentphp.com) for the admin panel, and [Laravel Sail](https://laravel.com/docs/sail) for local development.

## Installation

This is a standard Laravel application. Follow the official Laravel documentation for installation and deployment:

- [Installation](https://laravel.com/docs/installation)
- [Configuration](https://laravel.com/docs/configuration)
- [Deployment](https://laravel.com/docs/deployment)

### Quick Start (Local Development)

```shell
# Clone the repo
git clone https://github.com/andy3471/lunchrota.git
cd lunchrota

# Install PHP dependencies
composer install

# Copy environment file and generate app key
cp .env.example .env
php artisan key:generate

# Start Sail
vendor/bin/sail up -d

# Install JS dependencies and build assets
vendor/bin/sail npm install
vendor/bin/sail npm run build

# Run migrations
vendor/bin/sail artisan migrate
```

## Contributing

Pull requests are welcome. For local development, use [Laravel Sail](https://laravel.com/docs/sail) to run the application.
