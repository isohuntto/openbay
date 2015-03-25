<?php

namespace frontend\modules\languageReport\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "language_report".
 *
 * @property integer $id
 * @property integer $record_id
 * @property integer $user_id
 * @property integer $language
 * @property integer $created_at
 */
class LanguageReport extends \yii\db\ActiveRecord {

    public static function checkUserVote($userId, $recordId) {
        return LanguageReport::find()->where(['user_id' => $userId, 'record_id' => $recordId])->count();
    }

    /**
     * @inheritdoc
     */
    public function behaviors() {
        return [
            'timestamp' => [
                'class' => TimestampBehavior::className(),
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['created_at'],
                ]
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return 'language_report';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['record_id', 'language'], 'required'],
            [['record_id', 'user_id', 'created_at'], 'integer'],
            [['language'], 'string'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'id' => Yii::t('languageReport', 'ID'),
            'record_id' => Yii::t('languageReport', 'Record ID'),
            'user_id' => Yii::t('languageReport', 'User ID'),
            'language' => Yii::t('languageReport', 'Language'),
            'created_at' => Yii::t('languageReport', 'Created At'),
        ];
    }

}
