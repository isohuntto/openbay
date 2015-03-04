<?php

return [
    'components' => [
        'db' => [
            'class' => 'yii\db\Connection',
            'dsn' => 'mysql:host=127.0.0.1;dbname=opb',
            'username' => 'opb',
            'password' => 'opb',
            'charset' => 'utf8',
            'schemaCache' => 'cache',
            'enableSchemaCache' => true,
            'schemaCacheDuration' => 300,
            'queryCache' => true,
            'queryCacheDuration' => 5,
        ],
        'sphinx' => [
            'class' => 'yii\sphinx\Connection',
            'dsn' => 'mysql:host=127.0.0.1;port=9306;',
            'username' => '',
            'password' => '',
            'schemaCache' => 'cache',
            'enableSchemaCache' => true,
        ],
        'cache' => [
            'class' => 'yii\redis\Cache',
            'keyPrefix' => 'nbp_',
            'serializer' => array(
                'igbinary_serialize',
                'igbinary_unserialize'
            ),
            'redis' => [
                'hostname' => 'localhost',
                'port' => 6379,
                'database' => 5,
            ],
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            'viewPath' => '@common/mail',
            'useFileTransport' => false,
            'transport' => [
                'class' => 'Swift_SmtpTransport',
                'host' => 'host',
                'username' => 'username',
                'password' => 'password',
                'port' => '587',
                'encryption' => 'tls'
            ],
        ],
    ],
];
