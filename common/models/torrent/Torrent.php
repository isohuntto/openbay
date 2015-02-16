<?php

namespace common\models\torrent;

use Yii;
use yii\db\ActiveRecord;
use yii\db\Expression;
use yii\behaviors\TimestampBehavior;
use common\models\torrent\Files;
use common\models\torrent\Scrape;
use common\models\tag\Category;
use yii\helpers\FileHelper;

/**
 * This is the model class for table "torrents".
 *
 * @property integer $id
 * @property string $name
 * @property string $description
 * @property integer $category_id
 * @property string $size
 * @property string $hash
 * @property string $created_at
 * @property integer $torrent_status
 * @property integer $visible_status
 * @property integer $downloads_count
 * @property string $scrape_date
 * @property integer $seeders
 * @property integer $leechers
 * @property string $tags
 * @property string $updated_at
 *
 * @property array $scrapes
 * @property array files
 */
class Torrent extends ActiveRecord
{
    /** Torrent quality */
    const TORRENT_STATUS_UNCHECKED = 0;

    const TORRENT_STATUS_GOOD = 1;

    const TORRENT_STATUS_SUSPECTED = 2;

    const TORRENT_STATUS_FAKE = 3;

    /** Visibility */
    const VISIBLE_STATUS_VISIBLE = 0;

    const VISIBLE_STATUS_DIRECT = 1;

    const VISIBLE_STATUS_INVISIBLE = 2;

    const VISIBLE_STATUS_REGISTERED_ONLY = 3;

    public $FILE_DIR = '';

    public function init()
    {
        parent::init();
        $helper = new FileHelper();
        $this->FILE_DIR = $helper->normalizePath(__DIR__ . '/../../data/torrents');
    }


    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'torrents';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['description'], 'string'],
            [['category_id', 'size', 'torrent_status', 'visible_status', 'downloads_count', 'seeders', 'leechers'], 'integer'],
            [['hash'], 'required'],
            [['created_at', 'scrape_date', 'updated_at'], 'safe'],
            [['name'], 'string', 'max' => 255],
            [['hash'], 'string', 'length' => 40],
            [['tags'], 'string', 'max' => 500],
            [['hash'], 'unique']
        ];
    }

    public function behaviors() {
        return [
            'timestamp' => [
                'class' => TimestampBehavior::className(),
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['updated_at'],
                    ActiveRecord::EVENT_BEFORE_UPDATE => ['updated_at'],
                ],
                'value' => new Expression('NOW()')
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('torrent', 'ID'),
            'name' => Yii::t('torrent', 'Name'),
            'description' => Yii::t('torrent', 'Description'),
            'category_id' => Yii::t('torrent', 'Category ID'),
            'size' => Yii::t('torrent', 'Size'),
            'hash' => Yii::t('torrent', 'Hash'),
            'files_count' => Yii::t('torrent', 'Files Count'),
            'created_at' => Yii::t('torrent', 'Created At'),
            'torrent_status' => Yii::t('torrent', 'Torrent Status'),
            'visible_status' => Yii::t('torrent', 'Visible Status'),
            'downloads_count' => Yii::t('torrent', 'umax = 16777215'),
            'scrape_date' => Yii::t('torrent', 'Scrape Date'),
            'seeders' => Yii::t('torrent', 'Seeders'),
            'leechers' => Yii::t('torrent', 'Leechers'),
            'tags' => Yii::t('torrent', 'Tags'),
            'updated_at' => Yii::t('torrent', 'Updated At'),
        ];
    }

    /**
     * @param bool $insert
     * @return bool
     */
    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            $date = date('Y-m-d H:i:s');
            if ($insert) {
                $this->created_at = $date;
            }
            $this->updated_at = $date;
            return true;
        }
        return false;
    }


    /**
     * relation with files
     * @return \yii\db\ActiveQuery
     */
    public function getFiles()
    {
        return $this->hasMany(Files::className(), ['torrent_id' => 'id']);
    }

    /**
     * relation with scrapes
     * @return \yii\db\ActiveQuery
     */
    public function getScrapes()
    {
        return $this->hasMany(Scrape::className(), ['torrent_id' => 'id']);
    }

    public function getTags()
    {
        if (empty($this->tags)) {
            return array();
        }

        $tags = explode(',', $this->tags);
        return array_values(array_diff($tags, $this->getServiceTags()));
    }

    public function getServiceTags()
    {
        if (empty($this->tags)) {
            return array();
        }
        $tags = explode(',', $this->tags);

        $result = array();

        foreach ($tags as $k => $tag) {
            if (preg_match('!card:\w+:\d+!', $tag)) {
                $result[] = $tag;
            }
        }
        return array_values($result);
    }

    public function getCategoryTag()
    {
        $tags = $this->getTags();
        if (empty($tags)) {
            return strtolower(Category::getTag(Category::OTHER));
        }
        return $tags[0];
    }
}
