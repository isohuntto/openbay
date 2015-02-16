<?php
return [
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'components' => [
        'cache' => [
            'class' => 'yii\redis\Cache',
            'keyPrefix' => 'nbp_',
            'serializer' => array(
                'igbinary_serialize',
                'igbinary_unserialize'
            ),
            'redis' => [
                'hostname' => 'localhost',
                'port' => 6350,
                'database' => 5,
            ],
        ],
    ],
];
