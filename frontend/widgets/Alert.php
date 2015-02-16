<?php

namespace frontend\widgets;

use yii\base\Widget;
use yii\helpers\Html;

class Alert extends Widget
{
    public function init()
    {
        parent::init();
    }

    public function run()
    {
        $session = \Yii::$app->getSession();
        $flashes = $session->getAllFlashes();

        $response = '';
        foreach ($flashes as $type => $data) {
            $data = (array)$data;
            foreach ($data as $i => $message) {
                $response .= Html::tag("div", $message, ['class' => 'alert ' . $type]);
            }
            $session->removeFlash($type);
        }
        return $response;
    }
}