<?php

namespace frontend\modules\torrent\controllers;

use common\models\User;
use Yii;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\HttpException;
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
            return Torrent::find()->where(['id' => $id])->with('user')->one();
        });
        if ($model !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionTorrents($username)
    {
        $user = User::findByUsername($username);
        if (empty($user)) {
            throw new HttpException(404);
        }

        $query = Torrent::find();
        $query->with('scrapes');
        $query->where(['visible_status' => [0,3], 'user_id' => $user->id]);
        $isSort = \Yii::$app->request->get('sort');
        if (empty($isSort)) {
            $query->addOrderBy(['id' => SORT_DESC]);
        }

        $torrents = new ActiveDataProvider([
            'query' => $query,
            'db' => \Yii::$app->db,
            'sort' => [
                'attributes' => [
                    'name' => [
                        'default' => SORT_DESC
                    ],
                    'created_at' => [
                        'default' => SORT_DESC
                    ],
                    'size' => [
                        'default' => SORT_DESC
                    ],
                    'seeders' => [
                        'default' => SORT_DESC
                    ],
                    'leechers' => [
                        'default' => SORT_DESC
                    ]
                ]
            ],
            'pagination' => [
                'pageSize' => 35,
            ],
        ]);
        return $this->render('torrents', [
            'torrents' => $torrents,
            'user' => $user
        ]);
    }
}
