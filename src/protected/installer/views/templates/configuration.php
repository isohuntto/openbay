<?= "<?php\n"; ?>

return array(
    'name' => '<?= $applicationName; ?>',
    'theme' => 'oldpiratebay',
    <?php if ($log): ?>
    'preload' => array('log'),
    <?php endif; ?>
    'import' => array(
        'application.helpers.*',
    ),
    'basePath' => __DIR__ . DIRECTORY_SEPARATOR . '..',
    'language' => 'en',
    'sourceLanguage' => 'en',
    'import' => array(
        'application.components.*',
        'application.models.*',
        'ext.ESphinxQL.*'
    ),
    'components' => array(
        'db' => array(
            'connectionString' => '<?= $db['connectionString'] ?>',
            'username' => '<?= $db['username'] ?>',
            'password' => '<?= $db['password'] ?>',
            'schemaCachingDuration' => '86400',
            'charset' => 'utf8',
            'enableProfiling' => true
        ),
        'cache' => array(
            'class' => '<?= $cacheClass ?>',
        ),
        'sphinx' => array(
            'class' => 'system.db.CDbConnection',
            'connectionString' => '<?= $sphinx['connectionString'] ?>',
            'queryCacheID' => 'cache'
        ),
        'request' => array(
            'class' => 'application.components.AHttpRequest'
        ),
        'clientScript' => array(
            'scriptMap' => array(
                'jquery.min.js' => '//ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js',
            ),
            'packages' => array(
                'base' => array(
                    'baseUrl' => '/css/',
                    'css' => array(
                        'opb.css',
                    ),
                ),
            ),
        ),
        'urlManager' => array(
            'urlFormat' => 'path',
            'showScriptName' => false,
            'caseSensitive' => false,
            'rules' => require(__DIR__ . '/rules.php')
        ),
        'errorHandler' => array(
            'errorAction' => 'main/error'
        ),
        <?php if ($log): ?>
        'log' => array(
            'class' => 'CLogRouter',
            'routes' => array(
                array(
                    'class' => 'CFileLogRoute',
                    'levels' => 'error, warning'
                )
            )
        ),
        <?php endif; ?>
        'session' => array(
            'sessionName' => 'MYSESSIONID'
        ),
        'format' => array(
            'class' => 'application.components.Formatter'
        ),
    ),
    'params' => array(
        'adminEmail' => 'isohunt.to@gmail.com',
        'sphinx' => array(
            'indexes' => array(
                'torrents' => 'opbtorrents',
            ),
        ),
    ),
);