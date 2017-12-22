<?php

use yii\helpers\Html;
use  my\helpers\Help;
use yii\helpers\ArrayHelper;

$this->title = 'Топливные карты';

$this->params['breadcrumbs'][] = $this->title;


$this->registerCss("
.dataTables_length{
 float: left;
}     

.



");

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

 var table= $('#dt').DataTable({
   dom: '<\"lenght\"l><\"but\"B>  frt <\"summ\">  ip',
        'paging':   true,
        'ordering': true,
        'info':     true,
        stateSave: true,
        
        
        buttons: [
            {
                extend: 'pdfHtml5',
                //orientation: 'landscape',
                pageSize: 'LEGAL',
                text:      '<i class=\"fa fa-file-pdf-o\"></i>',
                titleAttr: 'PDF',
                filename: '*_' + gettime(),
                title: 'КАРДЕКС \\n'+'* ' +' \\n Компания:  " . \Yii::$app->session['company'] . " \\n Договор:  " . \Yii::$app->session['dogovor'] . " ',

            },
             $.extend( true, {}, buttonCommon, {
                extend: 'excelHtml5',
                text:      '<i class=\"fa fa-file-excel-o\"></i>',
                titleAttr: 'Excel',
                  filename: '*_' + gettime(),
                        title: 'КАРДЕКС \\n'+'* ' +' \\n Договор: " . \Yii::$app->session['dogovor'] . "',
                        
                        message: 'asasas',
            } ),
            
           
            {
                extend:    'copyHtml5',
                text:      '<i class=\"fa fa-files-o\"></i>',
                titleAttr: 'Копировать',
                title: 'КАРДЕКС \\n'+'* ' +' \\n Договор: " . \Yii::$app->session['dogovor'] . "',
            },
            {
                extend:    'print',
                text:      '<i class=\"fa fa-print\"></i>',
                titleAttr: 'Печать',
                  title: '<h3>КАРДЕКС </h3><h5>\\n'+'* ' +' \\<br> Компания:  " . \Yii::$app->session['company'] . " <br>Договор: " . \Yii::$app->session['dogovor'] . "<br>Дата выгрузки: " . date('d.m.Y') . " </h5>',

            },

          

        ],
        \"language\": {
            \"url\": \"/plugins/bower_components/datatables/russian.json\"
        }

    });

        //спрятать пагинацию, когда не нужно
     table.on( 'draw', function () {
    $(table.table().container())
      .find('a.previous, a.next, a.current')
      .css( 'display', table.page.info().pages <= 1 ?
           'none' :
           ''
      ) 
  } ); 

  

");
?>

<div class="col-sm-12">
    <div class="white-box">


        <?php


        if (isset($data) and !empty($data)) {
            $results = ArrayHelper::index($data, 'status');
        }


        $dats = [];

        if (isset($results) and !empty($results)) {
            foreach ($results as $key => $result) {

                if (!empty($status)) {
                    $dats['all'] = 'Все карты';
                }

                $dats[$key] = Help::getStatusCard($key);

            }

        }
        ?>




        <?= Help::ul($dats, $status, 'status', 'Статус карты') ?>

        <br>
        <br>


        <div class="table-responsive">
            <table id="dt" class="display nowrap" cellspacing="0" width="100%">
                <thead>
                <tr>
                    <th>Карта</th>
                    <th>Статус</th>
                    <th>Лимит</th>
                    <th>Вид топлива</th>
                    <th>Дата Выдачи</th>
                    <th>Дата последнего использования</th>
                    <th>Держатель</th>

                </tr>
                </thead>
                <tbody>

                <?php
                if (isset($data) and !empty($data)) {
                    foreach ($data as $dat) {
                        if (empty($status) or $dat['status'] == $status) {
                            ?>

                            <tr>
                                <td><a href="/card/info/<?= $dat['code'] ?>" data-toggle="modal" data-target="#myModal"
                                       data-remote="false" title="Информация по карте"><?= $dat['code'] ?></a></td>
                                <td>
                                    <?= Help::getStatusCard($dat['status']) ?>

                                </td>
                                <td><?= $dat['limite'] ?></td>
                                <td><?= $dat['fuelView'] ?></td>
                                <td><?= Help::normalDate($dat['dataDelivery'], false) ?></td>
                                <td><?= Help::normalDate($dat['LastDataUsed'], false) ?></td>
                                <td><?= mb_substr($dat['owner'], 0, 30) ?></td>
                            </tr>
                            <?
                        }
                    }
                }
                ?>

                </tbody>
            </table>
        </div>
    </div>
</div>







