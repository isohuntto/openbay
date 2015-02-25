<?php

namespace frontend\modules\feed\models;

use Yii;

/**
 * This is the model class for table "user_feeds".
 *
 * @property integer $user_id
 * @property integer $following_id
 *
 * @property User $following
 * @property User $user
 */
class UserFeeds extends \yii\db\ActiveRecord {

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return 'user_feeds';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['user_id', 'following_id'], 'required'],
            [['user_id', 'following_id'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'user_id' => Yii::t('feed', 'User ID'),
            'following_id' => Yii::t('feed', 'Following ID'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFollowing() {
        return $this->hasOne(User::className(), ['id' => 'following_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser() {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

}
