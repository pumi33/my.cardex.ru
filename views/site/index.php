<?php

use yii\helpers\Html;
use  my\helpers\Help;
use my\models\User;
use yii\helpers\Json;

$this->title = 'Личный кабинет';

//$this->params['breadcrumbs'][] = '';

?>



<?


if ($dogovor->toplivo != "" and count(Json::decode($dogovor->toplivo)) > 1) {

    $forChart = [];
    foreach (Json::decode($dogovor->toplivo) as $array) {
        $forChart['date'][]  = \Yii::$app->params['ruMonth'][$array['pMonth']] . " " . $array['pYear'];
        $forChart['kolvo'][] = round($array['kolvo']);
        $current             = round($array['kolvo']);
    }


    $this->registerJs("        
        $(document).ready(function () {
        if ($('.ct-chart-sale2').length) {
   
            new Chartist.Line('.ct-chart-sale', {
                labels: " . Json::encode($forChart['date']) . ",
                series: [" . Json::encode($forChart['kolvo']) . "]
            }, {
                axisX: {
                    position: 'center',
                    showLabel: true,
                    
                  
                },
                axisY: {
                  labelInterpolationFnc: function labelInterpolationFnc(value) {
                        return value + '';
                    },
                    showLabel: true,
                    
                },
                chartPadding: {
                    top: 20,
                    right: 80,
                    bottom: 0,
                    left: 30
                },
                height: 250,
                // high: 120000,
                showArea: true,
                stackBars: true,
                fullWidth: true,
                lineSmooth: true,
                plugins: [Chartist.plugins.ctPointLabels({
                    textAnchor: 'middle',
                    labelInterpolationFnc: function labelInterpolationFnc(value) {
                        return parseInt(value) + ' л.';
                    }
                })]
            }, [['screen and (max-width: 768px)', {
                axisX: {
                    offset: 0,
                    showLabel: true
                },
                height: 180
            }]]);
        }
    });


       ");


    $this->registerCss(" 
    .ccc td {
    font-size:14px;
    }
     
    
       
       ");


}

?>

<!--
<div class="row">

    <div class="col-md-12 col-lg-3">
        <div class="white-box">
            <h3 class="box-title">Баланс</h3>
            <ul class="list-inline m-t-30 p-t-10 two-part">
                <i class="material-icons text-success" style="font-size: 50px;">account_balance_wallet</i>




                <li class="text-right"><span class="counter"><nobr><?= \number_format(\Yii::$app->session['balance'], 2, ',', ' '); ?>
                            руб.</nobr></span>


                    <br>


                </li>

            </ul>

            <table class="ccc" width="100%" border="0">
                <tr>
                    <td align="left">
                        <nobr>Текущий остаток :</nobr>
                    </td>
                    <td>
                        <nobr><span class="navbar-title2" style="font-size: 18.2px!important; color: #000;">
                           158 015,26 руб</span></nobr>
                    </td>
                </tr>
                <tr>
                    <td align="left">Неснижаемый остаток:</td>
                    <td>
                        <nobr><span class="navbar-title2" style="font-size: 18.2px!important; color: #000;"> 58 912,00 руб.</span>
                        </nobr>
                    </td>
                </tr>
            </table>


        </div>
    </div>
    <div class="col-md-12 col-lg-3">
        <div class="white-box">
            <h3 class="box-title">Расход в месяце (Литров)</h3>
            <ul class="list-inline m-t-30 p-t-10 two-part">
                <i class="material-icons" style="font-size: 50px;">local_gas_station</i>
                <li class="text-right"><span class="counter">

                        <nobr><?= \number_format(Help::getToplivo(1, 'kolvo'), 2, ',', ' '); ?> л.

                        </nobr></span>


                    <button class="btn btn-outline btn-default btn-xs">Подробнее</button>

                </li>
            </ul>
        </div>
    </div>
    <div class="col-md-12 col-lg-3">
        <div class="white-box">
            <h3 class="box-title">Количество карт</h3>
            <ul class="list-inline m-t-30 p-t-10 two-part">
                <li><i class="material-icons text-info" style="font-size: 50px;">credit_card</i></li>
                <li class="text-right" style="margin-top: -40px!important;">

                    <span class="counter"><nobr>

                          <?= HELP::getCountCards() ?>

                        </nobr></span>

                    <br>


                    <table class="ccc">
                        <tr>
                            <td align="left"> Активных:</td>
                            <td><span class="badge badge-success"> <?= HELP::getCountCards('active') ?></span></td>
                        </tr>
                        <tr>
                            <td a>Заблокированных:</td>
                            <td><span class="badge badge-danger">  <?= HELP::getCountCards('block') ?> </span></td>
                        </tr>
                    </table>


                </li>


            </ul>
        </div>
    </div>
    <div class="col-md-12 col-lg-3">
        <div class="white-box">
            <h3 class="box-title">Пользователи</h3>
            <ul class="list-inline m-t-30 p-t-10 two-part">
                <li><i class="material-icons text-info" style="font-size: 50px;">group</i></li>

                <li class="text-right"><span class="counter"><nobr><?= count(User::getActiveUser()); ?></nobr></span>
                </li>
            </ul>
        </div>
    </div>
</div>
-->

<div class="row">
    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
        <div class="panel panel-default">
            <div class="panel-heading">Баланс</div>
            <div class="panel-wrapper collapse in">
                <div class="panel-body">


                    <!--
                    <ul class="list-inline two-part">
                        <i class="material-icons text-success" style="font-size: 50px;">account_balance_wallet</i>
                        <li class="text-right"><span class="counter" ><nobr><?= \number_format(\Yii::$app->session['balance'] - \Yii::$app->session['n_ostatok'], 2, ',', ' '); ?>
                                    руб</nobr></span>
                            <br>
                        </li>
                    </ul>
-->

                    <div class="row">
                        <div class="col-md-3"><i class="material-icons text-success" style="font-size: 50px;">account_balance_wallet</i></div>
                        <div class="col-md-9"><span class="counter"><nobr><?= \number_format(\Yii::$app->session['balance'] - \Yii::$app->session['n_ostatok'], 2, ',', ' '); ?> руб</nobr></span></div>
                    </div>


                    <!--
                    <table class="ccc" width="100%" border="0">
                        <tr>
                            <td align="left">
                                <i class="material-icons text-success" style="font-size: 50px;">account_balance_wallet</i>
                            </td><td>
              <span class="counter" ><nobr><?= \number_format(\Yii::$app->session['balance'] - \Yii::$app->session['n_ostatok'], 2, ',', ' '); ?>
        руб</nobr></span>
                            </td>
                        </tr>
                    </table>
-->

                </div>
            </div>
            <div class="panel-footer">


                <table class="ccc" width="100%" border="0">
                    <tr>
                        <td align="left">
                            <nobr>Текущий остаток :</nobr>
                        </td>
                        <td align="right">
                            <nobr><span class="navbar-title2" style="font-size: 18.2px!important; color: #000;">
                           <?= \number_format(\Yii::$app->session['balance'], 2, ',', ' '); ?> руб  </span></nobr>
                        </td>
                    </tr>
                    <tr>
                        <td align="left">Неснижаемый остаток:</td>
                        <td align="right">
                            <nobr><span class="navbar-title2" style="font-size: 18.2px!important; color: #000;"> <?= \number_format(\Yii::$app->session['n_ostatok'], 2, ',', ' '); ?> руб   </span>
                            </nobr>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </div>


    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
        <div class="panel panel-default">
            <div class="panel-heading">Расход в текущем месяце</div>
            <div class="panel-wrapper collapse in">
                <div class="panel-body">

                    <!--
                    <ul class="list-inline two-part">
                        <i class="material-icons" style="font-size: 50px;">local_gas_station</i>
                        <li class="text-right">
                            <span class="counter"><nobr><?= \number_format(Help::getToplivo(1, 'kolvo'), 2, ',', ' '); ?> л.</nobr></span>
                        </li>
                    </ul>
-->

                    <div class="row">
                        <div class="col-md-3"><i class="material-icons" style="font-size: 50px;">local_gas_station</i></div>
                        <div class="col-md-9"><span class="counter"><nobr><?= \number_format(Help::getToplivo(1, 'kolvo'), 2, ',', ' '); ?> л</nobr></span></div>
                    </div>


                </div>
            </div>
            <div class="panel-footer">
                <br>
                <a href="https://my.card-oil.ru/report/analytics/" class="btn btn-outline btn-default btn">Подробнее</a>

            </div>
        </div>
    </div>

    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
        <div class="panel panel-default">
            <div class="panel-heading">Количество карт</div>
            <div class="panel-wrapper collapse in">
                <div class="panel-body">

                    <!--
                    <ul class="list-inline two-part">
                        <li><i class="material-icons text-warning" style="font-size: 50px; " >credit_card</i></li>
                        <li class="text-right" style="margin-top: -140px!important;">

                    <span class="counter"><nobr>

                          <?= HELP::getCountCards() ?>

                        </nobr></span>

                            <br>
                        </li>
                    </ul>
-->


                    <div class="row">
                        <div class="col-md-3"><i class="material-icons text-warning" style="font-size: 50px;">credit_card</i></div>
                        <div class="col-md-9"><span class="counter"><nobr><?= HELP::getCountCards() ?></nobr></span></div>
                    </div>


                </div>
            </div>
            <div class="panel-footer">


                <table class="ccc" width="100%">
                    <?
                    if (HELP::getCountCards('block') > 0) {
                        ?>
                        <tr>
                            <td align="left"><span class="label label-rouded label-danger">Заблокированных:</span></td>
                            <td align="center"><span class="navbar-title2" style="font-size: 18.2px!important; color: #000;"> <?= HELP::getCountCards('block') ?></span></td>
                        </tr>
                    <? } else {
                        ?>
                        <tr>
                            <td align="left"><span class="label label-rouded label-success">Активных:</span></td>
                            <td align="center"><span class="navbar-title2" style="font-size: 18.2px!important; color: #000;"> <?= HELP::getCountCards('active') ?></span></td>
                        </tr>


                    <? } ?>


                    <tr>
                        <td><span class="label label-rouded label-danger">Стоп лист:</span></td>
                        <td align="center"><span class="navbar-title2" style="font-size: 18.2px!important; color: #000;">  <?= HELP::getCountCards('blockAll') ?> </span></td>
                    </tr>
                </table>

            </div>
        </div>
    </div>


    <!--
    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
        <div class="panel panel-default">
            <div class="panel-heading">Контактные лица</div>
            <div class="panel-wrapper collapse in">
                <div class="panel-body">


                    <ul class="list-inline two-part">
                        <li><i class="material-icons text-purple" style="font-size: 50px;">group</i></li>

                        <li class="text-right"><span class="counter"><nobr><?= count(User::getActiveUser()); ?></nobr></span>
                        </li>
                    </ul>

                </div>
            </div>
            <div class="panel-footer">


                <table class="ccc" width="100%">
                    <tr>
                        <td align="left"> <span class="label label-rouded label-info">Пользователей:</span></td>
                        <td align="center"><span class="navbar-title2" style="font-size: 18.2px!important; color: #000;"> 3</span></td>
                    </tr>
                    <tr>
                        <td > <span class="label label-rouded label-warning">Администраторов:</span></td>
                        <td align="center"><span class="navbar-title2" style="font-size: 18.2px!important; color: #000;">  1 </span></td>
                    </tr>
                </table>

            </div>
        </div>
    </div>
-->


    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
        <div class="panel panel-default">
            <div class="panel-heading">Отчеты и документы</div>
            <div class="panel-wrapper collapse in">
                <div class="panel-body">


                    <table class="table table2" cellpadding="0" cellspacing="0">
                        <tbody>
                        <tr>
                            <td><i class="fa fa-file" aria-hidden="true"></i>
                                <a href="/report/transaction/"> Транзакционный отчет </a>
                            </td>

                        </tr>
                        <tr>
                            <td><i class="fa fa-file" aria-hidden="true"></i>
                                <a href="/report/prepaid/">Выставить счет</a>
                            </td>

                        </tr>
                        <tr>
                            <td><i class="fa fa-file" aria-hidden="true"></i>
                                <a href="/report/finance/"> Бухгалтерская отчетность</a>
                            </td>

                        </tr>


                        </tbody>
                    </table>


                </div>
            </div>

        </div>
    </div>


</div>


<?
if ($dogovor->toplivo != "" and count(Json::decode($dogovor->toplivo)) > 1) {
    ?>

    <div class="row">
        <div class="col-md-12 ">
            <div class="white-box">
                <div class="row">
                    <div class="col-xs-12">
                        <div class="card card-banner card-chart card-orange no-br">
                            <div class="card-header">
                                <div class="card-title">
                                    <div class="title">Расход топлива (Литры)</div>
                                </div>
                                <ul class="card-action">

                                </ul>
                            </div>
                            <div class="card-body ">
                                <div class="ct-chart-sale "></div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-xs-12">
                        <div class="ct-chart-sale2">

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

<? } ?>


<div class="row">

    <!--
    <div class="col-md-12 col-lg-6">
        <div class="white-box">
            <h3 class="box-title">Отчеты и документы</h3>
            <div class="card-body no-padding table-responsive">
                <table class="table card-table">
                    <tbody>
                    <tr>
                        <td><i class="fa fa-file" aria-hidden="true"></i>
                            <a href="/report/prepaid/">Запросить счет</a>
                        </td>

                    </tr>
                    <tr>
                        <td><i class="fa fa-file" aria-hidden="true"></i>
                            <a href="/report/finance/"> Бухгалтерская отчетность</a>
                        </td>

                    </tr>
                    <tr>
                        <td><i class="fa fa-file" aria-hidden="true"></i>
                            <a href="/report/transaction/"> Транзакционный отчет </a>
                        </td>

                    </tr>


                    </tbody>
                </table>
            </div>
        </div>
    </div>
    -->


    <!--
    <div class="col-md-12 col-lg-6">
        <div class="white-box">
            <h3 class="box-title">Файлы и инструкции</h3>
            <div class="card-body no-padding table-responsive">
                <table class="table card-table">
                    <tbody>

                    <tr>
                        <td><i class="fa fa-file" aria-hidden="true"></i>
                            Образцы заполнения платёжных поручений
                        </td>

                    </tr>
                    <tr>
                        <td><i class="fa fa-file" aria-hidden="true"></i>
                            Письмо об уточнении платежа
                        </td>

                    </tr>
                    <tr>
                        <td><i class="fa fa-file" aria-hidden="true"></i>
                            Документы необходимые для подписания дополнительного соглашения
                        </td>

                    </tr>
                    <tr>
                        <td><i class="fa fa-file" aria-hidden="true"></i>
                            Заявка на дополнительные карты
                        </td>

                    </tr>
                    <tr>
                        <td><i class="fa fa-file" aria-hidden="true"></i>
                            Инструкция по использованию топливной карты
                        </td>

                    </tr>

                    </tbody>
                </table>
            </div>
        </div>
    </div>
-->

</div>