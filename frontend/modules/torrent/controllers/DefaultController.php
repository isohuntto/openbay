<?php

namespace frontend\modules\torrent\controllers;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\helpers\ArrayHelper;

use frontend\modules\torrent\models\Torrent;
use frontend\modules\torrent\filters\TorrentAvailabilityFilter;

/**
 * TorrentController implements the CRUD actions for Torrent model.
 */
class DefaultController extends Controller
{
    public function behaviors()
    {
        return ArrayHelper::merge([
            [
                'class' => TorrentAvailabilityFilter::className(),
                'only' => ['view']
            ],
        ], parent::behaviors());
    }

    /**
     * Lists all Torrent models.
     * @return mixed
     */
    public function actionIndex()
    {
        $model = new Torrent();

        return $this->render('index', [
            'dataProvider' => $model->search(),
        ]);
    }

    /**
     * Displays a single Torrent model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);
        /** @var \common\modules\torrent_scraper\Module $scraper */
        if ($scraper = Yii::$app->getModule('torrent_scraper')) {
            $scraper->queuedTorrent($model->id);
        }
        return $this->render('view', [
            'model' => $model,
        ]);
    }

    /**
     *
     */
    public function actionDownload($id, $name, $hash)
    {
        if ($id && $model = Torrent::find()->where(['hash' => $hash])->one()) {
            if (urlencode($model->name) == $name) {
                if ($model->torrentFileIsLocal()) {
                    header('Content-Description: File Transfer');
                    header('Content-Type: application/octet-stream');
                    header('Content-Disposition: attachment; filename=' . $model->name . '.torrent');
                    header('Pragma: public');
                    header('Content-Length: ' . filesize($model->getFilePath()));
                    readfile($model->getFilePath());
                } else {
                    $this->redirect($model->getDownloadLink());
                }
            }
        }
    }

    /**
     * Finds the Torrent model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Torrent the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        $model = Yii::$app->db->cache(function ($db) use ($id) {
            return Torrent::findOne($id);
        });
        if ($model !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
