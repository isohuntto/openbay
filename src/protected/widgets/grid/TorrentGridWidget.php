<?php
Yii::import('zii.widgets.grid.CGridView');

class TorrentGridWidget extends CGridView
{

    public $cssFile = false;

    public $loadingCssClass = false;

    public $baseScriptUrl = '/widgets/gridview/';

    public $itemsCssClass = 'table table-striped table-hover';

    public $initScripts = true;

    public $tag = '';

    public $renderKeys = true;

    function init()
    {
        $this->columns = array_merge(array(

            'title' => array(
                'class' => 'application.widgets.grid.TorrentDescriptionColumn',
                'header' => Yii::t('site_texts', 'Torrents'),
                'headerHtmlOptions' => array(
                    'class' => 'title-row'
                ),
                'htmlOptions' => array(
                    'class' => 'title-row'
                )
            ),
        ), $this->columns);

        $this->columns = array_merge($this->columns, array(
            'created_at' => array(
                'name' => 'created_at',
                'header' => Yii::t('site_texts', 'Age'),
                'value' => 'Yii::app()->format->age($data->created_at)',
                'headerHtmlOptions' => array(
                    'class' => 'date-row'
                ),
                'htmlOptions' => array(
                    'class' => 'date-row'
                )
            ),
            'size' => array(
                'name' => 'size',
                'header' => Yii::t('site_texts', 'Size'),
                'type' => 'size',
                'headerHtmlOptions' => array(
                    'class' => 'size-row'
                ),
                'htmlOptions' => array(
                    'class' => 'size-row'
                )
            ),
            'seeders' => array(
                'name' => 'seeders',
                'header' => Yii::t('site_texts', 'S'),
                'headerHtmlOptions' => array(
                    'class' => 'seeders-row'
                ),
                'cssClassExpression' => '$data->seeders > 0 ? "sy" : "sn"',
                'htmlOptions' => array(
                    'class' => 'seeders-row'
                )
            ),
            'leechers' => array(
                'name' => 'leechers',
                'header' => Yii::t('site_texts', 'L'),
                'headerHtmlOptions' => array(
                    'class' => 'leechers-row'
                ),
                'cssClassExpression' => '$data->leechers > 0 ? "ly" : "ln"',
                'htmlOptions' => array(
                    'class' => 'leechers-row'
                )
            ),
        ));


        parent::init();
    }

    public function registerClientScript()
    {
        if ($this->initScripts) {
            return parent::registerClientScript();
        }

        return;
    }

    /**
     * Renders the data items for the grid view.
     */
    public function renderItems()
    {
        if ($this->dataProvider->getItemCount() > 0 || $this->showTableOnEmpty) {
            echo "<table class=\"table-torrents {$this->itemsCssClass}\">\n";
            $this->renderTableHeader();
            ob_start();
            $this->renderTableBody();
            $body = ob_get_clean();
            $this->renderTableFooter();
            echo $body; // TFOOT must appear before TBODY according to the standard.
            echo "</table>";
        } else {
            $this->renderEmptyText();
        }
    }

    public function renderKeys()
    {
        if ($this->renderKeys) {
            parent::renderKeys();
        }
    }

    /**
     * Renders the table body.
     */
    public function renderTableBody()
    {
        $data = $this->dataProvider->getData();

        $n = count($data);
        echo "<tbody>\n";

        if ($n > 0) {
            // Render correct data
            for ($row = 0; $row < $n; ++ $row) {
                $this->renderTableRow($row);
            }
        } else {
            echo '<tr><td colspan="' . count($this->columns) . '" class="empty">';
            $this->renderEmptyText();
            echo "</td></tr>\n";
        }
        echo "</tbody>\n";
    }

}
