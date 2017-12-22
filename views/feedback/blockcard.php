<?php
/**
 * Created by PhpStorm.
 * User: DevAdmin
 * Date: 23.06.2017
 * Time: 16:32
 */
$this->title = 'Блокировка карт';

use yii\bootstrap\ActiveForm;
use kartik\select2\Select2;
use yii\helpers\Html;


$this->registerCssFile("/css/multi-select.css");
$this->registerJsFile('/js/jquery.multi-select.js');
$this->registerJsFile('/js/jquery.quicksearch.js');
$this->registerJsFile('/js/mselect.js');

$this->registerJs("
$('#block-card-button').attr('disabled', 'disabled')
");

?>

<div class="col-md-12">
    <div class="white-box">

        <div class="row">
            <div class="col-md-6 col-xs-12">

                <?= $this->render('_theme', compact(['theme'])); ?>

                <br>


                <? $form = ActiveForm::begin(['id' => 'account-enter2aa', 'options' => ['class' => 'form form-horizontal']]); ?>


                <select class='pre-selected-options-block' multiple='multiple' name="card_block[]">
                    <?
                    if ($card) {

                        foreach ($card as $car) {

                            if ($car['status'] == '81D78BAB7F30C39A427AC024BC45119F') {
                                print ' <option value=\'' . $car['code'] . '\'>' . $car['code'] . ' (' . $car['owner'] . ')</option>';
                            }

                        }
                    }
                    ?>
                </select>

                <br><br>
                <div align="left">
                    <?= Html::submitButton('Отправить заявку на блокировку карт', ['class' => 'btn btn-info waves-effect waves-light', 'id' => 'block-card-button']) ?>
                </div>
            </div>


            <?php ActiveForm::end(); ?>


        </div>


    </div>
</div>
</div>