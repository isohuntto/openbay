<?php

return array(
    '' => 'main/index',
    'search' => 'main/search',
    'browse' => array('main/browse', 'urlSuffix' => '/'),
    'recent' => 'main/recent',
    'torrent/<id:\d+>/<name:.*>' => 'main/torrent',

    '<controller:\w+>' => '<controller>/index',
    '<controller:\w+>/<id:\d+>' => '<controller>/view',
    '<controller:\w+>/<action:\w+>/<id:\d+>' => '<controller>/<action>',
    '<controller:\w+>/<action:\w+>' => '<controller>/<action>',
);
