<?php
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use  my\helpers\Help;

$this->title = 'Выставить счет ';
$this->params['breadcrumbs'][] = ['label' => 'Отчетность'];
$this->params['breadcrumbs'][] = $this->title;




$this->registerJs("        


$(function(){
    $('#myFormSubmit').click(function(e){
      e.preventDefault();
      
      //$('.modal-body').html('asasas');
    $.get( \"/report/prepaid-send2/\", { nomer: \"John\", time: \"2pm\" },function( data ) {
    
    if(data=='ok'){
     $('.modal-body').html(data);
      $('#myFormSubmit').hide();
     
    }else{
    $('.danger').empty();
    $('.modal-body').append('<div class=\'danger\' style=\'color: #cd0a0a\'>'+data+'</div>');
    }
          
});
    
    });
});


");



    $this->registerCss("   
.credit-table td div {
        color: #000;
    }  
    
    .table_inv td{
    margin:20px;
     padding:2px;
    }
   
    .table_inv {
      width:60%
    }
    
     
    .table_inv th{
      
  text-align: center;
  
    }
    
      ");





?>


<div class="col-sm-12">
    <div class="white-box">



        <? $form = ActiveForm::begin(['id' => 'account-enter', 'options' => ['class' => 'form-default']]); ?>

        <?= $form->field($model, 'summa')->textInput(['class'=>'form-control max100','type' => 'text']) ?>


<div>
        <label><input id="prepaid-print" name="Prepaid[print]" value="1" aria-invalid="false" type="checkbox" <?=isset($_POST['Prepaid']['print'])?'checked':'';  ?> >&nbsp; С печатью</label>

    </div>


<br>

        <?= Html::submitButton('Выставить', ['class' => 'btn btn-info waves-effect waves-light  m-r-10', 'name' => 'login-button']) ?>
        <?php ActiveForm::end(); ?>

        <br><br>


        <?
        if($document){
            ?>

            <a class="dt-button buttons-pdf buttons-html5" tabindex="0" aria-controls="dt" href="?nomer=<?= $nomer ?>&<?=isset($_POST['Prepaid']['print'])?'print=1&':'';  ?>"
               title="PDF"><span><i class="fa fa-file-pdf-o"></i></span></a>

            <a class="dt-button buttons-pdf buttons-html5" target="_blank" tabindex="0" aria-controls="dt" href="?printer=1&nomer=<?= $nomer ?>&<?=isset($_POST['Prepaid']['print'])?'print=1':'';  ?>"
               title="Печать"><span><i class="fa fa-print"></i></span></a>


            <a class="dt-button buttons-mail buttons-html5" title="Отправить на почту" tabindex="0" aria-controls="dt"
                href="/report/prepaid-send/?nomer=<?= $nomer ?>&<?=isset($_POST['Prepaid']['print'])?'print=1':'';  ?>" data-toggle="modal"
               data-target="#myModal" data-remote="false" ><span><i class="fa fa-send-o"></i></span></a>




            <?
            print     $this->render('prepaid_invoices', ['summa'=>$summa,'invoices'=>$invoices,'params'=>$params,'nomer'=>$nomer,'print'=>$_POST['Prepaid']['print']]);
        }

        ?>





<br><br><br><br><br><br><br>


    </div>
</div>




