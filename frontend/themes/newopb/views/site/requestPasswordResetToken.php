<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\PasswordResetRequestForm */

$this->title = 'Request password reset';
?>
<?php $form = ActiveForm::begin(['id' => 'request-password-reset-form']); ?>
    <p class="text-recover">Harr! Yer old password\login were washed away by storm?<br/> Put yer e-mail address in the field above and click “Recover” button. We’ll send ya further instructions.</p>
    <div class="txt-center login-box">
        <div>
            <?= $form->field($model, 'email', ['template' => '{input}'])->label(false)->textInput(['placeholder' => 'E-mail']); ?>
        </div>
    </div>
    <div class="txt-center search-button">
        <?= Html::submitButton('Recover', ['class' => 'button', 'title' => 'Recover']) ?>
    </div>
<?php ActiveForm::end(); ?>
