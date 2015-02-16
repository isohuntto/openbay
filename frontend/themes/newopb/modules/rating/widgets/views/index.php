<?php
use yii\helpers\Html;
use yii\helpers\Url;
?>
<div id="rating" class="rating">
    <span class="star-rating">
<?php for($i = $min; $i <= $max; $i=$i+$step): ?>
    <?= Html::input('radio', 'rating', $i, ['class' => 'btn-rating', 'data-href' => Url::to(['/rating/default/set', 'id'=>$recordId, 'rating'=>$i])])?><i></i>
<?php endfor; ?>
</div>

<div class="rating-stat none">
<?php for($i = $max; $i >= $min; $i=$i-$step): ?>
    <?php $isRating = false; ?>
    <?php foreach($ratingStats as $ratingStat): ?>
        <?php if($ratingStat->rating == $i):?>
            <p><strong><?= $ratingStat->rating ?></strong> (<span id="rating-stat-<?= $i ?>"><?= $ratingStat->count ?></span>)</p>
            <?php $isRating = true; break; ?>
        <?php endif; ?>
    <? endforeach; ?>
    <?php if(!$isRating): ?>
        <p><strong><?= $i ?></strong> (<span id="rating-stat-<?= $i ?>">0</span>)</p>
    <?php endif; ?>
<?php endfor; ?>
</div>