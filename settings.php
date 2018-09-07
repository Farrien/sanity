<?php

use Helper\Configurator;
Configurator::initConfig('app_config.ini');

define('TEMPLATES_DIR', $_SERVER['DOCUMENT_ROOT'] . '/templates/');
define('CONTROLLER_DIR', $_SERVER['DOCUMENT_ROOT'] . '/vc/');
define('VIEW_DIR', $_SERVER['DOCUMENT_ROOT'] . '/public/');