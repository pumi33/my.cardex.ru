<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Активация записи';


?>


<div class="new-login-box">
    <div class="white-box">
        <h3 class="box-title m-b-0" style="margin-left: 15px"><?= $this->title ?></h3>

        <br><br>

        <?
        if ($model->_user->status == '10') {
            print "Логин: <b>" . mb_substr($model->_user->login, 2) . "</b><br><br>";
        }
        ?>


        <p>Придумайте
            <? if ($model->_user->status != '10') print  "логин и "; ?>
            пароль</p>

        <?php $form = ActiveForm::begin(['id' => 'account-enter', 'options' => ['class' => 'form-default']]); ?>

        <? if ($model->_user->status != '10') { ?>
            <?= $form->field($model, 'login')->textInput(['autofocus' => true, 'placeholder' => 'Логин', 'aria-describedby' => "basic-addon1"])->label(false); ?>
        <? } ?>

        <?= $form->field($model, 'password')->passwordInput(['autofocus' => true, 'placeholder' => 'Пароль', 'aria-describedby' => "basic-addon2"])->label(false); ?>

        <?= $form->field($model, 'repeatnewpass')->passwordInput(['autofocus' => true, 'placeholder' => 'Повторите пароль', 'aria-describedby' => "basic-addon2"])->label(false); ?>



        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-danger btn-submit', 'name' => 'login-button']) ?>

        <?php ActiveForm::end(); ?>
    </div>
</div>








