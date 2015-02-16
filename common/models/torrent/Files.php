<?php

namespace common\models\torrent;

use Yii;

/**
 * This is the model class for table "files".
 *
 * @property integer $id
 * @property integer $torrent_id
 * @property string $name
 * @property integer $size
 */
class Files extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'files';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['torrent_id', 'name', 'size'], 'required'],
            [['torrent_id', 'size'], 'integer'],
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
            'size' => 'Size',
        ];
    }
}