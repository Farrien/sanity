<?php
# Stop if this is direct call
defined('SN_Start') or header('HTTP/1.1 404 Not Found');

use Helper\Configurator;
Configurator::initConfig('app_config.ini');

define('TEMPLATES_DIR', $_SERVER['DOCUMENT_ROOT'] . '/templates/');
define('CONTROLLER_DIR', $_SERVER['DOCUMENT_ROOT'] . '/vc/');
define('VIEW_DIR', $_SERVER['DOCUMENT_ROOT'] . '/public/');