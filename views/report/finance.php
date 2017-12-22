<?php

use yii\helpers\Html;
use  my\helpers\Help;

$this->title = 'Бухгалтерская отчетность ';
$this->params['breadcrumbs'][] = ['label' => 'Отчетность'];
$this->params['breadcrumbs'][] = $this->title;




?>


<div class="col-sm-12">
    <div class="white-box">

        <div class="row">
            <div class="col-md-8 col-sm-10 p-20">

        <?=Help::ul(Help::$financePeriod,$finance_period,'finance_period','Статус карты')?>

        <br> <br>


        <div class="panel-group " id="accordion">
            <div class="panel panel-default list-group">


                <?

                $n = 1;
                foreach ($data as $i => $dat) {
                    //if (isset($dat['balance']) or $n == 1) {
                        if (!isset($in)) {
                            $in = " in ";
                            $collapsed = " ";
                        } else {
                            $in = " ";
                            $collapsed = " collapsed ";
                        }
                        print     $this->render('_list', [
                            'data' => $dat, 'in' => $in, 'i' => $i, 'collapsed' => $collapsed, 'edo' => $edo
                        ]);
                   // }
                    $n++;


                }
                ?>



            </div>
        </div>


            </div>
        </div>

    </div>
</div>
