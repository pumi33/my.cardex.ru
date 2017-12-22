<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\ResetPasswordForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'ВОССТАНОВЛЕНИЕ ПАРОЛЯ';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-reset-password">
    <h1><?= Html::encode($this->title) ?></h1>

    <p>Please choose your new password:</p>

    <div class="row">
        <div class="col-lg-5">
            <?php $form = ActiveForm::begin(['id' => 'reset-password-form']); ?>

                <?= $form->field($model, 'password')->passwordInput(['autofocus' => true]) ?>

                <div class="form-group">
                    <?= Html::submitButton('Save', ['class' => 'btn btn-primary']) ?>
                </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>


<div class="enter">
    <div class="enter__title">
        <h4>ВОССТАНОВЛЕНИЕ ПАРОЛЯ</h4>

    </div>
    <form id="pass-recover" class="form-default" action="/site/passremind" method="post">
        <div class="form-default__input">
            <label for="phone">введите номер телефона в формате (+79123456789)</label>
            <!--<input name="phone" id="phone">-->
            <input class="form" id="phone" data-mask="+7(000)-000-00-00" name="PassremindForm[contact]" type="text" />        </div>

        <div class="form-default__submit">
            <div class="text-centered">

                <input class="more btn btn-red wide" name="yt0" type="button" value="Выслать код" id="yt0" />            </div>
        </div>
    </form>
    <div class="enter__desc">
        <p>Чтобы восстановить пароль, введите номер вашего <br> телефона в федеральном формате (+79123456789)</p>

        <p>Не получилось восстановить пароль?</p>
        <p>Обратитесь в службу поддержки: (3466) 291-009</p>
    </div>
</div>
