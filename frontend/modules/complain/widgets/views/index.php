<?php

use \yii\helpers\Html;

?>

<?= Html::a('Incorrect description', ['/complain/default/incorrect-description', 'id' => $recordId], ['class' => 'btn-complain']) ?>&nbsp;&nbsp;&nbsp;
<?= Html::a('Fake', ['/complain/default/fake', 'id' => $recordId], ['class' => 'btn-complain']) ?>&nbsp;&nbsp;&nbsp;
<?= Html::a('Virus', ['/complain/default/virus', 'id' => $recordId], ['class' => 'btn-complain']) ?>