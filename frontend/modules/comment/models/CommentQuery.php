<?php

namespace frontend\modules\comment\models;

use creocoder\nestedsets\NestedSetsQueryBehavior;

class CommentQuery extends \yii\db\ActiveQuery
{
    public function behaviors()
    {
        return [
            NestedSetsQueryBehavior::className(),
        ];
    }
}