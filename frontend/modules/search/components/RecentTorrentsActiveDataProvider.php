<?php

namespace frontend\modules\search\components;

use yii\data\ActiveDataProvider;
use yii\db\QueryInterface;

class RecentTorrentsActiveDataProvider extends ActiveDataProvider
{

    /**
     * @inheritdoc
     */
    protected function prepareTotalCount() {
        if (!$this->query instanceof QueryInterface) {
            throw new InvalidConfigException('The "query" property must be an instance of a class that implements the QueryInterface e.g. yii\db\Query or its subclasses.');
        }

        $count = 10000;
        return $count;
    }

}
