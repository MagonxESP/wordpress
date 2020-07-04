<?php
/**
* Autoload composer packages & Bootstrap WordPress settings from ../config/
*/
require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/config/application.php';
require_once ABSPATH . 'wp-settings.php';