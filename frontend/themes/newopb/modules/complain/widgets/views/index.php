<?php

use \yii\helpers\Html;

?>
<span class="choise-complain none">
<?= Html::a('Fake/Virus', ['/complain/default/fake', 'id' => $recordId], ['class' => 'btn-complain red']) ?>&nbsp;&nbsp;&nbsp;
<?= Html::a('Incorrect description', ['/complain/default/incorrect-description', 'id' => $recordId], ['class' => 'btn-complain red']) ?>
</span>
<a href="#" class="dashed red complain">Complain</a>