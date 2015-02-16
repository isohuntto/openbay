<?php

namespace frontend\modules\rating\components;


use yii\base\Event;

class RatingAddEvent extends Event
{

    public $recordId;
    public $userId;
    public $rating;

} 