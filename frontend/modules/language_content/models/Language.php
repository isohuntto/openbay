<?php

namespace frontend\modules\language_content\models;

use Yii;

/**
 * This is the model class for table "languages".
 *
 * @property integer $id
 * @property string $name
 * @property string $short
 *
 * @property LanguagesContent[] $languagesContents
 */
class Language extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'languages';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'short'], 'required'],
            [['name'], 'string', 'max' => 255],
            [['short'], 'string', 'max' => 15]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('languages_content', 'ID'),
            'name' => Yii::t('languages_content', 'Name'),
            'short' => Yii::t('languages_content', 'Short'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLanguagesContents()
    {
        return $this->hasMany(LanguagesContent::className(), ['language_id' => 'id']);
    }
}
