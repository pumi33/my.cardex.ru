<?php

use yii\helpers\Html;
use  my\helpers\Help;
use yii\bootstrap\ActiveForm;
use yii\helpers\Json;
use kartik\select2\Select2;


$this->title = 'Служба поддержки';

$this->params['breadcrumbs'][] = $this->title;

$this->registerCssFile("/plugins/bower_components/dropify/dist/css/dropify.min.css");
$this->registerJsFile('/plugins/bower_components/dropify/dist/js/dropify.min.js');
$this->registerCssFile("/css/multi-select.css");
$this->registerJsFile('/js/jquery.multi-select.js');
$this->registerJsFile('/js/jquery.quicksearch.js');
$this->registerJsFile('/js/mselect.js');


$this->registerCss("
.dop{
display: none;
}
.d1{
display: block;
}

");


if ($_GET['limite'] == 1) {
    $this->registerCss("
.d4{
display: block;
}

");
}


$this->registerJs("

 $(document).ready(function () {
            // Basic
         
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
            
            
            
         $( \"#feedback-subject\" ).change(function() {
              
              val=$( this ).val();
              classOpen='.d'+val;
              classOpenReq=classOpen+' .req';
            
              
              $( \".dop\").hide();
                 $(classOpen).show();
              
              $('.dop .req').removeAttr('required');
              $(classOpenReq).attr(\"required\", true);
              
              
        });
 
               var countss=1;          
                 
        
       
                    
      
                    
                    
              function form_card(){
             
                     var cards='<div class=\"form-group hhh\"> <div class=\"col-md-12\">           <div style=\"float:right\">  <span class=\"circle circle-sm bg-purple di\" >'+countss+'</span></div>         </div>   </div>           <div class=\"form-group\">'+
                          '  <div class=\"col-md-3 control-label\">'+
                              '  <b> Карта</b>'+
                         '   </div>'+
                          '  <div class=\"col-md-9\">'+
                          '    <select name=\"card_add[][type]\" class=\"form-control\" >'+
'<option value=\"cardex\">Кардекс</option>'+
'<option value=\"lukoil\">Лукойл</option>'+
'</select>       '+
                          '  </div>'+
                      '  </div>'+
                       '<div class=\"form-group\">'+
                          '  <div class=\"col-md-3 control-label\">'+
                              '  <b> Держатель</b>'+
                         '   </div>'+
                          '  <div class=\"col-md-9\">'+
                          '      '+
                          '      <input type=\"text\" name=\"card_add[][own]\" class=\"form-control add_own addin\">                            </div></div>'+
                      '<div class=\"form-group\">'+
                      '<div class=\"col-md-3 control-label\"><b> Виды топлива</b></div> <div class=\"col-md-9\">'+
                      '<label><input type=\"checkbox\" name=\"card_add[][type_limite][]\" value=\"1\"  class=\"add_vid addin\" > Мойка</label> '+
                      '<br><label><input type=\"checkbox\" name=\"card_add[][type_limite][]\" value=\"2\"  class=\"add_vid addin\" > АИ-92</label> '+
                       '<br><label><input type=\"checkbox\" name=\"card_add[][type_limite][]\" value=\"3\"  class=\"add_vid addin\" > АИ-92 (Премиум)</label> '+
                      ' <br><label><input type=\"checkbox\"  class=\"add_vid addin\" name=\"card_add[][type_limite][]\" value=\"4\"> АИ-95</label>  <br>'+
                       ' <label><input type=\"checkbox\"  class=\"add_vid addin\" name=\"card_add[][type_limite][]\" value=\"5\"> АИ-95 (Премиум)</label>  <br>'+
                       '<label><input type=\"checkbox\"   class=\"add_vid addin\" name=\"card_add[][type_limite][]\" value=\"6\"> АИ-98</label>  <br>'+
                        '<label><input type=\"checkbox\"   class=\"add_vid addin\" name=\"card_add[][type_limite][]\" value=\"7\"> АИ-98 (Премиум)</label>  <br>'+
                       '<label><input type=\"checkbox\"   class=\"add_vid addin\" name=\"card_add[][type_limite][]\" value=\"8\"> Газ</label>  <br>'+
                       '<label><input type=\"checkbox\"  class=\"add_vid addin\" name=\"card_add[][type_limite][]\" value=\"9\"> ДТ</label></div>'+
                      '</div>'+
                      '  <div class=\"form-group\">'+
                       '     <div class=\"col-md-3 control-label\">'+
                       '         <b> Лимиты</b>'+
                      '      </div>'+
                        '    <div class=\"col-md-8\">'+
                         '       '+
                         '     <table> <tr> <td><input type=\"number\" name=\"card_add[][limit]\" class=\"form-control max100 add_lim addin\"></td> <td>   &nbsp; литров &nbsp; </td><td>   <select name=\"card_add[][limit_type]\" class=\"form-control max100\">'+
'<option value=\"AE7639D7ABFCBE2941F43B231470DFB7\">в cутки</option>'+
'<option value=\"B59C5483BD232D80411AE968DEA15A69\">в неделю</option>'+
'<option value=\"BE03FD8CB709B60B40E39AFE3E418518\" >в месяц</option>'+
'</select>           </td>             </tr>   </table>'+
  '</div><div class=\"col-md-1\"><br><div style=\"float:right\"><!--<a class=\"label label-danger\" href=\"javascript:add_minus();  return false;\" id=\"add_minus\"  data-method=\"post\"><i class=\"ti-minus\" ></i></a>--></div></div>'+
 ' </div>'+
                '        </div>'+
                '<div class=\"form-group formlast\">'+
                 '<div class=\"col-md-3\"></div>'+
                '<div class=\"col-md-9\"><hr></div>'+
                '</div>'+
                 '</div>';
                
                ;   
                    
                    return cards;
                
              }
              
              
              
         
              $( \"#add_card\" ).click(function() {
              
                val=$( \".add_lim\" ).last().val();
               /*
              $( \".hhh\" ).hide();
              
             
           
               $(\".add_own\").closest('.form-group').addClass('has-error');
              */
              
              
              if($( \".add_lim\" ).last().val()=='' || $( \".add_lim\" ).last().val()<0 ){
                  $(\".add_error\").show();
                  $(\".add-error\").html('Необходимо заполнить поле Лимит');
                  $(\".add_lim\").closest('.form-group').addClass('has-error');
             toastr.error('Необходимо заполнить поле Лимит', 'Внимание!', {timeOut: 7000})
                return false;
              } 
              

                    if ($('.add_vid').is(':checked')) {
                    alert(1);
                    }else{
                 $(\".add_error\").show();
                $(\".add_vid\").closest('.form-group').addClass('has-error');
              
                toastr.error('Необходимо выбрать хотя-бы один вид топлива', 'Внимание!', {timeOut: 7000})
                   return false;
                    }
               
   
            
              countss=countss+1
              /*
              $( \".before_cards\" ).before(form_card());
              */
        });
        
        
        $( \".addin\" ).change(function() {
         $(\".add_error\").hide();
          $(\".addin\").closest('.form-group').removeClass('has-error');
     });
        
        
        
               
         
    
    
    });
        
        
 ");
?>


<div class="col-sm-12">
    <div class="white-box">


        <br>

        <div class="row">
            <div class="col-sm-6 col-xs-12">
                <? $form = ActiveForm::begin(['id' => 'account-enter', 'options' => ['class' => 'form form-horizontal', 'enctype' => 'multipart/form-data']]); ?>


                <div class="form-group">
                    <?= Html::activeLabel($model, 'subject', ['class' => 'col-md-3 control-label']); ?>
                    <div class="col-md-9">
                        <? //= $form->field($model, 'subject')->input(['class' => "form-control"])->label(false); ?>
                        <?= $form->field($model, 'subject')->dropdownList(
                            \Yii::$app->params['feedbackList'], ['prompt' => 'Выберите тему']
                        )->label(false);
                        ?>
                    </div>
                </div>


                <!--  Дозаказ карт -->
                <div class="dop d1">

                    <div class="form-group" id="d1">

                        <!--
                        <table class="table">
                            <tr>
                                <th>Государственный регистрационный знак ТС, ФИО Держателя карты</th>
                                <th>Вид топлива/услуги</th>
                                <th>Лимит литров в сутки
                                    (топливо)
                                </th>
                                <th>Лимит литров в сутки
                                    (мойки)
                                </th>
                                <th>Тип топливной карты</th>
                            </tr>
                            <tr>
                        </table>
-->


                        <div class="form-group">
                            <?= Html::activeLabel($model_addcard, 'own', ['class' => 'col-md-3 control-label']); ?>
                            <div class="col-md-9">
                                <?= $form->field($model_addcard, 'own')->textInput(['class' => "form-control"])->label(false); ?>
                            </div>
                        </div>


                        <div class="form-group">
                            <div class="col-md-3 control-label">
                            </div>
                            <div class="col-md-6 ">
                                <?= Html::submitButton('<i
                                            class="ti-plus m-r-5"></i>Добавить карт', ['class' => 'btn btn-rounded btn-success waves-effect waves-light  m-r-10', 'name' => 'login-button']); ?>
                            </div>
                        </div>


                        <!--
                        <div class="form-group">
                            <div class="col-md-3 control-label">
                                <b>Держатель</b>
                            </div>
                            <div class="col-md-9">
                                <?= Html::textInput('own', null, ['autofocus' => true, 'placeholder' => 'Государственный регистрационный знак ТС, ФИО Держателя карты', 'class' => 'form-control add_own addin']); ?>
                            </div>



                        </div>

                        <div class="form-group">
                            <div class="col-md-3 control-label">
                                <b>Вид топлива/услуги</b>
                            </div>
                            <div class="col-md-9">

                                <?
                        echo Select2::widget([
                            'name'    => 'add_card[type_limite][]',
                            'value'   => '',
                            'data'    => \Yii::$app->params['oil'],
                            'options' => ['multiple' => true, 'placeholder' => 'Выберите из списка...'],
                        ]);

                        ?>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-3 control-label">
                                <b>Лимит (топлива)</b>
                            </div>
                            <div class="col-md-9">

                                <table>
                                    <tr><td>
                                            <?= Html::input('number', 'number', null, ['class' => 'form-control add_own addin max100']) . "</td>   <td> &nbsp;  литров  &nbsp; </td>   <td> " . Html::dropDownList('cat', null, \Yii::$app->params['typeLimite2'], ['class' => 'form-control add_own addin max100']); ?>
                                        </td> </tr>
                                </table>

                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-3 control-label">
                                <b>Лимит (мойка)</b>
                            </div>
                            <div class="col-md-9">

                                <table>
                                    <tr><td>
                                            <?= Html::input('number', 'number', null, ['class' => 'form-control add_own addin max100']) . "</td>   <td> &nbsp;  рублей  &nbsp; </td>   <td> " . Html::dropDownList('cat', null, \Yii::$app->params['typeLimite2'], ['class' => 'form-control add_own addin max100']); ?>
                                        </td> </tr>
                                </table>

                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-3 control-label">
                                <b>Тип топливной карты</b>
                            </div>
                            <div class="col-md-9">
                                <?= Html::dropDownList('cat', null, ['КАРДЕКС', 'ЛУКОЙЛ'], ['class' => 'form-control add_own addin ']) ?>

                            </div>
                        </div>
-->

                    </div>


                </div>


                <div class="dop d2">
                    <div class="form-group">
                        <div class="col-md-3 control-label">
                            <b> Выберите карты для блокировки</b>
                        </div>
                        <div class="col-md-6">
                            <select class='pre-selected-options-block' multiple='multiple' name="card_block[]">

                                <?
                                if ($card) {
                                    foreach ($card as $car) {


                                        //    if ($car['status'] === 'B0750601E13D90F3485BCD7EAB90AA21') {
                                        //         $selected = " selected ";
                                        //    } else {
                                        //         $selected = " ";
                                        //    }

                                        if ($car['status'] == '81D78BAB7F30C39A427AC024BC45119F') {
                                            print ' <option ' . $selected . ' value=\'' . $car['code'] . '\'>' . $car['code'] . ' (' . $car['owner'] . ')</option>';
                                        }

                                    }
                                }
                                ?>
                            </select>

                        </div>
                    </div>
                </div>


                <div class="dop d3">
                    <div class="form-group">
                        <div class="col-md-3 control-label">
                            <b> Выберите карты для разблокировки</b>
                        </div>
                        <div class="col-md-6">
                            <select class='pre-selected-options-unblock' multiple='multiple' name="card_block[]">

                                <?
                                if ($card) {
                                    foreach ($card as $car) {


                                        if ($car['status'] == 'B0750601E13D90F3485BCD7EAB90AA21' or $car['status'] == '877F5E4C39BDAFFE4860691C5AE5C1BA') {

                                            print ' <option ' . $selected . ' value=\'' . $car['code'] . '\'>' . $car['code'] . ' (' . $car['owner'] . ')</option>';
                                        }
                                    }
                                }
                                ?>
                            </select>

                        </div>
                    </div>
                </div>


                <div class="dop d4">


                    <div class="form-group">
                        <div class="col-md-3 control-label">
                            <b> Лимиты</b>
                        </div>
                        <div class="col-md-6">
                            <select class='pre-selected-options2' multiple='multiple' name="card_block2[]">

                                <?


                                if ($card) {
                                    foreach ($card as $car) {


                                        $pos = strrpos($cards, $car['code']);
                                        if ($pos === false) {
                                            $selected = "  ";
                                        } else {
                                            $selected = "  selected";
                                        }

                                        print ' <option  ' . $selected . ' value=\'' . $car['code'] . '\'>' . $car['code'] . ' (' . $car['owner'] . ')</option>';

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


                            <script>
                              //   var card_limite=<?=Json::encode($lim);?>;
                              //  var card_fuel=<?=Json::encode($fuel);?>;
                              // var card_type=<?=Json::encode($type);?>;

                              //oils = <?=Json::encode(\Yii::$app->params['oil']);?>;
                              //  types = ['в сутки','в неделю','в месяц'];

                            </script>


                            <table width="160%" class="addtable">

                                <?
                                if ($cards) {
                                    $arr_card = explode("|", $cards);


                                    if (is_array($arr_card)) {
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


                                                $checkbox = Help::fuelCheckbox($fuel[$cc], $param);


                                                print " <tr><td>Виды топлива</td><td>" . $checkbox . $text . " </td></tr>";

                                                print " <tr><td>Лимит</td><td>" . Html::input('number', 'number', $lim[$cc]) . "    литров    " . Html::dropDownList('cat', $type_code[$cc], \Yii::$app->params['typeLimite2'], $param) . "        </td>    </tr>";

                                            }
                                        }
                                    }
                                }
                                ?>
                            </table>


                            <?php
                            //  print Json::encode($lim);
                            //  print implode($lim,',');
                            //print_r($card);
                            ?>
                            <div class="mylimite"></div>

                        </div>
                    </div>
                </div>


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
