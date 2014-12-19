<?php

class Pager extends CLinkPager
{

    public $cssFile = false;

    public $header = '<nav>';
    
    public $footer = '</nav>';
    
    public $firstPageLabel = false;

    public $lastPageLabel = false;

    public $selectedPageCssClass = 'active';

    public $hiddenPageCssClass = 'disabled';
    
    public $htmlOptions = array('class' => 'pagination');

    public function init()
    {
        if ($this->prevPageLabel === null) {
            $this->prevPageLabel = Yii::t('site_texts', 'Prev');
        }

        if ($this->nextPageLabel === null) {
            $this->nextPageLabel = Yii::t('site_texts', 'Next');
        }
        parent::init();
    }

    public function run()
    {
        parent::run();
        $this->setPrevNextMetaTags();
    }


    protected function createPageButtons()
    {
        if (($pageCount = $this->getPageCount()) <= 1)
            return array();

        list ($beginPage, $endPage) = $this->getPageRange();
        $currentPage = $this->getCurrentPage(false); // currentPage is calculated in getPageRange()
        $buttons = array();

        // first page
        if ($this->firstPageLabel) {
            $buttons[] = $this->createPageButton($this->firstPageLabel, 0, $this->firstPageCssClass, $currentPage <= 0, false);
        }

        // prev page
        if ($this->prevPageLabel) {
            if (($page = $currentPage - 1) < 0)
                $page = 0;
            $buttons[] = $this->createPageButton($this->prevPageLabel, $page, $this->previousPageCssClass, $currentPage <= 0, false);
        }

        // internal pages
        for ($i = $beginPage; $i <= $endPage; ++ $i)
            $buttons[] = $this->createPageButton($i + 1, $i, $this->internalPageCssClass, false, $i == $currentPage);

            // next page
        if ($this->nextPageLabel) {
            if (($page = $currentPage + 1) >= $pageCount - 1)
                $page = $pageCount - 1;
            $buttons[] = $this->createPageButton($this->nextPageLabel, $page, $this->nextPageCssClass, $currentPage >= $pageCount - 1, false);
        }

        // last page
        if ($this->lastPageLabel) {
            $buttons[] = $this->createPageButton($this->lastPageLabel, $pageCount - 1, $this->lastPageCssClass, $currentPage >= $pageCount - 1, false);
        }

        return $buttons;
    }

    protected function createPageUrl($page)
    {
        $page = $page * $this->getPages()->getPageSize();
        $page = ($page) ? $page - 1 : $page;
        return $this->getPages()->createPageUrl($this->getController(), $page);
    }

    public function getPageCount()
    {
        $skipCount = $this->getPages()->getPageCount();
        $pageSize = $this->getPages()->getPageSize();
        return ($skipCount) ? $skipCount / $pageSize : $skipCount;
    }

    protected function setPrevNextMetaTags()
    {
        $count = $this->getPageCount();
        $current = $this->getCurrentPage(false);

        if ($count > 1) {
            if ($current > 0 && ($current + 1 <= $count)) {
                Yii::app()->clientScript->registerLinkTag('prev', null, $this->createPageUrl($current - 1));
            }
            if ($current + 1 < $count) {
                Yii::app()->clientScript->registerLinkTag('next', null, $this->createPageUrl($current + 1));
            }
        }
    }
}