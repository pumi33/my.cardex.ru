<?php
/**
 * Created by PhpStorm.
 * User: DevAdmin
 * Date: 23.06.2017
 * Time: 16:27
 */

use yii\helpers\Html;
use  my\helpers\Help;


$this->registerJs("
$(document).ready(function () {
    $('#ftheme').change(function () {
        window.location.href='?theme='+this.value;
    });
});
 ");
?>


<div class="row">

    <?


    print Html::dropDownList('theme', $theme, \Yii::$app->params['feedbackList'], ['class' => 'form-control add_own addin', 'prompt' => 'Выберите тему сообщения', 'id' => 'ftheme'])
    ?>
</div>