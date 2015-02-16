<?php

namespace common\modules\torrent_scraper\models;

use Yii;

/**
 * This is the model class for table "scrapes_queue".
 *
 * @property integer $id
 * @property integer $torrent_id
 */
class ScrapesQueue extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'scrapes_queue';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['torrent_id'], 'required'],
            [['torrent_id'], 'integer'],
            [['torrent_id'], 'unique']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'torrent_id' => 'Torrent ID',
        ];
    }
}