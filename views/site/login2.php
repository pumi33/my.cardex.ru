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




<style>
    input.form-control{

    }
</style>




<div class="app-container app-login">
    <div class="flex-center">
        <div class="app-header"></div>
        <div class="app-body">
            <div class="loader-container text-center">
                <div class="icon">
                    <div class="sk-folding-cube">
                        <div class="sk-cube1 sk-cube"></div>
                        <div class="sk-cube2 sk-cube"></div>
                        <div class="sk-cube4 sk-cube"></div>
                        <div class="sk-cube3 sk-cube"></div>
                    </div>
                </div>
                <div class="title"> <h4><?= Html::encode($this->title) ?></h4></div>
            </div>
            <div class="app-block">


                <div class="app-form">
                    <div class="form-header">
                        <div class="app-brand"><div align="center"><span class="highlight">КАРДЕКС</span></div><br> <?= Html::encode($this->title) ?></div>
                    </div>
                    <?php $form = ActiveForm::begin(['id' => 'account-enter', 'options' => ['class' => 'form-default']]); ?>
                        <div class="input-group">
              <span class="input-group-addon" id="basic-addon1">
                <i class="fa fa-user" aria-hidden="true"></i></span>


                            <?= $form->field($model, 'login')->textInput(['autofocus' => true,'placeholder'=>'Логин', 'aria-describedby'=>"basic-addon1"])->label(false); ?>

                        </div>
                        <div class="input-group">
                <span class="input-group-addon" id="basic-addon2">
                <i class="fa fa-key" aria-hidden="true"></i></span>
                    <?= $form->field($model, 'password')->passwordInput(['autofocus' => true,'placeholder'=>'Пароль', 'aria-describedby'=>"basic-addon2"])->label(false); ?>

                        </div>
                        <div class="text-center">
                            <?= Html::submitButton('Войти', ['class' => 'btn btn-danger btn-submit', 'name' => 'login-button']) ?>
                        </div>

                    <?php ActiveForm::end(); ?>
                    <div class="form-line">
                        <div class="title">ИЛИ</div>
                    </div>
                    <div class="form-footer">
                        <a href="/site/request-password-reset" class="btn btn-default btn-sm btn-social __facebook">
                            <div class="info">
                                <span class="title">Восстановить пароль</span>
                            </div>
                        </a>
                    </div>
                </div>

            </div>
        </div>
        <div class="app-footer">
        </div>
    </div>
</div>