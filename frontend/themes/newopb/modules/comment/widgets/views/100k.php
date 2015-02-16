<?php

use \yii\helpers\Html;
use \yii\widgets\ActiveForm;
use \himiklab\yii2\recaptcha\ReCaptcha;

?>


<section class="discussion">
    <div class="wrp">
        <h2>Discussion</h2>

        <div class="discussion-items">
            <?php if ($comments): ?>
                <?php foreach ($comments as $comment): ?>
                    <article style="margin-left:<?= ($comment->depth - 1) * 20 ?>px">
                        <div class="head">
                            <a id="comment-author-<?= $comment->id ?>"
                               href="#"><?= Html::encode($comment->author) ?></a> | Rating:
                            <em id="comment-rating-<?= $comment->id ?>"
                                class="<?= $comment->rating >= 0 ? 'green' : 'red' ?>"><?= $comment->rating ?></em>
                            <?= Html::a("+", ['/comment/default/rating', 'id' => $comment->id, 'action' => 'up'], ['class' => 'plus btn-comment-rating', 'id' => 'btn-comment-rating-' . $comment->id]) ?>
                            <?= Html::a("-", ['/comment/default/rating', 'id' => $comment->id, 'action' => 'down'], ['class' => 'minus btn-comment-rating', 'id' => 'btn-comment-rating-' . $comment->id]) ?>
                        </div>
                        <p>
                            <span><?= Html::encode($minRating >= $comment->rating ? $defaultComment : $comment->comment) ?></span>
                        </p>

                        <div class="foot">
                            <?= date('j F Y, G:i', $comment->created_at) ?> <?= Html::a("Reply", "#comment-reply", ["id" => "comment-reply-" . $comment->id, "class" => "reply-comment"]) ?>
                        </div>
                    </article>
                <?php endforeach; ?>
            <?php else: ?>
                This cabin is empty and no one had not speak a word. And grumpy Jack Tar sits in the corner waiting for your comment.
            <?php endif; ?>
        </div>
        <div class="answer">
            <div id="comment-reply" class="reply-block">
                <span>Reply to comment, <span
                        id="comment-reply-author"></span> <?= Html::a('Cancel', '#', ['id' => 'btn-reply-cancel', 'class' => 'reply-canel']) ?></span>
            </div>

            <h4>Comment:</h4>
            <?php $form = ActiveForm::begin([
                'id' => 'login-form',
                'fieldConfig' => [
                    'template' => '<div>{input}</div><div style="color:red;">{error}</div>'
                ]
            ]); ?>
            <?= Html::activeHiddenInput($model, 'record_id') ?>
            <?= Html::activeHiddenInput($model, 'parentId', ['id' => 'comment-parent']) ?>
            <?= $form->field($model, 'comment')->textarea() ?>
            <div>
                <?php if (\Yii::$app->user->isGuest): ?>
                    <p>*Ahoy! <?= Html::a('Register', '/site/signup')?> and log in OldPirateBay and see no captcha anymore!</p>
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
            <?= Html::submitButton('Add comment', ['class' => 'btn', 'name' => 'login-button', 'id' => 'addComment']) ?>
            <?php ActiveForm::end(); ?>
        </div>
    </div>
</section>