<?php

namespace frontend\modules\comment\models;

use creocoder\nestedsets\NestedSetsBehavior;
use frontend\modules\comment\components\UserHashBehavior;
use himiklab\yii2\recaptcha\ReCaptchaValidator;
use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "comment".
 *
 * @property integer $id
 * @property integer $record_id
 * @property integer $user_id
 * @property string $author
 * @property string $comment
 * @property string $user_hash
 * @property integer $rating
 * @property integer $created_at
 */
class Comment extends ActiveRecord
{
    public $reCaptcha;
    public $parentId;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%comments}}';
    }

    public function transactions()
    {
        return [
            self::SCENARIO_DEFAULT => self::OP_ALL,
            'add-user' => self::OP_ALL,
            'add-guest' => self::OP_ALL
        ];
    }

    public function behaviors()
    {
        return [
            ['class' => NestedSetsBehavior::className()],
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
        $reCaptchaSecretKey = \Yii::$app->getModule('comment')->reCaptchaSecretKey;
        return [
            [['record_id', 'author'], 'required', 'on' => ['add-guest', 'add-user']],
            [['id', 'record_id', 'user_id', 'rating', 'created_at', 'parentId'], 'integer'],
            [['comment'], 'required', 'on' => ['add-guest', 'add-user'], 'message' => 'Comment can\'t be blank! It\'s like grog without rum!'],
            [['comment'], 'string'],
            [['author'], 'string', 'max' => 255],
            [['user_hash'], 'string', 'max' => 32],
            [['reCaptcha'], ReCaptchaValidator::className(), 'secret' => $reCaptchaSecretKey, 'on' => ['add-guest']]
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => \Yii::t('comment', 'ID'),
            'record_id' => \Yii::t('comment', 'Record ID'),
            'user_id' => \Yii::t('comment', 'User ID'),
            'author' => \Yii::t('comment', 'Author'),
            'comment' => \Yii::t('comment', 'Comment'),
            'user_hash' => \Yii::t('comment', 'User Hash'),
            'rating' => \Yii::t('comment', 'Rating'),
            'created_at' => \Yii::t('comment', 'Created At'),
            'reCaptcha' => '',
        ];
    }

    public function getMarks()
    {
        return $this->hasMany(Mark::className(), ['comment_id' => 'id']);
    }

    public function setMark(Mark $mark)
    {
        $this->populateRelation('mark', $mark);
    }

    public function afterSave($insert, $changedAttributes)
    {
        $relatedRecords = $this->getRelatedRecords();
        if ($this->isRelationPopulated('mark')) {
            $this->link('marks', $relatedRecords['mark']);
        }
    }

    public static function find()
    {
        return new CommentQuery(get_called_class());
    }

}