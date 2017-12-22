<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */

/* @var $model \common\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Вход для юридических лиц';
//$this->params['breadcrumbs'][] = $this->title;


//$form->field($model, 'login')->textInput(['autofocus' => true])

//$form->field($model, 'password')->passwordInput()


?>


<div class="new-login-box">
    <div class="white-box">
        <h3 class="box-title m-b-0" style="margin-left: 15px">Восстановление пароля</h3>


        <?php $form2 = ActiveForm::begin(['id' => 'recoverform2', 'action' => '/site/request-password-reset', 'options' => ['class' => 'form-horizontal']]); ?>
        <br><br>
        <div class="form-group ">
            <div class="col-xs-12">
                <h3>Восстановление пароля</h3>
                <p>Чтобы восстановить пароль, введите ваш Логин</p>
                <p>Не получилось восстановить пароль?</p>
                <p>Обратитесь в службу поддержки: <a href="tel:<?= \Yii::$app->params['phone']; ?>"><?= \Yii::$app->params['phone']; ?></a></p>
            </div>
        </div>
        <div class="form-group ">
            <div class="col-xs-12">


                <?= $form2->field($model2, 'login')->textInput(['autofocus' => true, 'placeholder' => 'Логин', 'class' => 'form-control input-reset-password'])->label(false); ?>
            </div>
        </div>
        <div class="form-group text-center m-t-20">
            <div class="col-xs-12">
                <button class="btn btn-primary btn-lg btn-block text-uppercase waves-effect waves-light" type="submit">Сбросить</button>
            </div>
        </div>
        </form>
        <?php ActiveForm::end(); ?>
    </div>
</div>