<?php
    $cs = Yii::app()->clientScript;
    $cs->coreScriptPosition = CClientScript::POS_HEAD;
    $cs->scriptMap = array(
        'jquery.js' => '//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js'
    );

    $baseUrl = $this->module->assetsUrl;
    $cs->registerCoreScript('jquery');
    $cs->registerScriptFile($baseUrl . '/js/bootstrap.min.js', CClientScript::POS_HEAD);
    //$cs->registerScriptFile($baseUrl . '/js/docs.min.js', CClientScript::POS_HEAD);
    $cs->registerScriptFile($baseUrl . '/js/bootstrap-switch.min.js', CClientScript::POS_HEAD);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= CHtml::encode($this->pageTitle); ?></title>

    <!-- Bootstrap -->
    <link href="<?= $this->module->assetsUrl; ?>/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?= $this->module->assetsUrl; ?>/css/bootstrap-theme.min.css" rel="stylesheet">
    <link href="<?= $this->module->assetsUrl; ?>/css/docs.min.css" rel="stylesheet">
    <link href="<?= $this->module->assetsUrl; ?>/css/bootstrap-switch.min.css" rel="stylesheet">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body  data-spy="scroll" data-target="#sidebar">
    <header class="navbar navbar-static-top bs-docs-nav">
        <div class="container">
            <div class="navbar-header">
                <a href="#" class="navbar-brand">
                    <i></i>
                    MyPirateBay
                </a>
            </div>
        </div>
    </header>
    <?= $content; ?>
    <hr/>
    <footer>
        <div class="container">
            <div class="text-center">
                <p>
                    Created with love and passion to change the world for the best, by <a href="https://isohunt.to" target="_blank">isohunt.to</a>
                </p>
                <p>Currently v1.0.0</p>
            </div>
        </div>
    </footer>
</body>
</html>