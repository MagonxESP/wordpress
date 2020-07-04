# Wordpress
Wordpress base using composer for manage dependencies, themes and plugins.

## Create the project

1. Create wordpress project
    ```sh
    $ composer create-project magonxesp/wordpress myproject
    ```
2. Create ```.env``` file
    ```sh
    $ cp .env.example .env
    ```
3. Create database
4. Set the domain and database on ```.env``` files
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
