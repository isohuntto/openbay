<?php

namespace common\models\torrent;

use Yii;

/**
 * This is the model class for table "scrapes".
 *
 * @property integer $id
 * @property integer $torrent_id
 * @property string $name
 * @property integer $status
 * @property integer $complete
 * @property integer $incomplete
 * @property integer $downloaded
 */
class Scrape extends \yii\db\ActiveRecord
{
    const STATUS_GOOD = 0;
    const STATUS_BAD = 1;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'scrapes';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['torrent_id', 'name', 'status', 'complete', 'incomplete', 'downloaded'], 'required'],
            [['torrent_id', 'status', 'complete', 'incomplete', 'downloaded'], 'integer'],
            [['name'], 'string', 'max' => 255]
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
            'name' => 'Name',
            'status' => 'Status',
            'complete' => 'Complete',
            'incomplete' => 'Incomplete',
            'downloaded' => 'Downloaded',
        ];
    }
}