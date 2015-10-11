<?php

$start = microtime(TRUE);

/**********************************************************
 * PHP ERROR REPORTING LEVEL
 */
error_reporting(E_ALL ^ E_DEPRECATED);
date_default_timezone_set('Europe/London');

/**********************************************************
 * DEFINE APPLICATION CONSTANTS
 */
define('SERVER', filter_input(INPUT_SERVER, 'HTTP_HOST', FILTER_SANITIZE_STRING));
define('DOMAIN',  'decimill');
define('MAINURL',  'http://' . DOMAIN . '/');
define('CODEBASE',  '');
define('SELF',      'index.php');
define('BASEPATH',  'C:/dev/projects/decimill/decimill-web-frontend/');
define('SYSPATH',   BASEPATH . 'system/');
define('APPPATH',   BASEPATH . 'application/');
define('BASEURL',   'http://' . SERVER . '/' . (defined('CODEBASE') ? CODEBASE : '/'));
define('TEMP', 'C:/Temp/');

require_once SYSPATH . 'codelite/CodeLite.php';

/* End of file index.php */
/* Location: /index.php */