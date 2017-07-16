<?php

$appId                      = getenv('CRAFT_APP_ID')            ?: 'craftcms';
$cpTrigger                  = getenv('CRAFT_CP_TRIGGER')        ?: 'admin';
$devMode                    = getenv('CRAFT_DEV_MODE')          ?: false;
$environment                = getenv('CRAFT_ENVIRONMENT')       ?: 'production';
$overrideSessionLocation    = getenv('CRAFT_OVERRIDE_SESSION')  ?: 'auto';
$validationKey              = getenv('CRAFT_VALIDATION_KEY')    ?: null;

return [
    'allowAutoUpdates'              => false,
    'appId'                         => $appId,
    'cacheMethod'                   => 'redis',
    'cpTrigger'                     => $cpTrigger,
    'devMode'                       => $devMode,
    'enableCsrfProtection'          => true,
    'errorTemplatePrefix'           => '_errors/',
    'omitScriptNameInUrls'          => true,
    'overridePhpSessionLocation'    => $overrideSessionLocation,
    'preventUserEnumeration'        => true,
    'usePathInfo'                   => true,
    'validationKey'                 => $validationKey,
];
