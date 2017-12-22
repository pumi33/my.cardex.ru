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


?>

<div class="col-md-12">
    <div class="white-box">

        <div class="row">
            <div class="col-md-6 col-xs-12">


                <?
                print  $this->render('_theme', compact(['theme']));
                ?>

                <? $form = ActiveForm::begin(['id' => 'account-enter2aa', 'options' => ['class' => 'form form-horizontal']]); ?>

                <br> <br>





                <?= $form->field($model, 'own')->textInput(['placeholder' => 'Государственный регистрационный знак ТС, ФИО Держателя карты']); ?>


                <?= $form->field($model, 'fuel_type')->widget(Select2::classname(), [
                    'data' => \Yii::$app->params['oil'],
                    'language' => 'ru',
                    'options' => ['placeholder' => 'Выберите из списка... (для выбора нескольких значение  зажмите CTRL)'],
                    'pluginOptions' => [
                        'allowClear' => false,
                        'multiple' => true,
                    ],
                ]); ?>

                <?
                echo $form->field($model, 'card_type')->dropdownList(
                    \Yii::$app->params['card_type'],['prompt' => 'Выберите карту']
                );
                ?>


                <table width="58%">
                    <tr>
                        <td>
                          <b style="color: #333">  <div style="margin-bottom: 30px;"> Лимит топлива (литры)</div></b>
                        </td>

                        <td>
                            <?= $form->field($model, 'limite_fuel_value')->Input('number', ['class' => 'form-control add_own addin max100'])->label(false); ?>

                        </td>
                        <td>

                            <?php


                            echo $form->field($model, 'limite_fuel_type')->dropdownList(
                                \Yii::$app->params['typeLimite2'], ['class' => 'form-control add_own addin max100']
                            )->label(false);
                            ?>

                        </td>

                    </tr>

                </table>


                <!--
                  <a href="?theme=1&" class="btn btn-rounded btn-success waves-effect waves-light  m-r-10"><i
                              class="ti-plus m-r-5"></i> Добавить карту</a>
                -->
                <?= Html::submitButton('<i class="ti-plus m-r-5"></i>Добавить карту', ['class' => 'btn btn-rounded btn-info waves-effect waves-light  m-r-10', 'name' => 'addcard']) ?>
                <div align="right">
                    <br>
                    <? if (!empty($save_card)) { ?>


                        <?php



                        print  $this->render('addcard_table', compact(['save_card']));

                        print "<div align=right>";
                        print Html::a('Отправить заявку на выпуск карт','?theme=1&submit=1', ['class' => 'btn btn-rounded btn-success waves-effect waves-light  m-r-10', 'name' => 'submit']);
                        print "</div>";
                }



                ?>

                </div>



            </div>


            <?php ActiveForm::end(); ?>


        </div>


    </div>
</div>
