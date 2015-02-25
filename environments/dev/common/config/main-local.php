<?php

return [
    'components' => [
        'db' => [
            'class' => 'yii\db\Connection',
            'dsn' => 'mysql:host=localhost;dbname=npb',
            'username' => 'root',
            'password' => '',
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
