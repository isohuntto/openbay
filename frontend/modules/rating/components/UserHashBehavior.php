<?php

namespace frontend\modules\rating\components;

use yii\behaviors\AttributeBehavior;
use yii\db\BaseActiveRecord;

class UserHashBehavior extends AttributeBehavior
{

    /**
     * @var string
     */
    public $userHashAttribute = 'user_hash';

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();

        if (empty($this->attributes)) {
            $this->attributes = [
                BaseActiveRecord::EVENT_BEFORE_INSERT => [$this->userHashAttribute],
            ];
        }
    }

    /**
     * @inheritdoc
     */
    protected function getValue($event)
    {
        return Utils::userHash(\Yii::$app->request->userIP);
    }
} 