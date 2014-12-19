<?php

/*
  Read Documentation, Luke.

  $sphinxql = new SphinxQL();
  $query = $sphinxql->newQuery();
  $query->addIndex('my_index')
  ->addField('field_name', 'alias')
  ->addField('another_field')
  ->addFields(array(array('field' => 'title', 'alias' => 'title_alias'), array('field' => 'user_id')))
  ->search('some words to search for')
  // string (is given directly to sphinx, so can contain @field directives)
  ->where('time', time()-3600, '>', false)
  // field, value, operator='=', quote=true
  ->whereIn('tags_i_need', array(1, 2, 3), 'all')
  ->whereIn('tags_i_do_not_want', array(4, 5, 6), 'none')
  ->whereIn('tags_i_would_like_one_of', array(7, 8, 9), 'any')
  // field, array values, type='any'
  ->order('weight()', 'desc')
  // field, sort='desc'
  ->offset(10)->limit(50)
  // defaults are 0 and 20, same as the sphinx defaults
  ->option('max_query_time', '100')
  // option name, option value
  ->groupBy('field')
  ->in_group_order_by('another_field', 'desc');
  // sphinx-specific, check their docs
  $result = $query->execute();

  $stats = $sphinx->stats();

  // ------

  $sphinxql = new SphinxQL();

  $result = $sphinxql->query('INSERT INTO realtime_index (id, title, content) VALUES ( 1, "title news", "content news" )');
*/

class ESphinxQL {

    /**
     * @var array The indexes that are to be searched
     */
    protected $_indexes = array();

    /**
     * @var array The fields that are to be returned in the result set
     */
    protected $_fields = array();

    /**
     * @var string A string to be searched for in the indexes
     */
    protected $_search = null;

    /**
     * @var array A set of WHERE conditions
     */
    protected $_wheres = array();

    /**
     * @var array The GROUP BY field
     */
    protected $_group = null;

    /**
     * @var array The IN GROUP ORDER BY options
     */
    protected $_group_order = null;

    /**
     * @var array A set of ORDER clauses
     */
    protected $_orders = array();

    /**
     * @var integer The offset to start returning results from
     */
    protected $_offset = 0;

    /**
     * @var integer The maximum number of results to return
     */
    protected $_limit = 20;

    /**
     * @var array A set of OPTION clauses
     */
    protected $_options = array();


    /**
     * Builds the query string from the information you've given.
     *
     * @return string The resulting query
     */
    public function build() {

        $fields = array();
        $wheres = array();
        $orders = array();
        $options = array();
        $query = '';

        foreach ($this->_fields as $field) {
            if (!isset($field['field']) || !is_string($field['field'])) {
                continue;
            }
            if (isset($field['alias']) && is_string($field['alias'])) {
                $fields[] = sprintf("%s AS %s", $field['field'], $field['alias']);
            } else {
                $fields[] = sprintf("%s", $field['field']);
            }
        }
        unset($field);

        if (is_string($this->_search)) {
            $wheres[] = sprintf("MATCH(%s)", $this->_search);
        }

        foreach ($this->_wheres as $where) {
            $wheres[] = sprintf("%s %s %s", $where['field'], $where['operator'], $where['value']);
        }
        unset($where);

        foreach ($this->_orders as $order) {
            $orders[] = sprintf("%s %s", $order['field'], $order['sort']);
        }
        unset($order);

        foreach ($this->_options as $option) {
            $options[] = sprintf("%s=%s", $option['name'], $option['value']);
        }
        unset($option);

        $query .= sprintf('SELECT %s ', count($fields) ? implode(', ', $fields) : '*' );
        $query .= sprintf('FROM %s ', implode(',', $this->_indexes));
        if (count($wheres) > 0) {
            $query .= sprintf('WHERE %s ', implode(' AND ', $wheres));
        }
        if (is_string($this->_group)) {
            $query .= sprintf('GROUP BY %s ', $this->_group);
        }
        if (is_array($this->_group_order)) {
            $query .= sprintf('WITHIN GROUP ORDER BY %s %s ', $this->_group_order['field'], $this->_group_order['sort']);
        }
        if (count($orders) > 0) {
            $query .= sprintf('ORDER BY %s ', implode(', ', $orders));
        }
        $query .= sprintf('LIMIT %d, %d ', $this->_offset, $this->_limit);
        if (count($options) > 0) {
            $query .= sprintf('OPTION %s ', implode(', ', $options));
        }
        while (substr($query, -1, 1) == ' ') {
            $query = substr($query, 0, -1);
        }

        return $query;
    }

    /**
     * Adds an entry to the list of indexes to be searched.
     *
     * @param string The index to add
     *
     * @return SphinxQL_Query $this
     */
    public function addIndex($index) {

        if (is_string($index)) {
            array_push($this->_indexes, $index);
        }

        return $this;
    }

    /**
     * Removes an entry from the list of indexes to be searched.
     *
     * @param string The index to remove
     *
     * @return SphinxQL_Query $this
     */
    public function removeIndex($index) {

        if (is_string($index)) {
            while ($pos = array_search($index, $this->_indexes)) {
                unset($this->_indexes[$pos]);
            }
        }

        return $this;
    }

    /**
     * Adds a entry to the list of fields to return from the query.
     *
     * @param string Field to add
     * @param string Alias for that field, optional
     *
     * @return SphinxQL_Query $this
     */
    public function addField($field, $alias = null) {

        if (!is_string($alias)) {
            $alias = null;
        }

        if (is_string($field)) {
            $this->_fields[] = array('field' => $field, 'alias' => $alias);
        }

        return $this;
    }

    /**
     * Adds multiple entries at once to the list of fields to return.
     * Takes an array structured as so:
     * array(array('field' => 'user_id', 'alias' => 'user')), ...)
     * The alias is optional.
     *
     * @param array Array of fields to add
     *
     * @return SphinxQL_Query $this
     */
    public function addFields($array) {

        if (is_array($array)) {
            foreach ($array as $entry) {
                if (is_array($entry) && isset($entry['field'])) {
                    if (!isset($entry['alias']) || is_string($entry['alias'])) {
                        $entry['alias'] = null;
                        $this->addField($entry['field'], $entry['alias']);
                    }
                }
            }
        }

        return $this;
    }

    /**
     * Removes a field from the list of fields to search.
     *
     * @param string Alias of the field to remove
     *
     * @return SphinxQL_Query $this
     */
    public function removeField($alias) {

        if (is_string($alias) && array_key_exists($this->_fields, $alias)) {
            unset($this->_fields[$alias]);
        }

        return $this;
    }

    /**
     * Removes multiple fields at once from the list of fields to search.
     *
     * @param array|mixed List of aliases of fields to remove
     *
     * @return SphinxQL_Query $this
     */
    public function removeFields($array) {
        if (is_array($array)) {
            foreach ($array as $alias) {
                $this->removeField($alias);
            }
        }

        return $this;
    }

    public function setCountFieldOnly()
    {
        $this->_fields = array();
        $this->addField('count(*)');
    }

    public function hasGroupBy()
    {
        return !($this->_group === null && $this->_group_order === null);
    }

    /**
     * Sets the text to be matched against the index(es)
     *
     * @param string Text to be searched
     *
     * @return SphinxQL_Query $this
     */
    public function search($search) {

        if (is_string($search)) {
            $this->_search = Yii::app()->sphinx->quoteValue($search);
        }

        return $this;
    }

	/**
     * Escapes the query for the MATCH() function
     *
     * @param string $string The string to escape for the MATCH
     *
     * @return string The escaped string
     */
    public function escapeMatch($string) {
        $from = array('\\', '(', ')', '|', '-', '!', '@', '~', '"', '&', '/', '^', '$', '=');
        $to = array('\\\\', '\(', '\)', '\|', '\-', '\!', '\@', '\~', '\"', '\&', '\/', '\^', '\$', '\=');

        return str_replace($from, $to, $string);
    }

	/**
     * Escapes the query for the MATCH() function
     * Allows some of the control characters to pass through for use with a search field: -, |, "
     * It also does some tricks to wrap/unwrap within " the string and prevents errors
     *
     * @param string $string The string to escape for the MATCH
     *
     * @return string The escaped string
     */
    public function halfEscapeMatch($string) {
        $from_to = array(
            '\\' => '\\\\',
            '(' => '\(',
            ')' => '\)',
            //'!' => '\!',
            '@' => '\@',
            '~' => '\~',
            '&' => '\&',
            '/' => '\/',
            //'^' => '\^',
            //'$' => '\$',
            //'=' => '\=',
        );

        $string = str_replace(array_keys($from_to), array_values($from_to), $string);

        // this manages to lower the error rate by a lot
        if (substr_count($string, '"') % 2 !== 0) {
            $string .= '"';
        }

        $from_to_preg = array(
            "'\"([^\s]+)-([^\s]*)\"'" => "\\1\-\\2",
            "'([^\s]+)-([^\s]*)'" => "\"\\1\-\\2\""
        );

        $string = preg_replace(array_keys($from_to_preg), array_values($from_to_preg), $string);

        return $string;
    }

    /**
     * Removes the search text from the query.
     *
     * @return SphinxQL_Query $this
     */
    public function removeSearch() {

        $this->_search = null;

        return $this;
    }

    /**
     * Sets the offset for the query
     *
     * @param integer Offset
     *
     * @return SphinxQL_Query $this
     */
    public function offset($offset) {

        if (is_integer($offset)) {
            $this->_offset = $offset;
        }

        return $this;
    }

    /**
     * Sets the limit for the query
     *
     * @param integer Limit
     *
     * @return SphinxQL_Query $this
     */
    public function limit($limit) {

        if (is_integer($limit)) {
            $this->_limit = $limit;
        }

        return $this;
    }

    /**
     * Adds a WHERE condition to the query.
     *
     * @param string The field/expression for the condition
     * @param string The field/expression/value to compare the field to
     * @param string The operator (=, <, >, etc)
     * @param bool Whether or not to quote the value, defaults to true
     *
     * @return SphinxQL_Query $this
     */
    public function where($field, $value, $operator = null, $quote = false) {

        if (!in_array($operator, array('=', '!=', '>', '<', '>=', '<=', 'AND', 'NOT IN', 'IN', 'BETWEEN'))) {
            $operator = '=';
        }
        if (!is_string($field)) {
            return false;
        }
        if (!is_scalar($value)) {
            return false;
        }

        if ($quote) {
            $value = Yii::app()->sphinx->quoteValue($value);
        }

        $this->_wheres[] = array('field' => $field, 'operator' => $operator, 'value' => $value);

        return $this;
    }

    /**
     * Adds a WHERE <field> <not> IN (<value x>, <value y>, <value ...>) condition to the query, mainly used for MVAs.
     *
     * @param string The field/expression for the condition
     * @param array The values to compare the field to
     * @param string Whether this is a match-all, match-any (default) or match-none condition
     *
     * @return SphinxQL_Query $this
     */
    public function whereIn($field, $values, $how = 'any') {

        if (!is_array($values)) {
            $values = array($values);
        }

        if ($how == 'all') {
            foreach ($values as $value) {
                $this->where($field, $value, '=');
            }
        } elseif ($how == 'none') {
            foreach ($values as $value) {
                $this->where($field, $value, '!=');
            }
        } else {
            $this->where($field, '(' . implode(', ', $values) . ')', 'IN', false);
        }

        return $this;
    }

    /**
     * Sets the GROUP BY condition for the query.
     *
     * @param string The field/expression for the condition
     *
     * @return SphinxQL_Query $this
     */
    public function groupBy($field) {

        if (is_string($field)) {
            $this->_group = $field;
        }

        return $this;
    }

    /**
     * Removes the GROUP BY condition from the query.
     *
     * @param string The field/expression for the condition
     * @param string The alias for the result set (optional)
     *
     * @return SphinxQL_Query $this
     */
    public function removeGroupBy($field) {

        $this->_group = null;

        return $this;
    }

    public function getOrders() {
        return $this->_orders;
    }

    public function setOrders(array $orders) {
        $this->_orders = $orders;
        return $this;
    }

    /**
     * Adds an ORDER condition to the query.
     *
     * @param string The field/expression for the condition
     * @param string The sort type (can be 'asc' or 'desc', capitals are also OK)
     *
     * @return SphinxQL_Query $this
     */
    public function order($field, $sort) {

        if (is_string($field) && is_string($sort)) {
            $this->_orders[] = array('field' => $field, 'sort' => $sort);
        }

        return $this;
    }

    /**
     * Sets the WITHIN GROUP ORDER BY condition for the query. This is a
     * Sphinx-specific extension to SQL.
     *
     * @param string The field/expression for the condition
     * @param string The sort type (can be 'asc' or 'desc', capitals are also OK)
     *
     * @return SphinxQL_Query $this
     */
    public function groupOrder($field, $sort) {

        if (is_string($field) && is_string($sort)) {
            $this->_group_order = array('field' => $field, 'sort' => $sort);
        }

        return $this;
    }

    /**
     * Removes the WITHIN GROUP ORDER BY condition for the query. This is a
     * Sphinx-specific extension to SQL.
     *
     * @return SphinxQL_Query $this
     */
    public function removeGroupOrder() {

        $this->_group_order = null;

        return $this;
    }

    /**
     * Adds an OPTION to the query. This is a Sphinx-specific extension to SQL.
     *
     * @param string The option name
     * @param string The option value
     *
     * @return SphinxQL_Query $this
     */
    public function option($name, $value) {

        if (is_string($name) && is_string($value)) {
            $this->_options[] = array('name' => $name, 'value' => $value);
        }

        return $this;
    }

    /**
     * Removes an OPTION from the query.
     *
     * @param string The option name
     * @param string The option value, optional
     *
     * @return SphinxQL_Query $this
     */
    public function removeOption($name, $value = null) {

        $changed = false;

        if (is_string($name) && ( ( $value == null ) || is_string($value) )) {
            foreach ($this->_options as $key => $option) {
                if (( $option['name'] == $name ) && ( ( $value == null ) || ( $value == $option['value'] ) )) {
                    unset($this->_options[$key]);
                    $changed = true;
                }
            }

            if ($changed) {
                array_keys($this->_options);
            }
        }

        return $this;
    }

}