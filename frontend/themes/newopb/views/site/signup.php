<?php

use yii\widgets\ActiveForm;
use yii\helpers\Html;

$this->title = "Sign Up";
?>
<?php $form = ActiveForm::begin(['id' => 'login-form', 'errorSummaryCssClass' => 'errors']); ?>
<form>
    <div class="txt-center login-box">
        <?php // TODO: errors! ?>
        <?= $form->errorSummary($model, ['header' => '']); ?>
        <?= $form->field($model, 'username', ['template' => '{input}'])->label(false)->textInput(['placeholder' => 'Username']) ?>
        <?= $form->field($model, 'password', ['template' => '{input}'])->label(false)->passwordInput(['placeholder' => 'Password']) ?>
        <?= $form->field($model, 'email', ['template' => '{input}'])->label(false)->textInput(['placeholder' => 'E-mail']) ?>
        <?php /*TODO        <div class="txt-left">
            <p class="bold">Verification Code:</p>
            <a href="#" class="border-none disabled" id="captcha-image"><img src="./images/captcha.png"/></a><br/>
        </div>
        <div>
            <input type="text"  placeholder="Captchcode">
        </div>*/ ?>
        <div class="txt-center search-button">
            <?= Html::submitButton('Register now', ['class' => 'button', 'name' => '', 'title' => 'Register']) ?>
        </div>
    </div>
<?php ActiveForm::end(); ?>
