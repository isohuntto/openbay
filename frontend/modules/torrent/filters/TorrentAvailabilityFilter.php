<?php
namespace frontend\modules\torrent\filters;

use Yii;
use yii\base\ActionFilter;
use frontend\modules\torrent\models\Torrent;
use yii\web\HttpException;

class TorrentAvailabilityFilter extends ActionFilter
{
    /** @var \frontend\modules\torrent\models\Torrent */
    protected $torrent;

    public function beforeAction($action)
    {
        $id = Yii::$app->request->getQueryParam('id');

        $this->torrent = Yii::$app->db->cache(function ($db) use ($id) {
            return Torrent::findOne($id);
        });

        if (!$this->torrent) {
            $this->error404();
            return false;
        }

        if (!$this->checkAccess()) {
            $this->error404();
            return false;
        }

        $this->checkUrl();

        return true;
    }

    protected function checkUrl()
    {
        if ($this->torrent->getUrl() !== Yii::$app->request->getUrl()) {
            Yii::$app->response->redirect($this->torrent->getUrl(), 301);
        }
    }

    protected function checkAccess()
    {
        switch ($this->torrent->visible_status) {
            case Torrent::VISIBLE_STATUS_VISIBLE:
            case Torrent::VISIBLE_STATUS_DIRECT:
                return true;
            case Torrent::VISIBLE_STATUS_INVISIBLE:
                return false;
            case Torrent::VISIBLE_STATUS_REGISTERED_ONLY:
                return !Yii::$app->user->isGuest;
            default:
                return false;
        }
    }

    protected function accessDenied()
    {
        $this->error404();
    }

    protected function error404()
    {
        throw new HttpException(404);
    }
}