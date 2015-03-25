<?php

namespace frontend\modules\language_content\widgets;

use frontend\modules\language_content\models\Language;
use frontend\modules\language_content\models\LanguageContent;
use Yii;
use frontend\modules\language_content\Asset;
use yii\base\InvalidValueException;
use yii\base\Widget;

class LanguageContentWidget extends Widget
{

    public $modelId = null;

    public function init()
    {
        parent::init();
        $this->_registerClientScript();
    }

    public function run()
    {
        if ($this->modelId === null) {
           throw new InvalidValueException("ModelId is incorrect");
        }
        $visible = true;
        if (Yii::$app->user->isGuest) {
            $visible = false;
        } elseif (LanguageContent::find()->where(['user_id' => Yii::$app->user->id, 'model_id' => $this->modelId])->count()) {
            $visible = false;
        }

        $languages = Yii::$app->db->cache(function($db) {
            return Language::find()->all($db);
        }, 600);
        return $this->render('index', [
            'visible' => $visible,
            'modelId' => $this->modelId,
            'languages' => $languages
        ]);
    }

    /**
     * Register widget client scripts.
     */
    private function _registerClientScript()
    {
        $view = $this->getView();
        Asset::register($view);
    }

}