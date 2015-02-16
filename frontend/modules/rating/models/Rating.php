<?php

namespace frontend\modules\rating\models;

use frontend\modules\rating\components\UserHashBehavior;
use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "rating".
 *
 * @property integer $id
 * @property integer $record_id
 * @property integer $user_id
 * @property string $user_hash
 * @property integer $rating
 * @property integer $created_at
 */
class Rating extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%ratings}}';
    }

    public function transactions()
    {
        return [
            self::SCENARIO_DEFAULT => self::OP_INSERT,
        ];
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
            [['record_id', 'user_id', 'rating', 'created_at'], 'integer'],
            [['user_hash'], 'string', 'max' => 32]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Rating::t('common', 'ID'),
            'record_id' => Rating::t('common', 'Record ID'),
            'user_id' => Rating::t('common', 'User ID'),
            'user_hash' => Rating::t('common', 'User Hash'),
            'rating' => Rating::t('common', 'Rating'),
            'created_at' => Rating::t('common', 'Created At'),
        ];
    }

    public function afterSave($insert, $changedAttributes)
    {
        if ($insert) {
            $ratingStat = RatingStat::findOne(['record_id' => $this->record_id, 'rating' => $this->rating]);
            if (!$ratingStat) {
                $ratingStat = new RatingStat();
                $ratingStat->record_id = $this->record_id;
                $ratingStat->rating = $this->rating;
                $ratingStat->count = 0;
            }

            $ratingStat->count = intval($ratingStat->count) + 1;
            $ratingStat->save();
        }
    }
}
