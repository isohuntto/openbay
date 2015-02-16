<?php

namespace frontend\modules\complain\components;


use yii\base\Event;

class ComplaintAddEvent extends Event
{

    public $recordId;
    public $userId;
    public $type;
    public $total;
} 