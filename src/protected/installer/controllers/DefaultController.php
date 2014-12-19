<?php

class DefaultController extends CController
{
    public $layout = '/layouts/main';

    public function getPageTitle()
    {
        return 'Pirate Bay source codes';
    }

    public function actionIndex()
    {
        $errors = array();
        $requirements = array(
            'PDO' => extension_loaded("pdo"),
            'PDO_MYSQL' => extension_loaded("pdo_mysql")
        );

        $disableForm = !($requirements['PDO'] && $requirements['PDO_MYSQL']);

        if ($settings = Yii::app()->request->getPost("Settings")) {
            // Validation
            // Name
            if (!isset($settings['name']) || ! $settings['name'])
                $errors['name'] = true;

            // DB section
            if (!isset($settings['dbOurConfig']))
            {
                $dbParameters = array('dbHost', 'dbPort', 'dbName', 'dbUser', 'dbPassword');
                foreach($dbParameters as $dbParameter)
                {
                    if (!isset($settings[$dbParameter]) || !$settings[$dbParameter])
                        $errors[$dbParameter] = true;
                }
            }
            // Sphinx section
            if (!isset($settings['sphinxOurConfig']))
            {
                $dbParameters = array('sphinxHost', 'sphinxPort');
                foreach($dbParameters as $dbParameter)
                {
                    if (!isset($settings[$dbParameter]) || !$settings[$dbParameter])
                        $errors[$dbParameter] = true;
                }
            }

            if (count($errors) === 0) {
                // Receive default remote settings
                $defaultComponents = json_decode(file_get_contents("http://isohunt.to/openbay/config.json"), true);
                $defaultComponents = $defaultComponents['components'];

                // Build params
                $params = array(
                    'applicationName' => CHtml::encode($settings['name']),
                    'db' => array(
                        'connectionString' =>
                            'mysql:host=' . (isset($settings['dbOurConfig']) ? $defaultComponents['db']['host'] : $settings['dbHost']) .
                            ';port=' . (isset($settings['dbOurConfig']) ? $defaultComponents['db']['port'] : $settings['dbPort']) .
                            ';dbname=' . (isset($settings['dbOurConfig']) ? $defaultComponents['db']['name'] : $settings['dbName']),
                        'username' => isset($settings['dbOurConfig']) ? $defaultComponents['db']['user'] : $settings['dbUser'],
                        'password' => isset($settings['dbOurConfig']) ? $defaultComponents['db']['password'] : $settings['dbPassword']
                    ),
                    'sphinx' => array(
                        'connectionString' =>
                            'mysql:host=' . (isset($settings['sphinxOurConfig']) ? $defaultComponents['sphinx']['host'] : $settings['sphinxHost']) .
                            ';port=' . (isset($settings['sphinxOurConfig']) ? $defaultComponents['sphinx']['port'] : $settings['sphinxPort']),
                    ),
                    'log' => isset($settings['enableLog']),
                    'cacheClass' => isset($settings['enableFileCache']) ? 'system.caching.CFileCache' : 'system.caching.CDummyCache'
                );

                // Create DB
                if (!isset($settings['dbOurConfig'])) {
                    $sql = file_get_contents(__DIR__ . '/../../data/schema.mysql.sql');
                    $pdo = new PDO($params['db']['connectionString'], $params['db']['username'], $params['db']['password']);
                    $pdo->exec($sql);
                }

                // Generate configuration
                $viewFile = $this->getViewFile('/templates/configuration');
                $content = $this->renderFile($viewFile, $params, true);

                $savePath = Yii::getPathOfAlias('application') . DIRECTORY_SEPARATOR . 'config' . DIRECTORY_SEPARATOR . 'config.php';
                file_put_contents($savePath, $content, FILE_TEXT);

                // Rename installer file
                rename(__DIR__ . '/../../../www/installer.php', __DIR__ . '/../../../www/installer-disabled.php');

                // Redirect to main page
                $this->redirect('/');
            }
        }

        $this->render('index', array('requirements' => $requirements, 'disableForm' => $disableForm, 'errors' => $errors));
    }

    public function actionError()
    {
        if($error = Yii::app()->errorHandler->error)
        {
            if(Yii::app()->request->isAjaxRequest)
                echo $error['message'];
            else
                $this->render('error', $error);
        }
    }
}