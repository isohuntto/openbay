<?php
return [
    'bootstrap' => ['frontend\components\HandlerEvent', 'search'],
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
        'i18n' => [
            'translations' => [
                'app*' => [
                    'class' => 'yii\i18n\PhpMessageSource',
                    'sourceLanguage' => 'en',
                    'fileMap' => array(
                        'app' => 'app.php',
                    ),
                ],
                'torrent*' => [
                    'class' => 'yii\i18n\PhpMessageSource',
                    'sourceLanguage' => 'en',
                    'fileMap' => array(
                        'torrent' => 'torrent.php',
                    ),
                ],
                'comment*' => [
                    'class' => 'yii\i18n\PhpMessageSource',
                    'sourceLanguage' => 'en',
                    'fileMap' => array(
                        'comment' => 'comment.php',
                    ),
                ],
                'rating*' => [
                    'class' => 'yii\i18n\PhpMessageSource',
                    'sourceLanguage' => 'en',
                    'fileMap' => array(
                        'rating' => 'rating.php',
                    ),
                ],
                'complain*' => [
                    'class' => 'yii\i18n\PhpMessageSource',
                    'sourceLanguage' => 'en',
                    'fileMap' => array(
                        'complain' => 'complain.php',
                    ),
                ],
            ],
        ],
    ],
    'modules' => [
        'torrent' => 'frontend\modules\torrent\Module',
        'search' => 'frontend\modules\search\Module',
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
        'languageReport' => [
            'class' => 'frontend\modules\languageReport\LanguageReportModule',
            'recordModel' => \common\models\torrent\Torrent::className(),
            'salt' => ''
        ],
    ],
];