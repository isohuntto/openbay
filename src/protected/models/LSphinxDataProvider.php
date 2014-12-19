<?php

class LSphinxDataProvider extends CDataProvider
{

    /**
     *
     * @var string the primary ActiveRecord class name. The {@link getData()} method
     *      will return a list of objects of this class.
     */
    public $modelClass;

    /**
     *
     * @var CActiveRecord the AR finder instance (eg <code>Post::model()</code>).
     *      This property can be set by passing the finder instance as the first parameter
     *      to the constructor. For example, <code>Post::model()->published()</code>.
     */
    public $model;

    /**
     *
     * @var ESphinxQL query
     */
    public $query = null;

    public $defaultSortAttributes = array(
        'weight()' => CSort::SORT_DESC,
        'torrent_status' => CSort::SORT_DESC,
        'seeders' => CSort::SORT_DESC
    );

    public $queryOptions = array(
        'max_matches' => '10000'
    );

    /**
     *
     * @var string the name of key attribute for {@link modelClass}. If not set,
     *      it means the primary key of the corresponding database table will be used.
     */
    public $keyAttribute;

    /**
     * for criteria while populate list
     * @var array
     */
    public $with = array();

    public $cacheTime = 600;

    public function __construct($modelClass, $query, $config = array())
    {
        if (($query instanceof ESphinxQL) === false) {
            throw new CException("Query param must be instance of EsphinxQL");
        }

        if (is_string($modelClass)) {
            $this->modelClass = $modelClass;
            $this->model = CActiveRecord::model($this->modelClass);
        } elseif ($modelClass instanceof CActiveRecord) {
            $this->modelClass = get_class($modelClass);
            $this->model = $modelClass;
        }

        $this->setId(CHtml::modelName($this->model));

        $this->query = $query;

        foreach ($config as $key => $value) {
            $this->$key = $value;
        }
    }

    /**
     * Returns the sorting object.
     *
     * @param string $className
     *            the sorting object class name. Parameter is available since version 1.1.13.
     * @return CSort the sorting object. If this is false, it means the sorting is disabled.
     */
    public function getSort($className = 'CSort')
    {
        if (($sort = parent::getSort($className)) !== false)
            $sort->modelClass = $this->modelClass;
        return $sort;
    }

    protected function fetchData()
    {
        foreach ($this->queryOptions as $name => $value) {
            $this->query->option($name, $value);
        }

        if (($pagination = $this->getPagination('Pagination')) !== false) {
            $pagination->setItemCount($this->getTotalItemCount());
            $this->query->limit($pagination->getLimit())->offset($pagination->getOffset());
        }

        $directions = null;
        if (($sort = $this->getSort()) !== false && $sort->getDirections()) {
            $directions = $sort->getDirections();
        }

        if (! empty($directions)) {
            $this->query->setOrders(array());
            foreach ($directions as $field => $sort) {
                $params = $this->getSort()->resolveAttribute($field);
                if (is_array($params)) {
                    $key = $sort ? 'desc' : 'asc';
                    if (isset($params[$key])) {
                        $orders = explode(',', $params[$key]);
                        foreach ($orders as $field) {
                            if (preg_match('#\s(desc|asc)$#i', $field, $match)) {
                                $length = strlen($field) - strlen($match[1]) - 1;
                                $field = substr($field, 0, $length);
                                $this->query->order($field, strtoupper($match[1]));
                            } else {
                                $this->query->order($field, strtoupper($key));
                            }
                        }
                    }
                } else if (is_string($params)) {
                    $this->query->order($params, $sort ? 'DESC' : 'ASC');
                } else {
                    $this->query->order($field, $sort ? 'DESC' : 'ASC');
                }
            }
        }

        $sql = $this->query->build();

        try {
            $ids = Yii::app()->sphinx->cache($this->cacheTime)->createCommand($sql)->queryColumn();
            if ($ids) {
                $criteria = new CDbCriteria();
                $criteria->addInCondition('t.id', $ids);
                $criteria->order = 'FIELD(t.id,' . implode(',', $ids) . ')';
                if (!empty($this->with)) {
                    $criteria->with = $this->with;
                }
                return $this->model->findAll($criteria);
            }
        } catch (Exception $e) {
            Yii::log('LSphinxDataProvider exception' . PHP_EOL . 'Message: ' . $e->getMessage() . 'Trace: ' . $e->getTraceAsString(), CLogger::LEVEL_ERROR);

            if (YII_DEBUG) {
                throw $e;
            }
        }

        return array();
    }

    // @TODO Refactor in future.
    protected function fetchKeys()
    {
        $keys = array();
        foreach ($this->getData() as $i => $data) {
            $key = $this->keyAttribute === null ? $data->getPrimaryKey() : $data->{$this->keyAttribute};
            $keys[$i] = is_array($key) ? implode(',', $key) : $key;
        }
        return $keys;
    }

    protected function calculateTotalItemCount()
    {
        $q = clone $this->query;

        $q->setCountFieldOnly();
        $sql = $q->build();
        $total = 0;
        try {
            $recordsCount = Yii::app()->sphinx->cache($this->cacheTime)->createCommand($sql)->queryAll();
            if (isset($recordsCount[0])) {
                $total = $recordsCount[0]['count(*)'];
            }
        } catch (Exception $e) {
            Yii::log('LSphinxDataProvider exception' . PHP_EOL . 'Message: ' . $e->getMessage() . 'Trace: ' . $e->getTraceAsString(), CLogger::LEVEL_ERROR);

            if (YII_DEBUG) {
                throw $e;
            }
        }

        return $total > 9975 ? 9975 : $total;
    }
}