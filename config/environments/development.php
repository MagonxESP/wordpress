<?php
/**
 * Development environment config
 *
 * @package alexsancho/wp-docker
 */

use Roots\WPConfig\Config;

ini_set( 'display_errors', '1' );
set_time_limit( 90 );

Config::define('SAVEQUERIES', true);
Config::define('WP_DEBUG', true);
Config::define('WP_DEBUG_DISPLAY', false);
Config::define('WP_DEBUG_LOG', true);
Config::define('CONCATENATE_SCRIPTS', false);
Config::define('COMPRESS_SCRIPTS', false);
Config::define('COMPRESS_CSS', false);

/** Enable plugin and theme updates and installation from the admin */
Config::define('DISALLOW_FILE_MODS', false);

/** ACF */
Config::define('ACF_LITE', false);

/** WordPress Development Environment */
Config::define('WP_LOCAL_DEV', true);

Config::define('FORCE_SSL', false);
Config::define('FORCE_SSL_ADMIN', false);
Config::define('FORCE_SSL_LOGIN', false);