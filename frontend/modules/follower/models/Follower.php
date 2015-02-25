<?php

namespace frontend\modules\follower\models;

use Yii;

/**
 * This is the model class for table "followers".
 *
 * @property integer $user_id
 * @property integer $follower_user_id
 */
class Follower extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'followers';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'follower_user_id'], 'required'],
            [['user_id', 'follower_user_id'], 'integer'],
            [['user_id', 'follower_user_id'], 'unique', 'targetAttribute' => ['user_id', 'follower_user_id'], 'message' => 'The combination of User ID and Follower User ID has already been taken.']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'user_id' => 'User ID',
            'follower_user_id' => 'Follower User ID',
        ];
    }

}
