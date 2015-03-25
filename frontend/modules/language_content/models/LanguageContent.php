<?php

namespace frontend\modules\language_content\models;

use Yii;

/**
 * This is the model class for table "languages_content".
 *
 * @property integer $user_id
 * @property integer $model_id
 * @property integer $language_id
 * @property integer $created_at
 *
 * @property User $user
 * @property Languages $language
 */
class LanguageContent extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'languages_content';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'model_id', 'language_id', 'created_at'], 'required'],
            [['user_id', 'model_id', 'language_id', 'created_at'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'user_id' => Yii::t('languages_content', 'User ID'),
            'model_id' => Yii::t('languages_content', 'Model ID'),
            'language_id' => Yii::t('languages_content', 'Language ID'),
            'created_at' => Yii::t('languages_content', 'Created At'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLanguage()
    {
        return $this->hasOne(Languages::className(), ['id' => 'language_id']);
    }
}
