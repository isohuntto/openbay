<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\PasswordResetRequestForm */

$this->title = 'Reset password';
?>
<?php $form = ActiveForm::begin(['id' => 'request-password-reset-form']); ?>
<?php /* TODO */ ?>
    <p class="text-recover">Please choose your new password</p>
    <div class="txt-center login-box">
        <div>
            <?= $form->field($model, 'password', ['template' => '{input}'])->label(false)->passwordInput(['placeholder' => 'Password']); ?>
        </div>
    </div>
    <div class="txt-center search-button">
        <?= Html::submitButton('Save', ['class' => 'button', 'title' => 'Save']) ?>
    </div>
<?php ActiveForm::end(); ?>
