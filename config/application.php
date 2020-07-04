<?php
/**
 * This file contains WordPress config and replaces the usual wp-config.php
 *
 * @package alexsancho/wp-project
 */

use Dotenv\Dotenv;
use Roots\WPConfig\Config;

/** @var string Directory containing all of the site's files */
$root_dir = dirname(__DIR__);

if (file_exists($root_dir . '/.env')) {
    /** Use Dotenv to set required environment variables and load .env file in root */
    $dot_env = Dotenv::createUnsafeImmutable($root_dir);
    $dot_env->load();
    $dot_env->required(['DB_HOST', 'DB_NAME', 'DB_USER', 'DB_PASSWORD', 'WP_HOME', 'WP_SITEURL', 'DOMAIN_CURRENT_SITE']);
}

/** Play nice with wp-cli */
if (isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && 'https' === $_SERVER['HTTP_X_FORWARDED_PROTO']) {
    $_SERVER['HTTPS'] = 'on';
}

if (defined('WP_CLI') && WP_CLI && ! isset($_SERVER['HTTP_HOST'])) {
    $_SERVER['HTTP_HOST'] = getenv('DOMAIN_CURRENT_SITE', 'wp-cli.org');
}

if ( ! isset($_SERVER['HTTP_HOST']) && defined('DOING_ASYNC') && DOING_ASYNC) {
    $_SERVER['HTTP_HOST'] = getenv('DOMAIN_CURRENT_SITE');
}

/**
 * Set up our global environment constant
 * Default: production
 */
define('WP_ENV', strtolower(getenv('WP_ENV')) ?: 'production');

/** WordPress Development Environment */
Config::define('WP_LOCAL_DEV', false);

/** URLs */
Config::define('WP_HOME', getenv('WP_HOME'));
Config::define('WP_SITEURL', getenv('WP_SITEURL'));

/** Custom Content Directory */
define('SMART_PUBLIC_DIR', 'web');
define('SMART_ROOT', $root_dir);

Config::define('CONTENT_DIR', '/app');
Config::define('WP_CONTENT_DIR', $root_dir . Config::get('CONTENT_DIR'));
Config::define('WP_CONTENT_URL', Config::get('WP_HOME') . Config::get('CONTENT_DIR'));

if (is_dir(Config::get('WP_CONTENT_DIR') . '/tmp') && is_writable(Config::get('WP_CONTENT_DIR') . '/tmp')) {
    Config::define('WP_TEMP_DIR', Config::get('WP_CONTENT_DIR') . '/tmp');
}

Config::define('CACHE_DIR', Config::get('WP_CONTENT_DIR') . '/cache/');

/** DB settings */
Config::define('DB_NAME', getenv('DB_NAME'));
Config::define('DB_USER', getenv('DB_USER'));
Config::define('DB_PASSWORD', getenv('DB_PASSWORD'));
Config::define('DB_HOST', getenv('DB_HOST') ?: 'localhost');
Config::define('DB_CHARSET', 'utf8mb4');
Config::define('DB_COLLATE', 'utf8mb4_swedish_ci');

$table_prefix = getenv('DB_PREFIX') ?: 'wp_';

if ((bool)getenv('DB_USE_SSL')) {
    Config::define('MYSQL_CLIENT_FLAGS', MYSQLI_CLIENT_SSL);
    Config::define('MYSQL_SSL_CA', getenv('MYSQL_SSL_CA'));
    Config::define('MYSQL_CLIENT_FLAGS', MYSQLI_CLIENT_SSL | MYSQLI_CLIENT_SSL_DONT_VERIFY_SERVER_CERT);
}

/** Enable Page Cache */
Config::define('WP_CACHE', (bool)file_exists(Config::get('WP_CONTENT_DIR') . '/advanced-cache.php'));

/** Authentication Unique Keys and Salts */
Config::define('AUTH_KEY', getenv('AUTH_KEY'));
Config::define('SECURE_AUTH_KEY', getenv('SECURE_AUTH_KEY'));
Config::define('LOGGED_IN_KEY', getenv('LOGGED_IN_KEY'));
Config::define('NONCE_KEY', getenv('NONCE_KEY'));
Config::define('AUTH_SALT', getenv('AUTH_SALT'));
Config::define('SECURE_AUTH_SALT', getenv('SECURE_AUTH_SALT'));
Config::define('LOGGED_IN_SALT', getenv('LOGGED_IN_SALT'));
Config::define('NONCE_SALT', getenv('NONCE_SALT'));

Config::define('WP_CACHE_KEY_SALT', getenv('DOMAIN_CURRENT_SITE') ?: $_SERVER['HTTP_HOST']);

/** Always use HTTPS */
Config::define('FORCE_SSL', true);
Config::define('FORCE_SSL_ADMIN', true);
Config::define('FORCE_SSL_LOGIN', true);

/** Custom Settings */
Config::define('AUTOMATIC_UPDATER_DISABLED', true);
Config::define('DISABLE_WP_CRON', getenv('DISABLE_WP_CRON') ?: false);
/** Disable the plugin and theme file editor in the admin */
Config::define('DISALLOW_FILE_EDIT', true);
/** Disable plugin and theme updates and installation from the admin */
Config::define('DISALLOW_FILE_MODS', true);

/** Block External Connections */
Config::define('WP_HTTP_BLOCK_EXTERNAL', false);
/** Allow some hosts */
Config::define('WP_ACCESSIBLE_HOSTS', '*.wordpress.org,*.github.com,localhost');

/** Workaround for: Sorry, this file type is not permitted for security reasons.*/
Config::define('ALLOW_UNFILTERED_UPLOADS', true);

/** Multisite */
// Config::define( 'WP_ALLOW_MULTISITE', true );

Config::define('SUNRISE', false);

Config::define('MULTISITE', false);
Config::define('SUBDOMAIN_INSTALL', false);
Config::define('DOMAIN_CURRENT_SITE', getenv('DOMAIN_CURRENT_SITE'));
Config::define('PATH_CURRENT_SITE', '/');
Config::define('SITE_ID_CURRENT_SITE', getenv('SITE_ID_CURRENT_SITE') ?: 1);
Config::define('BLOG_ID_CURRENT_SITE', getenv('BLOG_ID_CURRENT_SITE') ?: 1);

Config::define('COOKIE_DOMAIN', getenv('COOKIE_DOMAIN'));
Config::define('COOKIEPATH', '/');
Config::define('SITECOOKIEPATH', '/');
Config::define('COOKIEHASH', md5(getenv('COOKIEHASH')));

Config::define('NOBLOGREDIRECT', getenv('WP_SITEURL'));

/**
 * Select default theme which is activated during project startup
 * Use this when the project has default theme to use.
 * Skip this define if this getenv is the default value
 */
if (getenv('WP_DEFAULT_THEME') && getenv('WP_DEFAULT_THEME') !== 'THEME' . 'NAME') {
    Config::define('WP_DEFAULT_THEME', getenv('WP_DEFAULT_THEME'));
}

/** Debugging Settings */
ini_set('display_errors', '0');

Config::define('WP_DEBUG', false);
Config::define('WP_DEBUG_DISPLAY', false);
Config::define('SCRIPT_DEBUG', false);
Config::define('CONCATENATE_SCRIPTS', true);
Config::define('COMPRESS_SCRIPTS', true);
Config::define('COMPRESS_CSS', true);

/**
 * Only keep the last 30 revisions of a post. Having hundreds of revisions of
 * each post might cause sites to slow down, sometimes significantly due to a
 * massive, and usually unnecessary bloating the wp_posts and wp_postmeta tables.
 */
Config::define('WP_POST_REVISIONS', getenv('WP_POST_REVISIONS') ?: 30);

/** Define memory limit so that wp-cli can use more memory than the default 40M */
Config::define('WP_MEMORY_LIMIT', getenv('PHP_MEMORY_LIMIT') ?: '128M');

/** Define max memory limit so that wp-admin can use more memory than the default 40M */
Config::define('WP_MAX_MEMORY_LIMIT', getenv('WP_MAX_MEMORY_LIMIT') ?: '256M');

/** Check for SMTP config */
if (getenv('WPMS_ON') === 'true') {
    Config::define('WPMS_ON', true);
    Config::define('WPMS_MAILER', getenv('WPMS_MAILER'));

    Config::define('WPMS_MAIL_FROM', getenv('WPMS_MAIL_FROM'));
    Config::define('WPMS_MAIL_FROM_FORCE', true); // True turns it on, false turns it off.
    Config::define('WPMS_MAIL_FROM_NAME', getenv('WPMS_MAIL_FROM_NAME'));
    Config::define('WPMS_MAIL_FROM_NAME_FORCE', true); // True turns it on, false turns it off.
    Config::define('WPMS_SET_RETURN_PATH', true); // Sets $phpmailer->Sender if true.

    if (getenv('WPMS_MAILER') === 'smtp' && getenv('WPMS_SSL')) {
        Config::define('WPMS_SSL', getenv('WPMS_SSL'));
        Config::define('WPMS_SMTP_HOST', getenv('WPMS_SMTP_HOST'));
        Config::define('WPMS_SMTP_PORT', getenv('WPMS_SMTP_PORT'));
    }

    if (getenv('WPMS_SMTP_AUTH') === 'true') {
        Config::define('WPMS_SMTP_AUTH', true);
        Config::define('WPMS_SMTP_USER', getenv('WPMS_SMTP_USER'));
        Config::define('WPMS_SMTP_PASS', getenv('WPMS_SMTP_PASS'));
    }
}

/** ACF */
Config::define('ACF_LITE', true);

/** WordPress Error Handler */
Config::define('RECOVERY_MODE_EMAIL', 'devxp@kingeclient.com');

/** Load custom configs according to WP_ENV environment variable */
$env_config = __DIR__ . '/environments/' . WP_ENV . '.php';

if (file_exists($env_config)) {
    include_once $env_config;
}

Config::apply();

/** Bootstrap WordPress */
if ( ! defined('ABSPATH')) {
    define('ABSPATH', $root_dir . '/wordpress/');
}
