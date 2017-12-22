<?php

use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use my\models\User;


$this->registerJsFile("https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.11/jquery.mask.min.js");


$this->registerJs("

 $('#user-phone').mask('(000) 000 0000');

");


?>


<div class="col-sm-12">


    <div class="white-box">
        <!-- Nav tabs -->
        <ul class="nav customtab nav-tabs" role="tablist">
            <li role="presentation" class="<?= !isset($_GET['change-password']) ? 'active' : '' ?>"><a href="#home1"
                                                                                                       aria-controls="home"
                                                                                                       role="tab"
                                                                                                       data-toggle="tab"
                                                                                                       aria-expanded="true"><span
                            class="visible-xs"><i class="ti-home"></i></span><span class="hidden-xs"> Профиль</span></a>
            </li>
            <? if ($user->login == \Yii::$app->user->identity->login) { ?>
                <li role="presentation" class="<?= isset($_GET['change-password']) ? 'active' : '' ?>"><a
                            href="#profile1" aria-controls="profile" role="tab" data-toggle="tab" aria-expanded="false"><span
                                class="visible-xs"><i class="ti-user"></i></span> <span
                                class="hidden-xs">Сменить пароль</span></a></li>
            <? } ?>
        </ul>
        <!-- Tab panes -->
        <div class="tab-content">
            <div role="tabpanel" class="tab-pane fade <?= !isset($_GET['change-password']) ? 'active in' : '' ?>"
                 id="home1">
                <div class="col-md-12">

                    <div class="white-box">

                        <div class="row">
                            <div class="col-md-6">


                                <? $form = ActiveForm::begin(['id' => 'account-enter', 'options' => ['class' => 'form-default']]); ?>

                                <? if ($user->login == \Yii::$app->user->identity->login) { ?>
                                    <?= $form->field($user, 'login')->textInput(['disabled' => true]) ?>
                                <? } ?>



                                <?= $form->field($user, 'surname')->textInput(['disabled' => !(Yii::$app->user->can('edits') or ($user->login == Yii::$app->user->identity->login))]) ?>

                                <?= $form->field($user, 'first_name')->textInput(['disabled' => !(Yii::$app->user->can('edits') or ($user->login == Yii::$app->user->identity->login))]) ?>

                                <?= $form->field($user, 'patronymic')->textInput(['disabled' => !(Yii::$app->user->can('edits') or ($user->login == Yii::$app->user->identity->login))]) ?>


                                <?= $form->field($user, 'email')->input('email')->textInput(['disabled' => !(Yii::$app->user->can('edits') or ($user->login == Yii::$app->user->identity->login))]) ?>

                                <div class="row">
                                    <div class="col-md-8">
                                        <?= $form->field($user, 'phone')->textInput(['placeholder' => '(XXX) XXX XX XX', 'disabled' => !(Yii::$app->user->can('edits') or ($user->login == Yii::$app->user->identity->login))]) ?>
                                    </div>

                                    <div class="col-md-4">
                                        <?= $form->field($user, 'phone_dob')->textInput(['disabled' => !(Yii::$app->user->can('edits') or ($user->login == Yii::$app->user->identity->login))]) ?>
                                    </div>
                                </div>


                                <?= $form->field($user, 'position')->textInput(['disabled' => !(Yii::$app->user->can('edits') or ($user->login == Yii::$app->user->identity->login))]) ?>

                                <?
                                //if($user->status!=10)


                                unset(\Yii::$app->params['role'][10]);

                                if (Yii::$app->user->can('edits')) {
                                    //if(\Yii::$app->user->can('createManage')){

                                    if ($user->status != User::STATUS_SUPERADMIN) {
                                        echo $form->field($user, 'status')->dropdownList(
                                            \Yii::$app->params['role']
                                        );
                                    }
                                }


                                ?>
                                <br>
                                <? if ((Yii::$app->user->can('edits') or ($user->login == Yii::$app->user->identity->login))) { ?>

                                    <div class="form-group" align="right">
                                        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-info waves-effect waves-light  m-r-10', 'name' => 'login-button']) ?>
                                    </div>

                                <? } ?>

                                <?php ActiveForm::end(); ?>


                            </div>


                        </div>
                    </div>
                </div>

                <div class="clearfix"></div>
            </div>


            <? if ($user->login == \Yii::$app->user->identity->login) { ?>
                <div role="tabpanel" class="tab-pane fade <?= isset($_GET['change-password']) ? 'active in' : '' ?>"
                     id="profile1">
                    <div class="col-md-6">

                        <? $form2 = ActiveForm::begin(['id' => 'account-enter2', 'action' => '/user/update-password', 'options' => ['class' => 'form-default']]); ?>
                        <?= $form2->field($password, 'oldpass')->passwordInput() ?>
                        <?= $form2->field($password, 'newpass')->passwordInput() ?>
                        <?= $form2->field($password, 'repeatnewpass')->passwordInput() ?>
                        <div class="form-group" align="right">
                            <?= Html::submitButton('Сохранить', ['class' => 'btn btn btn-info waves-effect waves-light', 'name' => 'login-button']) ?>
                        </div>
                        <?php ActiveForm::end(); ?>

                    </div>

                    <div class="clearfix"></div>
                </div>
            <? } ?>


        </div>
    </div>


</div>

