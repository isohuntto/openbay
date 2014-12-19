<?php

class Pagination extends CPagination
{

    const DEFAULT_PAGE_SIZE = 35;

    public $pageVar = 'skip';

    public function getCurrentPage($recalculate = true) {
        $page = parent::getCurrentPage($recalculate);
        $page = ($page) ? (($page + 1) / $this->getPageSize()) : $page;
        return (int) $page;
    }

    public function getPageCount() {
        $count = (int) (($this->getItemCount() + $this->getPageSize() - 1) / $this->getPageSize());
        $skipCount = $count * $this->getPageSize();
        return (int) $skipCount;
    }

}
