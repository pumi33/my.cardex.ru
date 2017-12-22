<?php

use yii\helpers\Html;
use  my\helpers\Help;

use yii\bootstrap\ActiveForm;





?>
<?php $form = ActiveForm::begin(['id' => 'account-enter', 'options' => ['class' => 'form-default']]); ?>
                        <table class="table card-table">
                            <tbody>
                            <tr>
                                <td>
                                    Карта:
                                </td>
                                <td>
                                    <span class="navbar-title2"> <?= (mb_strlen($data[0]['code'])=='10')?'Кардекс':'Лукойл' ?></span>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    Статус:
                                </td>
                                <td>
                                    <span class="navbar-title2"> <?=Help::getStatusCard($data[0]['status'])?></span>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    Лимит:
                                </td>
                                <td>
                                    <span class="navbar-title2">  <?= $data[0]['limite']; ?></span> литров
                                    <?=\Yii::$app->params['typeLimite2'][$data[0]['typeLimite']]?>
                                    .
                                </td>
                            </tr>


                            <tr>
                                <td>
                                    Дата выдачи:
                                </td>
                                <td>
                                    <span class="navbar-title2"> <?= Help::normalDate($data[0]['dataDelivery']) ?></span>
                                </td>
                            </tr>

                            <tr>
                                <td>
                                    Вид топлива:
                                </td>
                                <td>
                                    <span class="navbar-title2">  <?= $data[0]['fuelView']; ?></span>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    Держатель:
                                </td>
                                <td>
                                    <span class="navbar-title2">  <?= $data[0]['owner']; ?></span>
                                </td>
                            </tr>

                            </tbody>
                        </table>


<a href="/report/transaction/?card=<?=$data[0]['code']?>" class="btn btn-info">Отчет по карте</a>


<?php ActiveForm::end(); ?>
