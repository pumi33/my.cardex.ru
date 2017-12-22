<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Восстановление пароля';
//$this->params['breadcrumbs'][] = $this->title;


//$form->field($model, 'login')->textInput(['autofocus' => true])

//$form->field($model, 'password')->passwordInput()


?>





<div class="new-login-box">
    <div class="white-box">
        <h3 class="box-title m-b-0" style="margin-left: 15px"><?=$this->title?></h3>

        <br><br>

        <?php $form = ActiveForm::begin(['id' => 'account-enter', 'options' => ['class' => 'form-default']]); ?>

        Придумайте новый пароль:

        <?= $form->field($model, 'password')->passwordInput(['autofocus' => true,'placeholder'=>'Пароль', 'aria-describedby'=>"basic-addon2"])->label(false); ?>

        <?= $form->field($model, 'repeatnewpass')->passwordInput(['autofocus' => true,'placeholder'=>'Пароль', 'aria-describedby'=>"basic-addon2"])->label(false); ?>


        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-danger btn-submit', 'name' => 'login-button']) ?>

        <?php ActiveForm::end(); ?>
    </div>
</div>









