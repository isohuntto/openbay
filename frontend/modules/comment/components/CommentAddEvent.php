<?php

namespace frontend\modules\comment\components;


use yii\base\Event;

class CommentAddEvent extends Event
{
    public $recordId;
    public $userId;
} 