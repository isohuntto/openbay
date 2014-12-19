<?php

class TorrentDescriptionColumn extends CDataColumn
{

    const SUBCATEGORY_GROUP_ID = 1;

    public $name = '';

    public $icon = '';

    public $additionalInfo = '';

    public $headerUrl = '#';

    protected function renderDataCellContent($row, $data)
    {
        $categoryTag = $data->getCategoryTag();
        $html = '';

        $html .= "<div style='float: right; height: 16px;'>"
                . "<a href='" . $data->getMagnetLink() . "' title='MAGNET LINK'><img src='/img/icons/magnet.png'/></a>"
              .  "</div>";

        $label = CHtml::tag('span', array(), $data->name);
        $html .= CHtml::link($label, $data->getUrl());

        $html .= '<br><em>';
        $html .= '<small>Download from <a href="' . Yii::app()->controller->createUrl('main/search', array('iht' => $data->getCategoryTagId(), 'age' => 0))  . '" title="Browse ' . $categoryTag . ' torrents">' . ucfirst($categoryTag) . '</a>';
        $html .= '</small>';

        echo $html;
    }
}
