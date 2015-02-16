<?php

namespace frontend\modules\comment\models;

use frontend\modules\comment\components\UserHashBehavior;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use Yii;

/**
 * This is the model class for table "comment_marks".
 *
 * @property integer $id
 * @property integer $comment_id
 * @property integer $user_id
 * @property string $userHash
 * @property integer $mark
 * @property integer $created_at
 *
 * @property Comment $comment
 */
class Mark extends ActiveRecord
{
    const MARK_UP_VALUE = 1;
    const MARK_DOWN_VALUE = -1;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%comment_marks}}';
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
            [['comment_id'], 'required'],
            [['id', 'comment_id', 'user_id', 'mark', 'created_at'], 'integer'],
            [['user_hash'], 'string', 'max' => 32]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => \Yii::t('comment', 'ID'),
            'comment_id' => \Yii::t('comment', 'Comment ID'),
            'user_hash' => \Yii::t('comment', 'User Hash'),
            'mark' => \Yii::t('comment', 'Mark'),
            'created_at' => \Yii::t('comment', 'Created At'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getComment()
    {
        return $this->hasOne(Comment::className(), ['id' => 'comment_id']);
    }
}
