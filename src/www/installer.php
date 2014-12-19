<?php

$directories = array(__DIR__ . '/assets', __DIR__ . '/../protected/runtime');

foreach($directories as $directory) {
    if (!is_dir($directory)) mkdir($directory);
}

$config = array(
    'basePath' => __DIR__ . '/../protected',
    'modules' => array(
        'installer'=>array(
            'class' => 'application.installer.InstallerModule',
        ),
    ),
    'components' => array(
        'urlManager' => array(
            'urlFormat' => 'path',
            'showScriptName' => false,
            'caseSensitive' => false,
            'rules' => array(
                '/' => 'installer',
                'installer/<controller:\w+>'=>'installer/<controller>',
                'installer/<controller:\w+>/<action:\w+>/<id:\d+>' => '<controller>/<action>',
                'installer/<controller:\w+>/<action:\w+>' => 'installer/<controller>/<action>',
            )
        ),
        'request' => array(
            'class' => 'application.components.AHttpRequest'
        ),
    )
);

return $config;