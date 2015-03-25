<?php
use \yii\helpers\Html;

?>

<?php if($isFollowing): ?>
    <?= Html::a('Unfollow', '/unfollow/'.$username) ?>
<?php else: ?>
    <?= Html::a('Follow this lad\'s torrents', '/follow/'.$username) ?>
<?php endif; ?>