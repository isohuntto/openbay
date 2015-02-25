<?php

use yii\helpers\Html;
use yii\helpers\Url;

$followUrl = Url::to(['/feed/default/follow', 'name' => $user->username]);
$unfollowUrl = Url::to(['/feed/default/unfollow', 'name' => $user->username]);
?>

<?php if ($authed && !$myProfile) : ?>
    <div class="FollowWidget">
        <?php if (!$myProfile) : ?>
            <?=
            Html::a($following ? 'Unfollow' : 'Follow', $following ? $unfollowUrl : $followUrl, [
                'class' => $following ? 'btn btn-danger' : 'btn btn-success',
                'data-follow-url' => $followUrl,
                'data-unfollow-url' => $unfollowUrl,
            ]);
            ?>
        <?php endif; ?>
    </div>
<?php endif; ?>
