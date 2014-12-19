<?php
/**
 * DataColumn extension with ability to render content with HTML code
 */
class UnescapedDataColumn extends CDataColumn {
    protected function renderDataCellContent($row, $data)
    {
        $value=$this->evaluateExpression($this->value,array('data'=>$data,'row'=>$row));
        echo $value;
    }
}