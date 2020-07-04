# Wordpress base

WARNING: The app/themes directory is empty, you need install a theme after cloning.

* Install wordpress and plugins
```sh
$ composer install
```

* Create ```.env``` file
```sh
$ cp .env.example .env
```

* Create a database

* Set the domain and database on ```.env``` files
```dotenv
DB_NAME=databasename
DB_USER=root
DB_PASSWORD=root
DB_HOST=127.0.0.1

WP_HOME=http://domain.local
WP_SITEURL=http://domain.local

COOKIE_DOMAIN=.domain.local
COOKIEHASH=domain.local
DOMAIN_CURRENT_SITE=domain.local
```