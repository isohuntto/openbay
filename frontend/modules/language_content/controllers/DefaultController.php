<?php

namespace frontend\modules\language_content\controllers;

use frontend\modules\language_content\models\Language;
use Yii;
use yii\db\Exception;
use yii\web\Controller;
use yii\web\HttpException;
use yii\web\Response;

class DefaultController extends Controller
{
    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionSet()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $modelId = intval(Yii::$app->request->post('model_id'));
        if (!Yii::$app->request->isAjax || !Yii::$app->request->isPost || !$modelId) {
            throw new HttpException(400);
        }
        $languages = $this->validateLanguages();

        $data = [];
        foreach($languages as $language) {
            $data[] = [
                'user_id' => Yii::$app->user->id,
                'model_id' => $modelId,
                'language_id' => $language,
                'created_at' => time()
            ];
        }
        try {
            Yii::$app->db
                ->createCommand()
                ->batchInsert('{{%languages_content}}', ['user_id', 'model_id', 'language_id', 'created_at'], $data)
                ->execute();
        } catch (Exception $e) {
            throw new HttpException(400);
        }

        return 'success';
    }

    /**
     * @param $languages
     * @return int|string
     */
    private function _getCountValidLanguages($languages)
    {
        return Language::find()->where(['id' => $languages])->count();
    }

    /**
     * @return array
     * @throws \yii\web\HttpException
     */
    public function validateLanguages()
    {
        $stringLanguages = Yii::$app->request->post('languages');
        if (empty($stringLanguages)) {
            throw new HttpException(400);
        }
        $languages = explode(',', $stringLanguages);
        $languages = array_unique($languages);
        $countValidLanguages = $this->_getCountValidLanguages($languages);
        if (count($languages) != $countValidLanguages) {
            throw new HttpException(400);
        }
        return $languages;
    }

}
