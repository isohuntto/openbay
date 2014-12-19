<?php

class TorrentTagsColumn_ extends CDataColumn
{

    public $value = '';

    public $tag = '';

    protected function renderDataCellContent($row, $data)
    {
        $tag = empty($this->tag) ? $data->getCategoryTag() : $this->tag;
        $class = preg_replace('#\W+#ui', '', mb_strtolower($tag));
        echo '<span class="torrent-icon torrent-icon-' . $class . '" title="' . $tag . '"></i>';
    }
}