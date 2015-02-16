<?php
use yii\widgets\ActiveForm;
use yii\helpers\Html;

$this->title = "Login";
?>
<?php $form = ActiveForm::begin(['id' => 'login-form', 'errorSummaryCssClass' => 'errors']); ?>
    <div class="txt-center login-box">
        <?php // TODO: errors! ?>
        <?= $form->errorSummary($model, ['header' => '']); ?>
        <?= $form->field($model, 'username', ['template' => '{input}'])->label(false)->textInput(['placeholder' => 'Username']) ?>
        <?= $form->field($model, 'password', ['template' => '{input}'])->label(false)->passwordInput(['placeholder' => 'Password']) ?>
    </div>
    <p class="txt-center">Forgotten your password? <?= Html::a('Click here', ['site/request-password-reset']); ?> to recover it.</p>
    <div class="txt-center search-button">
        <?= Html::submitButton('Login', ['class' => 'button', 'name' => '', 'title' => 'Login']) ?>
    </div>
<?php ActiveForm::end(); ?>
