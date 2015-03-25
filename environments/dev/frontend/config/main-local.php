<?php

$config = [
    'bootstrap' => [
        'search',
        'frontend\components\HandlerEvent',
    ],
    'components' => [
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'class' => 'frontend\components\RealIpRequest',
            'cookieValidationKey' => '',
        ],
        'view' => [
            'theme' => [
                'pathMap' => [
                    '@app/views' => '@frontend/themes/newopb/views',
                    '@app/modules' => '@frontend/themes/newopb/modules',
                ],
                'baseUrl' => '@web/themes/basic',
            ],
        ],
    ],
    'modules' => [
        'torrent' => 'frontend\modules\torrent\Module',
        'search' => 'frontend\modules\search\Module',
        'torrent_scraper' => 'common\modules\torrent_scraper\Module',
        'comment' => [
            'class' => 'frontend\modules\comment\CommentModule',
            'recordModel' => \common\models\torrent\Torrent::className(),
            'salt' => '',
            'reCaptchaSiteKey' => '',
            'reCaptchaSecretKey' => ''
        ],
        'rating' => [
            'class' => 'frontend\modules\rating\RatingModule',
            'min' => 1,
            'max' => 5,
            'step' => 1,
            'recordModel' => \common\models\torrent\Torrent::className(),
            'salt' => ''
        ],
        'complain' => [
            'class' => 'frontend\modules\complain\ComplainModule',
            'recordModel' => \common\models\torrent\Torrent::className(),
            'salt' => ''
        ],
        'userprofile' => [
            'class' => 'frontend\modules\userprofile\UserProfileModule',
        ],
        'feed' => [
            'class' => 'frontend\modules\feed\FeedModule',
        ],
    ],
];

if (!YII_ENV_TEST) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
        'allowedIPs' => ['*'],
    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
        'generators' => [
            'sphinxModel' => [
                'class' => 'yii\sphinx\gii\model\Generator'
            ],
        ],
    ];
}

return $config;
