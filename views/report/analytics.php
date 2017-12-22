<?php

use yii\helpers\Html;
use  my\helpers\Help;
use yii\helpers\Json;
use  my\models\Report;

$this->title = 'Аналитические отчеты ';
$this->params['breadcrumbs'][] = ['label' => 'Отчетность'];
$this->params['breadcrumbs'][] = $this->title;

$this->registerCssFile("/plugins/bower_components/chartist-js/dist/chartist.min.css");
$this->registerCssFile("/plugins/bower_components/chartist-js/dist/chartist-init.css");

$this->registerJsFile('https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.6.0/Chart.bundle.min.js');

$this->registerJsFile('/js//randomColor.js');


$this->registerCssFile("/css/multi-select.css");
$this->registerJsFile('/js/jquery.multi-select.js');
$this->registerJsFile('/js/jquery.quicksearch.js');


$this->registerJsFile('/js/mselect.js');





$colors=Help::getColor();
$colors_transp=Help::getColor(1);



if(!empty($data['groupbycard']['data']))
$groupbycard=Report::forChart($data['groupbycard'],true);
if(!empty($data['avg']['data']))
$avg=Report::forChart($data['avg'],false);


if(!empty($data['oil']['data']))
$oil=Report::forChart($data['oil'],false);




$this->registerCss("anvas {
                            -moz-user-select: none;
                            -webkit-user-select: none;
                            -ms-user-select: none;
                        }
                        
                        .ms-container{
                           width: 670px;
                       }

                        
                          ");




$this->registerJs("        
$(document).ready(function () {

var  myColor=randomColor({
count: 10,
luminosity: 'dark',
hue: 'random'

});


        
       var MONTHS = ".Json::encode(Help::getMonthForeach2()).";
       
       
                        var config = {
    
                            type: 'line',
                            data: {
                            
                                labels: MONTHS,
                                datasets: [
                                ".$groupbycard."
                                
                                ]
                            },
                            options: {
                         
                                responsive: true,
                                legend: {
                                //    position: 'bottom',
                                },
                                hover: {
                                    mode: 'index'
                                },
                                scales: {
                                    xAxes: [{
                                        display: true,
                                        scaleLabel: {
                                            display: true,
                                            labelString: 'Месяц'
                                        }
                                    }],
                                    yAxes: [{
                                        display: true,
                                        scaleLabel: {
                                            display: true,
                                            labelString: 'Объем'
                                        }
                                    }]
                                },
                                title: {
                                    display: false,
                                    text: 'Chart.js Line Chart - Different point sizes'
                                }
                            }
                        };

                            var ctx = document.getElementById(\"canvas\").getContext(\"2d\");
                            window.myLine = new Chart(ctx, config);
                    
                            
                            
                                     var config = {
                        
                           type: 'bar',
                            data: {
                            
                                labels: MONTHS,
                                datasets: [
                                ".$avg."
                                
                                ]
                            },
                            options: {
                         
                                responsive: true,
                                legend: {
                                //    position: 'bottom',
                                },
                                hover: {
                                    mode: 'index'
                                },
                                scales: {
                                    xAxes: [{
                                     stacked: false,
                                        display: true,
                                        scaleLabel: {
                                            display: true,
                                            labelString: 'Месяц'
                                        }
                                    }],
                                    yAxes: [{
                                     stacked: false,
                                        display: true,
                                        scaleLabel: {
                                            display: true,
                                            labelString: 'Цена'
                                        }
                                    }]
                                },
                                title: {
                                    display: false,
                                    text: 'Chart.js Line Chart - Different point sizes'
                                }
                            }
                        };

                            var ctx = document.getElementById(\"canvas2\").getContext(\"2d\");
                            window.myLine = new Chart(ctx, config);   
                            
                            
                            
                            
                            
                            
                      var config = {
                        
                           type: 'bar',
                            data: {
                            
                                labels: MONTHS,
                                datasets: [
                                ".$oil."
                                
                                ]
                            },
                            options: {
                         
                                responsive: true,
                                legend: {
                                //    position: 'bottom',
                                },
                                hover: {
                                    mode: 'index'
                                },
                                scales: {
                                    xAxes: [{
                                     stacked: false,
                                        display: true,
                                        scaleLabel: {
                                            display: true,
                                            labelString: 'Месяц'
                                        }
                                    }],
                                    yAxes: [{
                                     stacked: false,
                                        display: true,
                                        scaleLabel: {
                                            display: true,
                                            labelString: 'Объем'
                                        }
                                    }]
                                },
                                title: {
                                    display: false,
                                    text: 'Chart.js Line Chart - Different point sizes'
                                }
                            }
                        };

                            var ctx = document.getElementById(\"canvas3\").getContext(\"2d\");
                            window.myLine = new Chart(ctx, config);   
                            
               
                            
                       });


       ");


?>


<div class="col-sm-12">
    <div class="white-box">



        <div class="row">
            <div class="col-sm-4">

                <!--
                заменить на select2
                -->

                <select class='pre-selected-options-analytics' multiple='multiple' name="card_select[]">
                    <?php
                  //  $arr_card = explode("|", $cards);



                    foreach ($myCard as $card){
                        
                        $pos = strrpos($cards,$card['code']);
                        if ($pos === false) {
                            $selected = "  ";
                        } else {
                            $selected = "  selected";
                        }

                        print "<option name=\"".$card['code']."\"  $selected>".$card['code']." (".$card['owner'].")</option>\n";
                    }
                    ?>
                </select>
            </div>
        </div>



  <? if ($cards){ ?>
        <div class="row">
            <div class="col-sm-12">
                <div class="white-box">
                    <h3 class="box-title">Расход литров в месяц</h3>
                    <div>
                        <canvas id="canvas" ></canvas>
                    </div>
                </div>
            </div>

            <div class="col-sm-<?=(count($data['groupbycard']['owner'])<6)?6:12?>">
                <div class="white-box">
                    <h3 class="box-title">Средняя цена на заправки</h3>
                    <div >
                        <canvas id="canvas2"></canvas>
                    </div>
                </div>
            </div>

            <div class="col-sm-6">
                <div class="white-box">
                    <h3 class="box-title">Распределение по видам топлива</h3>
                    <div >
                        <canvas id="canvas3"></canvas>
                    </div>
                </div>
            </div>
        </div>

<? } ?>





    </div>
</div>