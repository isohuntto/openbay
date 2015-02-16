<?php

namespace frontend\modules\complain\models;

use frontend\modules\complain\components\UserHashBehavior;
use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "complaints".
 *
 * @property integer $id
 * @property integer $record_id
 * @property integer $user_id
 * @property integer $type
 * @property string $user_hash
 * @property integer $created_at
 */
class Complaint extends ActiveRecord
{

    const TYPE_FAKE = 1;
    const TYPE_VIRUS = 2;
    const TYPE_INCORRECT_DESCRIPTION = 3;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'complaints';
    }

    public function behaviors()
    {
        return [
            'timestamp' => [
                'class' => TimestampBehavior::className(),
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['created_at']
                ]
            ],
            'userHash' => UserHashBehavior::className()
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['record_id', 'type'], 'required'],
            [['record_id', 'user_id', 'type', 'created_at'], 'integer'],
            [['user_hash'], 'string', 'max' => 32]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => \Yii::t('complain', 'ID'),
            'record_id' => \Yii::t('complain', 'Record ID'),
            'user_id' => \Yii::t('complain', 'User ID'),
            'type' => \Yii::t('complain', 'Type'),
            'user_hash' => \Yii::t('complain', 'User Hash'),
            'created_at' => \Yii::t('complain', 'Created At'),
        ];
    }
}
