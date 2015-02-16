<?php

use \yii\helpers\Html;
use \yii\widgets\ActiveForm;
use \himiklab\yii2\recaptcha\ReCaptcha;

?>

<div class="box-comment" id="box-comment">
    <div>
        <?php if ($comments): ?>
            <?php foreach ($comments as $comment): ?>
                <div class="comment" style="margin-left:<?= ($comment->depth - 1) * 30 ?>px">
                    <a id="comment-author-<?= $comment->id ?>" href="#"><?= Html::encode($comment->author) ?></a>

                    <div>
                        <span class="font-12 grey"><?= date('j F Y, G:i', $comment->created_at) ?> </span> | <span>Rating: <span
                                id="comment-rating-<?= $comment->id ?>" class="<?= $comment->rating >= 0 ? 'green' : 'red' ?>"><?= $comment->rating ?></span>
                            <?= Html::a("+", ['/comment/default/rating', 'id' => $comment->id, 'action' => 'up'], ['class' => 'btn-comment-rating green bold', 'id' => 'btn-comment-rating-' . $comment->id]) ?>
                            <?= Html::a("-", ['/comment/default/rating', 'id' => $comment->id, 'action' => 'down'], ['class' => 'btn-comment-rating red bold', 'id' => 'btn-comment-rating-' . $comment->id]) ?>
                            <div class="comment-text">
                                <span
                                    class="comment-text-span"><?= Html::encode($minRating >= $comment->rating ? $defaultComment : $comment->comment) ?></span>
                                <?= Html::a("Reply", "#comment-reply", ["id" => "comment-reply-" . $comment->id, "class" => "reply-comment id-link dashed"]) ?>
                            </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            This cabin is empty and no one had not speak a word. And grumpy Jack Tar sits in the corner waiting for your comment.
        <?php endif; ?>
    </div>

    <?php $form = ActiveForm::begin([
        'id' => 'login-form',
        'fieldConfig' => [
            'template' => '<p class="bold">{label}</p><div>{input}</div><div style="color:red;">{error}</div>'
        ]
    ]); ?>
    <?= Html::activeHiddenInput($model, 'record_id') ?>
    <?= Html::activeHiddenInput($model, 'parentId', ['id' => 'comment-parent']) ?>
    <div id="comment-reply" class="reply-block none">
        <span>Reply to comment, <span id="comment-reply-author"
                                      class="bold"></span> <?= Html::a('Cancel', '#', ['id' => 'btn-reply-cancel', 'class' => 'dashed reply-canel']) ?></span>
    </div>
    <div>
        <?= $form->field($model, 'comment')->textarea(['class' => 'description font-14']) ?>
    </div>
    <br>

    <div>
        <?php if (\Yii::$app->user->isGuest): ?>
            <p class="font-12 grey">*Ahoy! <a href="#">Register</a> and log in OldPirateBay and see no captcha anymore!
            </p>
            <?=
            $form->field($model, 'reCaptcha')->widget(
                ReCaptcha::className(),
                [
                    'siteKey' => \Yii::$app->getModule('comment')->reCaptchaSiteKey
                ]
            ) ?>
        <?php endif; ?>
    </div>
    <br>
    <?= Html::submitButton('Add comment', ['class' => 'button', 'name' => 'login-button', 'id' => 'addComment']) ?>
    <?php ActiveForm::end(); ?>
</div>