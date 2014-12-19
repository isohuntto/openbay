<?php

class ESphinxDataProvider extends CActiveDataProvider {

    /**
     * Fetches the data from the persistent data storage.
     * @return array list of data items
     */
    protected function fetchData() {
        return $this->model->findAll($this->getCriteria());
    }

    /**
     * Calculates the total number of data items.
     * @return integer the total number of data items.
     */
    protected function calculateTotalItemCount() {        
        return $this->getPagination()->getItemCount();
    }

}
