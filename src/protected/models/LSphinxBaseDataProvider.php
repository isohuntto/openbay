<?php

/**
 * This class like LSphinxDataProvider but get data from sphinx
 * Class LSphinxBaseDataProvider
 */
class LSphinxBaseDataProvider extends CDataProvider
{
    /**
     * @var string the name of the key field. This is a field that uniquely identifies a
     * data record. In database this would be the primary key.
     * Defaults to 'id'. If it's set to false, keys of {@link rawData} array are used.
     */
    public $keyField = false;
    /**
     * @var int cache time for sphinx queries
     */
    public $cacheTime = 600;

    /**
     * @var string the name of key attribute for {@link modelClass}. If not set,
     *      it means the primary key of the corresponding database table will be used.
     */
    public $keyAttribute;

    /**
     * @var ESphinxQL
     */
    public $query;

    public $queryOptions = array(
        'max_matches' => '10000'
    );

    public function __construct($query, $config = array())
    {
        if (($query instanceof ESphinxQL) === false) {
            throw new CException("Query param must be instance of EsphinxQL");
        }

        $this->query = $query;

        foreach ($config as $key => $value) {
            $this->$key = $value;
        }
    }

    /**
     * Calculates the total number of data items.
     * @throws Exception
     * @return integer the total number of data items.
     */
    protected function calculateTotalItemCount()
    {
        $q = clone $this->query;

        $q->setCountFieldOnly();
        $sql = $q->build();
        $total = 0;
        try {
            $recordsCount = Yii::app()->sphinx->cache($this->cacheTime)->createCommand($sql)->queryAll();
            if ($q->hasGroupBy()) {
                $meta = Yii::app()->sphinx->createCommand('show meta')->queryAll();
                foreach ($meta as $row) {
                    if (!empty($row['Variable_name']) && $row['Variable_name'] === 'total_found') {
                        if (!empty($row['Value'])) {
                            $total = (int) $row['Value'];
                        }
                        break;
                    }
                }
            } else {
                if (isset($recordsCount[0])) {
                    $total = $recordsCount[0]['count(*)'];
                }
            }
        } catch (Exception $e) {
            Yii::log('LSphinxDataProvider exception' . PHP_EOL . 'Message: ' . $e->getMessage() . 'Trace: ' . $e->getTraceAsString(), CLogger::LEVEL_ERROR);

            if (YII_DEBUG) {
                throw $e;
            }
        }

        return $total > 9975 ? 9975 : $total;
    }

    /**
     * Fetches the data from the persistent data storage.
     * @throws Exception
     * @return array list of data items
     */
    protected function fetchData()
    {
        foreach ($this->queryOptions as $name => $value) {
            $this->query->option($name, $value);
        }

        if (($pagination = $this->getPagination('Pagination')) !== false) {
            $pagination->setItemCount($this->getTotalItemCount());
            $this->query->limit($pagination->getLimit())->offset($pagination->getOffset());
        }

        if (($sort = $this->getSort()) !== false && ($order = $sort->getOrderBy()) != '') {
            foreach (explode(',', $order) as $orderAttribute) {
                $orderAttribute = trim($orderAttribute);
                $field = trim(preg_replace('#(desc|asc)$#sui', '', $orderAttribute));
                if (preg_match('#(desc|asc)$#sui', $orderAttribute, $matches)) {
                    $direction = $matches[1] === 'desc' ? true : false;
                } else {
                    $direction = $sort->getDirection($field);
                }
                $this->query->order($field, $direction ? 'DESC' : 'ASC');
            }
        }

        $sql = $this->query->build();

        $data = array();
        try {
            $data = Yii::app()->sphinx->cache($this->cacheTime)->createCommand($sql)->queryAll();
        } catch (Exception $e) {
            Yii::log('LSphinxDataProvider exception' . PHP_EOL . 'Message: ' . $e->getMessage() . 'Trace: ' . $e->getTraceAsString(), CLogger::LEVEL_ERROR);

            if (YII_DEBUG) {
                throw $e;
            }
        }

        return $data;
    }

    /**
     * Fetches the data item keys from the persistent data storage.
     * @return array list of data item keys.
     */
    protected function fetchKeys()
    {
        if ($this->keyField === false)
            return array_keys($this->getData());
        $keys = array();
        foreach ($this->getData() as $i => $data)
            $keys[$i] = is_object($data) ? $data->{$this->keyField} : $data[$this->keyField];
        return $keys;
    }
}