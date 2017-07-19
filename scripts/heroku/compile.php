<?php

$appDir = getenv('HEROKU_APP_DIR');
$craftDir = 'craft';
$vendorDir = 'vendor';
$configDir = $craftDir.'/config';

$appId = getenv('CRAFT_APP_ID');
$craftEnv = getenv('CRAFT_ENVIRONMENT');
$licenseKey = getenv('CRAFT_LICENSE_KEY');
$licenseFile = "{$configDir}/license.key";
$siteUrl = getenv('CRAFT_SITEURL');
$validationKey = getenv('CRAFT_VALIDATION_KEY');

if ($licenseKey) {
    file_put_contents($licenseFile, $licenseKey);
}

$dbUrl = getenv('JAWSDB_MARIA_URL');
$db    = parse_url($dbUrl);
$redisUrl = getenv('REDIS_URL');
$redis    = parse_url($redisUrl);

// Get service properties
$redisHost      = $redis['host'];
$redisPassword  = $redis['pass'];
$redisPort      = $redis['port'];
$dbName         = ltrim($db['path'], '/');
$dbHost         = $db['host'];
$dbPassword     = $db['pass'];
$dbUser         = $db['user'];
$dbPort         = $db['port'];

$devMode = $craftEnv !== 'production';
$overrideSession = "tcp://{$redisHost}:{$redisPort}?auth={$redisPassword}";

function reconfigure($name, $confDir, $conf)
{
    $file = "$confDir/$name.php";
    $oldConf = include $file;

    echo "$name (old):\n";
    echo var_export($oldConf)."\n";

    $newConf = array_merge($oldConf, $conf);

    echo "$name (new):\n";
    echo var_export($newConf)."\n";

    $newFileContent = "<?php\n\nreturn " . var_export($newConf, true) . ";";
    file_put_contents($file, $newFileContent);
}

reconfigure('general', $configDir, [
    'appId' => $appId,
    'devMode' => $devMode,
    'overridePhpSessionLocation' => $overrideSession,
    'siteUrl' => $siteUrl,
    'validationKey' => $validationKey,
]);

reconfigure('db', $configDir, [
    'database' => $dbName,
    'password' => $dbPassword,
    'port' => $dbPort,
    'server' => $dbHost,
    'user' => $dbUser,
]);

reconfigure('rediscache', $configDir, [
    'hostname' => $redisHost,
    'password' => $redisPassword,
    'port' => $redisPort,
]);
