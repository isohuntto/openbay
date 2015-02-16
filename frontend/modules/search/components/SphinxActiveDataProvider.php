<?php

namespace frontend\modules\search\components;

use yii\data\ActiveDataProvider;
use yii\db\QueryInterface;

class SphinxActiveDataProvider extends ActiveDataProvider
{

    /**
     * @inheritdoc
     */
    protected function prepareTotalCount() {
        $count = parent::prepareTotalCount();

        if (!$this->query instanceof QueryInterface) {
            throw new InvalidConfigException('The "query" property must be an instance of a class that implements the QueryInterface e.g. yii\db\Query or its subclasses.');
        }

        $maxMatches = isset($this->query->options['max_matches']) ? $this->query->options['max_matches'] : 1000; // Default matches to sphinx

        $query = clone $this->query;
        $count = (int) $query->limit(-1)->offset(-1)->orderBy([])->count('*', $this->db);
        if ($count > $maxMatches) {
            $count = $maxMatches;
        }
        return $count;
    }

}
