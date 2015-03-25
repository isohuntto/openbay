<?php

namespace frontend\modules\languageReport\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "torrent_language".
 *
 * @property integer $id
 * @property string $languages
 * @property integer $created_at
 * @property integer $updated_at
 */
class TorrentLanguage extends \yii\db\ActiveRecord {

    /**
     * Percentage of reports to treat language as confirmed
     */
    const THRESHOLD = 50;

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
        return 'torrent_language';
    }

    public static function defineLanguages($recordId, $newLanguages) {
        $reports = LanguageReport::find()->where(['record_id' => $recordId])->all();
        $totalReports = count($reports);

        $languages = [];

        foreach ($reports as $report) {
            $reportedLanguage = split(',', $report->language);
            foreach ($reportedLanguage as $language) {
                if (isset($languages[$language])) {
                    $languages[$language] ++;
                } else {
                    $languages[$language] = 1;
                }
            }
        }

        foreach ($newLanguages as $language) {
            if (isset($languages[$language])) {
                $languages[$language] ++;
            } else {
                $languages[$language] = 1;
            }
        }

        $maxReports = max($languages);
        $result = [];

        foreach ($languages as $language => $reportCount) {
            if (self::THRESHOLD * $maxReports / 100 <= $reportCount) {
                $result[] = mb_convert_case($language, MB_CASE_TITLE);
            }
        }

        return $result;
    }

    public static function saveLanguages($recordId, $languages) {
        $languages = join(', ', $languages);

        $item = self::findOne([$recordId]);

        if (!$item) {
            $item = new TorrentLanguage();
            $item->id = $recordId;
        }
        $item->languages = $languages;
        return $item->save();
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['languages'], 'required'],
            [['created_at', 'updated_at'], 'integer'],
            [['languages'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'id' => Yii::t('languageReport', 'ID'),
            'languages' => Yii::t('languageReport', 'Languages'),
            'created_at' => Yii::t('languageReport', 'Created At'),
            'updated_at' => Yii::t('languageReport', 'Updated At'),
        ];
    }

}
