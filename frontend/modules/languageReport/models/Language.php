<?php

namespace frontend\modules\languageReport\models;

use Yii;

/**
 * This is the model class for table "language".
 *
 * @property integer $id
 * @property string $language
 */
class Language extends \yii\db\ActiveRecord {

    public static function saveLanguages($languages) {
        if (!count($languages)) {
            return false;
        }

        $inserts = [];
        $params = [];
        $it = 0;

        foreach ($languages as $language) {
            $it++;
            $inserts[] = "(:lang{$it}, 1)";
            $params[":lang{$it}"] = mb_convert_case($language, MB_CASE_TITLE);
        }

        $sql = "INSERT INTO " . Yii::$app->db->quoteTableName(self::tableName()) . " (`language`, `confirmed`) "
                . "VALUES " . join(',', $inserts) . " "
                . "ON DUPLICATE KEY UPDATE `confirmed` = `confirmed` + 1";

        try {
            Yii::$app->db->createCommand($sql, $params)->execute();
        } catch (\Exception $e) {

        }
        return true;
    }

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return 'language';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['language'], 'required'],
            [['language'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'id' => Yii::t('languageReport', 'ID'),
            'language' => Yii::t('languageReport', 'Language'),
        ];
    }

}
