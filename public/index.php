<?php

$craftRoot = realpath(dirname(__DIR__).'/craft');

define('CRAFT_ENVIRONMENT', getenv('CRAFT_ENVIRONMENT') ?: 'production');
define('CRAFT_BASE_PATH', getenv('CRAFT_BASE_PATH') ?: $craftRoot.'/');
define('CRAFT_APP_PATH', getenv('CRAFT_APP_PATH') ?: CRAFT_BASE_PATH.'app/');
define('CRAFT_FRAMEWORK_PATH', getenv('CRAFT_FRAMEWORK_PATH') ?: CRAFT_APP_PATH.'framework/');
define('CRAFT_CONFIG_PATH', getenv('CRAFT_CONFIG_PATH') ?: CRAFT_BASE_PATH.'config/');
define('CRAFT_PLUGINS_PATH', getenv('CRAFT_PLUGINS_PATH') ?: CRAFT_BASE_PATH.'plugins/');
define('CRAFT_STORAGE_PATH', getenv('CRAFT_STORAGE_PATH') ?: CRAFT_BASE_PATH.'storage/');
define('CRAFT_TEMPLATES_PATH', getenv('CRAFT_TEMPLATES_PATH') ?: CRAFT_BASE_PATH.'templates/');
define('CRAFT_TRANSLATIONS_PATH', getenv('CRAFT_TRANSLATIONS_PATH') ?: CRAFT_BASE_PATH.'translations/');
define('CRAFT_VENDOR_PATH', getenv('CRAFT_VENDOR_PATH') ?: CRAFT_APP_PATH.'vendor/');

require realpath(CRAFT_VENDOR_PATH.'autoload.php');
$index = realpath(CRAFT_APP_PATH.'index.php');

if (!is_file($index)) {
    if (function_exists('http_response_code')) {
        http_response_code(503);
    }

    $msg = 'Could not find your craft/ folder. ';
    $msg .= 'Please ensure that <strong><code>$craftRoot</code></strong> is set correctly in '.__FILE__;
    exit($msg);
}

require_once $index;
