<?php
/**
 * Created by PhpStorm.
 * User: DevAdmin
 * Date: 23.06.2017
 * Time: 16:32
 */
$this->title = 'Изминение лимитов';

use yii\bootstrap\ActiveForm;
use kartik\select2\Select2;
use yii\helpers\Html;
use  my\helpers\Help;


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


                <select class='pre-selected-options2' multiple='multiple' name="card_block[]">
                    <?
                    if ($card) {

                        foreach ($card as $car) {

                            if ($car['status'] == '81D78BAB7F30C39A427AC024BC45119F') {
                                //   print ' <option value=\'' . $car['code'] . '\'>' . $car['code'] . ' (' . $car['owner'] . ')</option>';
                            }

                        }
                    }


                    if ($card) {
                        foreach ($card as $car) {


                            $pos = strrpos(\Yii::$app->request->get()['cards'], $car['code']);
                            if ($pos === false) {
                                $selected = "  ";
                            } else {
                                $selected = "  selected";
                            }
                            if ($car['status'] == '81D78BAB7F30C39A427AC024BC45119F') {
                                print ' <option  ' . $selected . ' value=\'' . $car['code'] . '\'>' . $car['code'] . ' (' . $car['owner'] . ')</option>';
                            }
                            $lim[$car['code']]       = $car['limite'];
                            $owner[$car['code']]     = $car['owner'];
                            $fuel[$car['code']]      = $car['fuelView'];
                            $type[$car['code']]      = \Yii::$app->params['typeLimite2'][$car['typeLimite']];
                            $type_code[$car['code']] = \Yii::$app->params['typeLimite2'][$car['typeLimite']];


                            // $fuel[]= $car['fuelView'];
                            // $lim[]= $car['typeLimite'];
                        }


                    }
                    ?>
                </select>

                <br><br>


                <?
                if (isset(\Yii::$app->request->get()['cards']) and !empty(\Yii::$app->request->get()['cards'])) {
                    $arr_card = explode("|", \Yii::$app->request->get()['cards']);

                    print "     <table width=\"160%\" class=\"addtable\">";

                    //                        print "<pre>";
                    //                      print_r($card);
                    //                    print "</pre>";

                    if (is_array($arr_card)) {

                        foreach ($card as $car) {
                            $lim[$car['code']]       = $car['limite'];
                            $owner[$car['code']]     = $car['owner'];
                            $fuel[$car['code']]      = $car['fuelView'];
                            $type[$car['code']]      = \Yii::$app->params['typeLimite2'][$car['typeLimite']];
                            $type_code[$car['code']] = \Yii::$app->params['typeLimite2'][$car['typeLimite']];
                        }


                        foreach ($arr_card as $cc) {

                            if ($cc != "") {
                                $cc = trim($cc);


                                print " <tr><td colspan='2'><hr></td></tr>";
                                print " <tr><td>Карта</td><td><span class=\"navbar-title2\">" . $cc . " (" . $owner[$cc] . ")</span></td></tr>";

                                if ((mb_strlen($cc) == '10')) {
                                    $text  = ' Для смены вида топлива и лимита необходимо приехать к нам в офис';
                                    $param = ['disabled' => 'disabled', 'readonly' => 'readonly'];

                                } else {
                                    $text  = "";
                                    $param = [];
                                }


                                $checkbox = Help::fuelCheckbox($fuel[$cc], $param, $cc);


                                print " <tr><td>Виды топлива</td><td>" . $checkbox . $text . " </td></tr>";

                                print " <tr><td>Лимит</td><td>" . Html::input('number', 'limite_value[' . $cc . ']', $lim[$cc]) . "    литров    " . Html::dropDownList('limite_type[' . $cc . ']', $type_code[$cc], \Yii::$app->params['typeLimite2'], $param) . "        </td>    </tr>";

                            }
                        }
                    }

                    ?>
                    <br><br>


                    <?
                    print " </table>";
                    ?>
                    <br> <br>

                    <div align="right">
                        <?= Html::submitButton('Отправить заявку на изменение лимитов', ['class' => 'btn btn-info waves-effect waves-light', 'id' => 'block-card-button2']) ?>
                    </div>

                <? } ?>


            </div>


            <?php ActiveForm::end(); ?>


        </div>


    </div>
</div>
</div>