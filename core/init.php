<?php
/**
 * core/init.php
 * ---------------------------------------------------------------------
 * Single entry point every root-level route file includes before
 * dispatching to a Controller. Defines the path constants used
 * throughout app/Models, app/Views and app/Controllers so none of
 * those files need to guess where they live relative to each other.
 *
 * This file intentionally does NOT call session_start() or send any
 * headers — individual controllers still control that themselves,
 * exactly like the original flat-PHP pages did, so behavior stays
 * identical to before the MVC conversion.
 */

define('ROOT_PATH', dirname(__DIR__));
define('APP_PATH', ROOT_PATH . '/app');
define('MODELS_PATH', APP_PATH . '/Models');
define('VIEWS_PATH', APP_PATH . '/Views');
define('CONTROLLERS_PATH', APP_PATH . '/Controllers');
define('HELPERS_PATH', APP_PATH . '/Helpers');
define('PHPMAILER_PATH', APP_PATH . '/phpmailer');

require_once __DIR__ . '/Controller.php';
