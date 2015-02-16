<?php

use \yii\helpers\Html;
use \yii\widgets\ActiveForm;
use \himiklab\yii2\recaptcha\ReCaptcha;

?>

<div class="comments">
    <h4>Comments</h4>
    <?php if ($comments): ?>
        <?php foreach ($comments as $comment): ?>
            <div style="padding-left: <?= ($comment->depth - 1) * 30 ?>px" class="comment">
                <h4 id="comment-author-<?= $comment->id ?>"><?= Html::encode($comment->author) ?></h4>
                <h5><?= date('Y-m-d H:i:s', $comment->created_at) ?> |

                    Rating: <span id="comment-rating-<?= $comment->id ?>"><?= $comment->rating ?></span>
                    <?= Html::a("+1", ['/comment/default/rating', 'id' => $comment->id, 'action' => 'up'], ['class' => 'btn-comment-rating', 'id' => 'btn-comment-rating-' . $comment->id]) ?>
                    <?= Html::a("-1", ['/comment/default/rating', 'id' => $comment->id, 'action' => 'down'], ['class' => 'btn-comment-rating', 'id' => 'btn-comment-rating-' . $comment->id]) ?>
                </h5>
                <?php if ($minRating >= $comment->rating): ?>
                    <p><?= Html::encode($defaultComment) ?></p>
                <?php else: ?>
                    <?= Html::encode($comment->comment) ?>
                <?php endif; ?>
                <br>
                <br>
                <?= Html::a("Reply", "#", ["id" => "comment-reply-" . $comment->id, "class" => "reply-comment"]) ?>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        This cabin is empty and no one had not speak a word. And grumpy Jack Tar sits in the corner waiting for your comment.
    <?php endif; ?>
    <br>
    <br>
    <br>

    <div>
        <?php $form = ActiveForm::begin([
            'id' => 'login-form',
            'fieldConfig' => [
                'template' => '{label}<br><div>{input}</div><div style="color:red;">{error}</div>'
            ]
        ]);
        ?>
        <?= Html::activeHiddenInput($model, 'record_id') ?>
        <?= Html::activeHiddenInput($model, 'parentId', ['id' => 'comment-parent']) ?>
        <div id="comment-reply" class="comment-reply">
            <h5>Reply to comment, <b><span
                        id="comment-reply-author"></span></b> <?= Html::a('Cancel', '#', ['id' => 'btn-reply-cancel']) ?>
            </h5>
        </div>
        <?= $form->field($model, 'comment')->textarea() ?>
        <?php if (\Yii::$app->user->isGuest): ?>
            <br>
            <?= $form->field($model, 'reCaptcha')->widget(
                ReCaptcha::className(),
                [
                    'siteKey' => \Yii::$app->getModule('comment')->reCaptchaSiteKey
                ]
            ) ?>
        <?php endif; ?>
        <br>

        <div>
            <?= Html::submitButton('Add comment', ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>
        </div>
        <?php ActiveForm::end(); ?>
    </div>
</div>