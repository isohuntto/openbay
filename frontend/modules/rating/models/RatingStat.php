<?php

namespace frontend\modules\rating\models;

use Yii;

/**
 * This is the model class for table "rating_stat".
 *
 * @property integer $record_id
 * @property integer $rating
 * @property integer $count
 */
class RatingStat extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%rating_stats}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['record_id', 'rating'], 'required'],
            [['record_id', 'rating', 'count'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'record_id' => \Yii::t('rating', 'Record ID'),
            'rating' => \Yii::t('rating', 'Rating'),
            'count' => \Yii::t('rating', 'Count'),
        ];
    }
}
