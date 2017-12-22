<?php
/**
 * Created by PhpStorm.
 * User: DevAdmin
 * Date: 23.06.2017
 * Time: 16:32
 */
$this->title = 'Служба поддержки';

use yii\bootstrap\ActiveForm;
use kartik\select2\Select2;
use yii\helpers\Html;
use  my\helpers\Help;


$this->registerCssFile("/plugins/bower_components/dropify/dist/css/dropify.min.css");
$this->registerJsFile('/plugins/bower_components/dropify/dist/js/dropify.min.js');


$this->registerJs("


         
            // Translated
          $('.dropify').dropify({
                messages: {
                    default: 'Переместите файл  для загрузки'
                    , replace: ''
                    , remove: 'Удалить'
                    , error: 'Произошла ошибка'
                }
            });
            // Used events
            var drEvent = $('#input-file-events').dropify();
            drEvent.on('dropify.beforeClear', function (event, element) {
                   return confirm(\"Do you really want to delete \\\" \" + element.file.name + \"\\\" ? \");
            });
            drEvent.on('dropify.afterClear', function (event, element) {
                alert('File deleted');
            });
            drEvent.on('dropify.errors', function (event, element) {
                console.log('Has Errors');
            });
            var drDestroy = $('#input-file-to-destroy').dropify();
            drDestroy = drDestroy.data('dropify')
            $('#toggleDropify').on('click', function (e) {
                e.preventDefault();
                if (drDestroy.isDropified()) {
                    drDestroy.destroy();
                }
                else {
                    drDestroy.init();
                }
            });
            ");

?>

<div class="col-md-12">
    <div class="white-box">

        <div class="row">
            <div class="col-md-6 col-xs-12">
                <?
                print  $this->render('_theme', compact(['theme']));
                ?>

                <? $form = ActiveForm::begin(['id' => 'account-enter2aa', 'options' => ['class' => 'form form-horizontal']]); ?>

                <br><br>

                <div class="form-group">
                    <?= Html::activeLabel($model, 'body', ['class' => 'col-md-3 control-label']); ?>
                    <div class="col-md-9">
                        <?= $form->field($model, 'body')->textarea(['class' => "form-control"])->label(false); ?>
                    </div>
                </div>


                <div class="form-group">
                    <?= Html::activeLabel($model, 'file', ['class' => 'col-md-3 control-label']); ?>
                    <div class="col-md-9">
                        <?= $form->field($model, 'file')->fileInput(['class' => "dropify", 'data-height' => "100"])->label(false); ?>
                    </div>
                </div>
                <div class="form-group">

                    <div style="float:right">
                        <?= Html::submitButton('Отправить', ['class' => 'btn btn-info waves-effect waves-light  m-r-10', 'name' => 'login-button']) ?>
                    </div>


                </div>

                <?php ActiveForm::end(); ?>
            </div>

        </div>

    </div>

</div>
