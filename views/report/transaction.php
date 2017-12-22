<?php

use yii\helpers\Html;
use  my\helpers\Help;

$this->title = 'Транзакционный отчет ';
$this->params['breadcrumbs'][] = ['label' => 'Отчетность'];
$this->params['breadcrumbs'][] = $this->title;



if(isset($_GET['card'])) {
    $ccard = (int)$_GET['card'];
}else{
    $ccard = '';
}


$this->registerJs("

     var now = new Date()
  
     
       var buttonCommon = {
        exportOptions: {
            format: {
                body: function ( data, row, column, node ) {
                    // Strip $ from salary column to make it numeric
                    data = $('<p>' + data + '</p>').text();
                    
                       if ( column === 0) {
                       
                       data='#'+data;
                       }
                    
                  return data;
                       
                }
            }
        }
    };
     
 
	
function gettime()
{
    var date = new Date();
    var newdate = date.getFullYear()+'-'+date.getMonth()+'-'+date.getDate();
    //setInterval(gettime, 1000);
    return newdate;
}



jQuery.fn.dataTable.Api.register( 'sum()', function ( ) {
	return this.flatten().reduce( function ( a, b ) {
		if ( typeof a === 'string' ) {
			a = a.replace(/[^\d.-]/g, '') * 1;
		}
		if ( typeof b === 'string' ) {
			b = b.replace(/[^\d.-]/g, '') * 1;
		}

		return a + b;
	}, 0 );
} );














     
        $('#dt').DataTable({
        stateSave: true,
          'order': [[ 1, 'desc' ]],
          
     drawCallback: function () {
      var api = this.api();
      $('.summ').html(
      'Итого: '+ Math.round(api.column( 9, {page:'all'} ).data().sum())
      );
      
        nn=  $('#temp_var').val();
     if(nn !=1){
     
              $('.dt-buttons').prepend('<a class=\"dt-button buttons-pdf buttons-html5 prepend\" target=\"_blank\" tabindex=\"0\"  aria-controls=\"dt\" href=\"/report/transaction-pdf/?month=".(int)$month."&year=".(int)$year."\" title=\"Оборот по обслуживанию (PDF)\"><span><i class=\"fa fa-file-pdf-o\"></i></span></a>');
       
       
          $('#temp_var').val(1);
          $('input[type=search]').val('".$ccard."');
          $('input[type=search]').keyup();
          $('input[type=search]').keypress();
          
      }
 
       
      
    },
  
        
        dom: '<\"lenght\"l> <\"but\" B> frt <\"summ\">  ip',
        'paging':   true,
        'ordering': true,
        'info':     true,
        
       
        
        buttons: [
           
             $.extend( true, {}, buttonCommon, {
                extend: 'excelHtml5',
                
                
         
                
                text:      '<i class=\"fa fa-file-excel-o\"></i>',
                titleAttr: 'Excel',
                  filename: '*_' + gettime(),
                           title: 'КАРДЕКС \\n'+'* ' +' \\n Компания:  ".\Yii::$app->session['company']." Договор: ".\Yii::$app->session['dogovor']."  ',
                        
                        
                   exportOptions: {
              //  columns: [0,1,2,3,4,5,6,7,8,9],
               
              
                
                format: {
                
                header:  function (data, columnIdx) {
                               //return columnIdx + ': ' + data + \"\"
                                    return  data + \"\"
                               },
                               
                               
                
                body: function ( data, row, column, node ) {
                    // Strip $ from salary column to make it numeric
          
                        if(column===3){
                        var DOM= $(\"<div>\" + data + \"</div>\");
                      data=  $('img', DOM).attr(\"title\")
      
                    
           
                        }else if(column===1){
                        
                         data = data.split(' ').join(\"\\n\\t\");
                          
                          
                           }else if ( column === 0) {
                        data = data.replace(/<.*?>/g, \"\");
                        
                       data='#'+data.trim();
                       
                          
                        }else{
                        
                            data = data.replace(/<.*?>/g, \"\");
                         
                        }
                         return data;
                        
                }
             }
            }
                        
                        
            } ),
            
           
            {
                extend:    'copyHtml5',
                text:      '<i class=\"fa fa-files-o\"></i>',
                titleAttr: 'Копировать',
                title: 'КАРДЕКС \\n'+'* ' +' \\n Компания:  ".\Yii::$app->session['company']." Договор: ".\Yii::$app->session['dogovor']."  ',
            },
            {
                extend:    'print',
                text:      '<i class=\"fa fa-print\"></i>',
                titleAttr: 'Печать',
                      title: '<h3>КАРДЕКС </h3><h5>\\n'+'* ' +' \\<br> Компания:  ".\Yii::$app->session['company']." <br>Договор: ".\Yii::$app->session['dogovor']."<br>Дата выгрузки: ".date('d.m.Y')." </h5>',
            },

          

        ],
        \"language\": {
            \"url\": \"/plugins/bower_components/datatables/russian.json\"
        }

    });
     
  
     
     
     
    
     
     
     "
);


/*
 *  {
                extend: 'pdfHtml5',
                orientation: 'landscape',
                pageSize: 'LEGAL',
                text:      '<i class=\"fa fa-file-pdf-o\"></i>',
                titleAttr: 'PDF',
                filename: '*_' + gettime(),

                     title: 'КАРДЕКС \\n'+'* ' +' \\n Компания:  ".\Yii::$app->session['company']." Договор: ".\Yii::$app->session['dogovor']."  ',



                exportOptions: {
              //  columns: [0,1,2,3,4,5,6,7,8,9],



                format: {
                body: function ( data, row, column, node ) {
                    // Strip $ from salary column to make it numeric

                        if(column===3){
                        var DOM= $(\"<div>\" + data + \"</div>\");
                      data=  $('img', DOM).attr(\"title\")



                        }else if(column===1){

                         data = data.split(' ').join(\"\\n\\t\");

                        }else{

                   data = data.replace(/<.*?>/g, \"\");


                        }
                         return data;

                }
            }



            },


            },
 *
 */

?>




<div class="col-sm-12">
    <div class="white-box">

        <!-- Default bootstrap modal example -->
        <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="myModalLabel">Топливная карта</h4>
                    </div>
                    <div class="modal-body">
                        ...
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Закрыть</button>

                        <!--<button type="button" class="btn btn-primary">Save changes</button>-->
                    </div>
                </div>
            </div>
        </div>






        <div align="center" style="max-width: 300px;margin-left: 38%;">
            <div >
                <?= $this->render('../form/month_year', compact(['month', 'year','ccard'])) ?>
            </div>
        </div>


        <div class="table-responsive">

            <table id="dt" class="display nowrap" cellspacing="0" width="100%">
                <thead>
                <tr>
                    <th>Карта</th>
                    <th>Дата</th>
                    <th>Держатель</th>
                    <th>ТО</th>
                    <th>Адрес ТО</th>
                    <th>Услуга</th>
                    <th>Операция</th>
                    <th>Количество</th>
                    <th>Цена на ТО</th>
                    <th>Стоимость на ТО</th>

                </tr>
                </thead>
                <tbody>
                <?php
                if ($data) {

                    foreach ($data as $dat) {

                      //  if (!isset($_GET['card']) or $_GET['card'] == $dat['CodCard']) {

                            ?>

                            <tr>
                                <td>
                                    <a href="/card/info/<?= $dat['CodCard'] ?>" data-toggle="modal"
                                       data-target="#myModal" data-remote="false"> <?= $dat['CodCard'] ?></a>
                                </td>
                                <td><?= Help::normalDate($dat['Period'], false, 'd.m.Y H:i:s') ?></td>
                                <td><?= $dat['owner'] ?></td>
                                <td><?= Help::iconOil($dat['postavka']) ?></td>
                                <td><?= Help::mySubstr(Help::validateAddress($dat['address']), 60) ?></td>
                                <td>
                                    <?php
                                    foreach (explode(",", $dat['oil']) as $oil) {
                                        print "<span class=\"badge\">" . $oil . "</span>";
                                    }
                                    ?>
                                </td>

                                <td> <?= $dat['vid'] ?></td>
                                <td align="center"><?= mb_substr($dat['counts'], 0, -1) ?></td>
                                <td><?= $dat['price'] ?></td>
                                <td><?= $dat['summa'] ?></td>
                            </tr>
                            <?
                      //  }
                    }
                }
                ?>
                </tbody>
            </table>
        </div>
    </div>

    <input type="hidden" id="temp_var" value="ss">

</div>


