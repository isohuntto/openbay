<?php
use yii\helpers\Html;
?>
<span id="rating">
<?php for($i = $min; $i <= $max; $i=$i+$step): ?>
    <?= Html::a($i, ['/rating/default/set', 'id'=>$recordId, 'rating'=>$i], ['class' => 'btn-rating'])?>
<?php endfor; ?>
</span>