<?php

namespace my\controllers;


use yii\filters\AccessControl;
use yii\httpclient\Client;
use yii\helpers\Json;
use yii\helpers\ArrayHelper;
use my\helpers;
use my\models\Dogovors;
use my\models\Report;
use my\models\Prepaid;
use my\models\Params;
use my\helpers\Help;
use my\components\Error;
use yii\base\DynamicModel;
use yii\base\ErrorException;
use kartik\mpdf\Pdf;
use my\models\User;

use PhpOffice\PhpSpreadsheet\Helper\Sample;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\RichText;
use PhpOffice\PhpSpreadsheet\Style\Color;
use  my\components\MyController;
use my\models\Notifications;


class ReportController extends MyController
{


    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                //  'only' => ['index'],
                'rules' => [
                    [
                        'actions' => ['notifications'],
                        'allow'   => true,
                        'roles'   => ['superadmin', 'admin'],

                    ],

                    [
                        //  'actions' => ['index'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],

                ],

            ],

        ];
    }


    public function actionTransaction($month = null, $year = null, $export = null)
    {

        if (is_numeric($month) and is_numeric($year)) {
            $date = $year . "-" . $month;
        } else {
            $date = date("Y-n");
        }


        $client   = new Client();
        $response = $client->createRequest()
            ->setMethod('get')
            ->setUrl(\Yii::$app->params['api-url'] . '/report/transaction/')
            ->setData(['dogovor' => \Yii::$app->user->identity->dogovor_guid, 'date' => $date])->send();

        //if($status and $status!="")
        //   $client ->setData(['status' => $status]);

        // $response=$client->send();

        if ($response->isOk) {
            $data = $response->data;
        } else {
            // throw new \yii\httpclient\Exception('не могу получить данные');
        }


        return $this->render('transaction', compact(['data', 'month', 'year']));


    }


    public function actionTransactionExel($month = null, $year = null)
    {
        if ($month == 0) {
            $month = null;
        }
        if ($year == 0) {
            $year = null;
        }


        if (is_numeric($month) and is_numeric($year)) {
            $date = $year . "-" . $month;
        } else {
            $date = date("Y-n");
        }

        $dir = __DIR__ . '/../../yii/vendor/phpoffice/phpspreadsheet/src/Bootstrap.php';


        require_once($dir);


        $client   = new Client();
        $response = $client->createRequest()
            ->setMethod('get')
            ->setUrl(\Yii::$app->params['api-url'] . '/report/transaction/')
            ->setData(['dogovor' => \Yii::$app->user->identity->dogovor_guid, 'date' => $date])->send();

        //if($status and $status!="")
        //   $client ->setData(['status' => $status]);

        // $response=$client->send();

        if ($response->isOk) {
            $data = $response->data;
        } else {
            // throw new \yii\httpclient\Exception('не могу получить данные');
        }

        Help::Exel('Транзакционный отчет', $response->data);
        exit;


    }


    public function actionTransactionPdf($month = null, $year = null)
    {

        if ($month == 0) {
            $month = null;
        }
        if ($year == 0) {
            $year = null;
        }


        if (is_numeric($month) and is_numeric($year)) {
            $date = $year . "-" . $month;
        } else {
            $date = date("Y-n");
        }


        $client   = new Client();
        $response = $client->createRequest()
            ->setMethod('get')
            ->setUrl(\Yii::$app->params['api-url'] . '/report/transaction/')
            ->setData(['dogovor' => \Yii::$app->user->identity->dogovor_guid, 'date' => $date])->send();  //\Yii::$app->user->identity->dogovor_guidADE8448A5BD93EE411E4ADFD491DFBC6

        //if($status and $status!="")
        //   $client ->setData(['status' => $status]);

        // $response=$client->send();


        $data  = $response->data;
        $data2 = ArrayHelper::index($data, null, 'CodCard');


        $html = "<h4 align='center'>Оборот по убслуживанию (" . \Yii::$app->session['company'] . ") ";
        $html .= "<br>Договор " . \Yii::$app->session['dogovor'] . " </h4>";
        //   $html .= "<style> th{ border:  1px solid black; margin:0px;padding:0px}</style>";


        $first_dat = date("1.m.Y", strtotime($date));
        $last_dat  = date('d', strtotime("last day of $date")) . date(".m.Y", strtotime($date));

        $html .= "<h5 align='center'>С " . $first_dat . " по " . $last_dat . "</h5>";
        $html .= "<table width='100%' cellspacing='3' cellpadding='1' border='0'><tr align='center'><th colspan='2'>&nbsp;</th><th align='center'>Дата</th><th align='center'>ТО</th><th align='center'>Адрес ТО</th><th  width='70px' align='center'>Услуга</th><th  width='80px' align='center'>Операция</th><th width='80px' align='center'>Количество</th><th width='80px' align='center'>Цена на ТО</th><th width='80px' align='center'>Стоимость на ТО</th></tr>";
        $html .= "<tr><td colspan='10'><b>" . \Yii::$app->session['company'] . "</b></td></tr>";

        $summa3    = 0;
        $summa_oil = $count_oil = [];

        foreach ($data2 as $key => $dat2) {

            $html .= "<tr><td colspan='10'>
<table width='100%' cellspacing='0' cellpadding='0'>
<tr>
<td colspan='10'><hr style='height: 2px;border: none; background-color: #000;color: #000;'></td>
</tr>
<tr>
<td width='3%'>
&nbsp;
</td>
<td width='30%'> <b>Карта: " . $key . "</b>   </td> <td> <b>Держатель: " . $dat2['0']['owner'] . "</b>  </td> 
</tr>
<tr>
<td colspan='10'><div style='margin-left: 40px'><hr></div></td>
</tr>


 </table>
 </td></tr>";


            $dat3   = ArrayHelper::index($dat2, null, 'oil');
            $summa4 = 0;

            foreach ($dat3 as $key2 => $dat4) {

                $html .= "<tr><td width='4%'>&nbsp;</td><td colspan='9'>" . $key2 . "</td></tr>";

                $summa5 = 0;

                $cc = 0;

                foreach ($dat4 as $dat5) {

                    $html   .= "<tr>
                <td>&nbsp;</td>
                 <td>&nbsp;</td>
                <td><nobr>" . Help::normalDate($dat5['Period'], false, 'd.m.Y H:i:s') . "</nobr></td>
                <td>" . $dat5['postavka'] . "</td>
                <td>" . $dat5['address'] . "</td>
                <td align='center'>" . $dat5['oil'] . "</td>
                <td align='center'>" . $dat5['vid'] . "</td>
                <td align='center'>" . mb_substr($dat5['counts'], 0, -1) . "</td>
                <td align='center'>" . $dat5['price'] . "</td>
                <td align='right'><nobr>" . \number_format($dat5['summa'], 2, '.', ' ') . "</nobr></td>
                </tr>";
                    $summa5 += $dat5['summa'];


                    if (!isset($summa_oil[$dat5['oil']])) {
                        $summa_oil[$dat5['oil']] = 0;
                    }
                    if (!isset($count_oil[$dat5['oil']])) {
                        $count_oil[$dat5['oil']] = 0;
                    }


                    $summa_oil[$dat5['oil']] = $summa_oil[$dat5['oil']] + $dat5['summa'];
                    $count_oil[$dat5['oil']] = $count_oil[$dat5['oil']] + mb_substr($dat5['counts'], 0, -1);

                    $cc = $cc + $dat5['counts'];

                }
                $html .= "<tr><td colspan='10' align='right'><div style='margin-left: 40px'><hr style='margin-top: 3px; margin-bottom: 3px'></div> </td></tr>";

                if (strpos($cc, '.') === false) {
                    $cc = $cc . ".00";
                }

                $html .= "<tr><td colspan='7' >&nbsp;</td><td align='center'>" . $cc . "</td><td>&nbsp;</td><td align='right'>" . \number_format($summa5, 2, '.', ' ') . "</td></tr>";


                $summa4 += $summa5;
            }


            $html .= "<tr><td colspan='10'  >
<hr style='margin-top: 3px; margin-bottom: 3px'>
 <table width='100%' cellspacing='0' cellpadding='0'><tr>
<td>Итого по карте:</b></td>
<td align='right'> " . \number_format($summa4, 2, '.', ' ') . "</b></td> 
  </tr>
    </table>   
             </td></tr>";

            $summa3 += $summa4;
        }


        $html .= "<tr><td colspan='10' align='right'><div align='left'><hr style='height: 2px;border: none; background-color: #000;color: #000;'>

<table width='100%' cellspacing='0' cellpadding='0' border='0'><tr><td align='left'><b>Итого по клиенту:</b></td><td align='right'>" . \number_format($summa3, 2, '.', ' ') . " </td></tr></table>
  </td></tr>";

        $itog_oil = [];

        foreach ($summa_oil as $s_key => $s_value) {
            $itog_oil['oil']   .= $s_key . "<br>";
            $itog_oil['summa'] .= \number_format($s_value, 2, '.', ' ') . "<br>";
        }

        foreach ($count_oil as $c_key => $c_value) {
            $itog_oil['count'] .= \number_format($c_value, 2, '.', ' ') . "<br>";
        }


        $html .= "<tr><td colspan='10' align='right'><div align='left'>

<table width='100%' border='0'>
<tr>
<td width='50%'>&nbsp;</td>
<td><b>Общий итог по услугам:</b><br>
" . $itog_oil['oil'] . "
</td>
<td align='right' width='80px'><br><br>" . $itog_oil['count'] . " &nbsp; &nbsp; &nbsp; &nbsp;</td>
<td align='center' width='80px'>&nbsp;</td>
<td align='right' width='80px'><br>" . $itog_oil['summa'] . " </td>
</tr>
</table>

  </td></tr>";
        $html .= "

";


        $html .= "</table>";


        Help::Pdf('Оборот_по_обслуживанию', $html);

        /*
        $html .= "<br><br> Отчет сформирован: ";
        $formatter = new \yii\i18n\Formatter;
        $formatter->datetimeFormat = 'php:d.m.Y H:i';
        $formatter->timeZone = 'Europe/Moscow';
        $html .= $formatter->asDateTime("now");




        $pdf = new Pdf([
            'orientation' => Pdf::ORIENT_LANDSCAPE,
            //  'mode' => Pdf::MODE_CORE,
            //  'destination'=> Pdf::DEST_DOWNLOAD,
            'destination' => Pdf::DEST_BROWSER,
            //  'cssFile' => '@vendor/kartik-v/yii2-mpdf/assets/kv-mpdf-bootstrap.min.css',
            'cssInline' => ' body{background-color: #fff;} ',
            'filename' => 'Report.pdf',
            'marginRight' => '5',
            'marginLeft' => '5',
            'marginTop' => '5',
            'marginBottom' => '10',
            'options' => ['title' => 'Report'],

        ]); // or new Pdf();


        $mpdf = $pdf->api; // fetches mpdf api


        $mpdf->shrink_tables_to_fit = 8;
        $mpdf->use_kwt = true;
        $mpdf->table_keep_together = true;


        // $mpdf->WriteHtml($html); // call mpdf write html


        //$filename = \Yii::$app->basePath . '/temp/invoices/'.$filename.'.pdf';

        $file_name = 'Оборот_по_обслуживанию_' . date("Y-m-d") . ".pdf";
        $pdf->Output($html, $file_name); // call the mpdf api output as needed
        $pdf->render();

        */


    }


    /**
     * @param int $count_lasr_month
     *
     * @return mixed
     */
    public function actionFinance($finance_period = '3months')
    {
        $monthStartLenght = Help::getCountMonth($finance_period);
        $data             = null;


        $dogovor_code = Dogovors::getMyCode();


        for ($i = $monthStartLenght[0]; $i < $monthStartLenght[0] + $monthStartLenght[1]; $i++) {


            $ii = $i;  //$ii=$i-1; (раскоментировать)


            $time_minus  = strtotime("-$i month");
            $time_minus2 = strtotime("-$ii month");

            $time_minus  = strtotime('first day of this month', $time_minus);
            $time_minus2 = strtotime('first day of this month', $time_minus2);


            $data[$i]['month'] = strftime('%B', $time_minus);
            $month             = date("n", $time_minus);
            $monthYear         = date('Y-m', $time_minus);
            $sendDate          = date('Ym', $time_minus);


            $sendDate2 = date('Y-m-01', $time_minus2);

            if ($month == date('n')) {
                $last_day = date('d');
            } else {
                $last_day = date('d', strtotime("last day of $monthYear"));
            }

            $data[$i]['month_title'] = "1 — " . $last_day . " " . \Yii::$app->params['ruMonthSkl'][$month] . " " . strftime('%Y', $time_minus);

            //Получаем отчеиные документы
            $client   = new Client();
            $response = $client->createRequest()
                ->setMethod('get')
                ->setUrl(\Yii::$app->params['api-url'] . '/files/all')
                ->setData(['dogovor_code' => $dogovor_code, 'date' => $sendDate])->send();

            if ($response->isOk) {
                $data[$i]['files'] = $response->data;
            }

            //Получаем баланс на конец расчетного периода
            $client   = new Client();
            $response = $client->createRequest()
                ->setMethod('get')
                ->setUrl(\Yii::$app->params['api-url'] . '/report/finance-balance')
                ->setData(['dogovor' => \Yii::$app->user->identity->dogovor_guid, 'date' => $sendDate2])->send();

            if ($response->isOk) {
                $data[$i]['balance'] = $response->data[0];
            }


            //Баланс на сегодня
            if ($sendDate == date('Ym')) {
                //$data[$i]['balance']['summa'] = \Yii::$app->session['balance'] * -1;
            }


            // Получаем движение средств
            $client   = new Client();
            $response = $client->createRequest()
                ->setMethod('get')
                ->setUrl(\Yii::$app->params['api-url'] . '/report/finance-transaction')
                ->setData(['dogovor' => \Yii::$app->user->identity->dogovor_guid, 'date' => $monthYear])->send();

            if ($response->isOk) {
                $data[$i]['finance-transaction'] = $response->data;
            }
        }


        // ПОдключен ли к ЭДо
        $client   = new Client();
        $response = $client->createRequest()
            ->setMethod('get')
            ->setUrl(\Yii::$app->params['api-url'] . '/dogovors/edo')
            ->setData(['dogovor' => \Yii::$app->user->identity->dogovor_guid])->send();
        $edo      = "";
        if ($response->isOk) {
            $edo = $response->data;
        }


        // print_r($edo);

        return $this->render('finance', compact(['data', 'finance_period', 'edo']));
    }


    public function actionPrepaidSend($nomer)
    {
        $this->layout = false;
        //   $mymail=\Yii::$app->user->identity->email;


        $code = Dogovors::getMyCode();

        $file = \Yii::$app->basePath . '/temp/invoices/' . $code . "_" . $nomer . "_" . date("dmY") . '.pdf';
        if (file_exists($file)) {


            \Yii::$app->session->setFlash('success', 'Счет отправлен на почту ' . User::getMyMail());


            \Yii::$app->mailCardex->compose()
                ->setTo(User::getMyMail())
                ->setSubject('Счет на оплату ' . $nomer)
                ->setTextBody('Уважаемый пользователь Личного кабинета клиента "КАРДЕКС", Вы получили данное письмо, так как отправили запрос на получение выставленного Вам счета по e-mail.
Ваш счет в формате pdf приложен к данному письму.')
                ->attach($file)
                ->send();


            return 'Счет был отправлен на вашу почту <b>' . User::getMyMail() . "</b>";

            //return $this->redirect(["/report/prepaid/"]);


        }


    }


    public function actionTest()
    {
        $this->layout = 'test';


        return $this->render('test');

    }


    /* Вытсавить счет
     * @return mixed
     */
    public function actionPrepaid($nomer = null, $print = null, $printer = null)
    {


        $code   = Dogovors::getMyCode();
        $params = Params::find()->asArray()->all();


        //скачать договор


        if ($nomer and !$printer) {
            $file = \Yii::$app->basePath . '/temp/invoices/' . $code . "_" . $nomer . "_" . date("dmY") . '.pdf';
            if (file_exists($file)) {
                header("Content-type:application/pdf");
                // It will be called downloaded.pdf
                header("Content-Disposition:attachment;filename=invoices_cardex_" . date("dmY") . ".pdf");

                readfile($file);
            } else {
                throw new \yii\web\NotFoundHttpException;
            }
        }

        if ($printer and $nomer) {
            $file = \Yii::$app->basePath . '/temp/invoices/' . $code . "_" . $nomer . "_" . date("dmY") . '.html';

            if (file_exists($file)) {
                $html = file_get_contents($file);

                print $html . "<script>window.print();</script>";
                exit;


            } else {
                throw new \yii\web\NotFoundHttpException;
            }
        }


        $model = new Prepaid();


        $client   = new Client();
        $invoices = $client->createRequest()
            ->setMethod('get')
            ->setUrl(\Yii::$app->params['api-url'] . '/report/invoices/')
            ->setData(['owner' => \Yii::$app->user->identity->owner_guid])->send();

        $model->summa = round((int)$invoices->data['last_invoices']);

        //if ($model->summa == "")
        //  $model->summa = 120000;

        if ($model->load(\Yii::$app->request->post()) && $model->validate()) {
            $model->dogovor_guid = \Yii::$app->user->identity->dogovor_guid;
            $summa               = $model->summa;


            $model2 = Prepaid::find()->where(['summa' => $summa, 'dogovor_guid' => \Yii::$app->user->identity->dogovor_guid,])->andWhere(['DATE_FORMAT(created_at, "%d%m%Y")' => date('dmY')])->one();


            if ($model2) {
                $model = $model2;
                \Yii::$app->session->setFlash('success', '111111111');
                $nomer = 'С' . str_pad($model->id, 10, "0", STR_PAD_LEFT);
            } else {

                if (!$model->save()) {

                    Help::modelErrors($model->errors);
                }


                $nomer = 'С' . str_pad($model->id, 10, "0", STR_PAD_LEFT);


                $client   = new Client();
                $response = $client->createRequest()
                    ->setMethod('get')
                    ->setUrl(\Yii::$app->params['api-url'] . '/exchange/prepaid')
                    ->setData(['dogovor_code' => Dogovors::getMyCode(), 'summa' => $summa, 'id' => $nomer])->send();


                if ($response->isOk and $response->data == 1) {
                    \Yii::$app->session->setFlash('success', 'Счет выставлен2');
                } else {
                    Error::write('не могу создать счет');
                }
            }


            \Yii::$app->session->setFlash('success', 'Счет выставлен');
            $document = "1";


            $test = $this->renderPartial('prepaid_invoices', ['model' => $model, 'document' => $document, 'summa' => $summa, 'pdf' => 1, 'invoices' => $invoices->data, 'params' => $params, 'nomer' => $nomer, 'print' => \Yii::$app->request->post()['Prepaid']['print']]);
            //  $test2 = $this->renderPartial('prepaid_invoices', ['model' => $model, 'document' => $document, 'summa' => $summa, 'pdf'=>1,'invoices' => $invoices->data, 'params' => $params, 'nomer' => $nomer,'print'=>1]);


            $model->Pdf($test, $code . "_" . $nomer . "_" . date("dmY"));
            $model->Html($test, $code . "_" . $nomer . "_" . date("dmY"));

        }


        return $this->render('prepaid', ['model' => $model, 'document' => $document, 'summa' => $summa, 'print' => $print, 'invoices' => $invoices->data, 'params' => $params, 'nomer' => $nomer]);

    }


    public function actionDdos()
    {


        for ($i = 1; $i <= 10; $i++) {

            $client   = new Client();
            $response = $client->createRequest()
                ->setMethod('get')
                ->setUrl(\Yii::$app->params['api-url'] . '/exchange/prepaid')
                ->setData(['dogovor_code' => '000001044', 'summa' => rand(1, 111111111)])->send();
            if ($response->isOk) {
                print $i . "_" . date("s") . "<br>";
            }

        }


    }


    /** Модальное окно баланса
     * @return string
     */
    public function actionBalance()
    {
        $this->layout = false;


        /*
        $dogovorInfo=Dogovors::getMy();

        if(!$dogovorInfo)
            throw new \yii\httpclient\Exception('не могу получить данные по договру');

        $data="";

        $data.="Остаток до блокировки карт : <b>".\number_format($dogovorInfo['balance']-$dogovorInfo['n_ostatok'], 2, ',', ' ')."</b> руб. \n<br>";
        $data.="Текущий остаток : <b>".\number_format($dogovorInfo['balance'], 2, ',', ' ')."</b> руб. \n<br>";
        $data.="Неснижаемый остаток по договору : <b>".\number_format($dogovorInfo['n_ostatok'], 2, ',', ' ')."</b> руб. \n<br>";
*/
        $data = "";

        $data .= "Остаток до блокировки карт : <b>" . \number_format(\Yii::$app->session['balance'] - \Yii::$app->session['n_ostatok'], 2, ',', ' ') . "</b> руб. \n<br>";
        $data .= "Текущий остаток : <b>" . \number_format(\Yii::$app->session['balance'], 2, ',', ' ') . "</b> руб. \n<br>";
        $data .= "Неснижаемый остаток по договору : <b>" . \number_format(\Yii::$app->session['n_ostatok'], 2, ',', ' ') . "</b> руб. \n<br>";


        return $data;


    }


    /** Модальное окно баланса
     * @return string
     */
    public function actionRepeate($file)
    {


        if (\Yii::$app->request->post()) {
            $document = explode(".", $file);

            $client2   = new Client();
            $response2 = $client2->createRequest()
                ->setMethod('get')
                ->setUrl(\Yii::$app->params['api-url'] . '/exchange/document-repeat-send')
                ->setData(['dogovor_code' => Dogovors::getMyCode(), 'document' => $document[0]])->send();


            return 1;

        }


        $this->layout = false;


        $data = "";

        $data .= "<div style='display:none;' class='alert alert-info resp'>Запрос на отправку документа принят</div>";

        $data .= "Документ <b>" . Help::filesRus($file) . "</b> будет отправлен со следующей отправкой документов<br>";


        $data .= "  <div class='buttons'> <br><div align='center'><button type=\"button\" class=\"btn btn-warning\" data-dismiss=\"modal\">Не надо</button> &nbsp; &nbsp; ";
        $data .= "  <button type=\"button\" class=\"btn btn-primary\"  id=\"ok\" >Отправить</button></div></div>";


        $data .= "


<script>
    $(document).ready(function() {
        $(\"#ok\").click(function() {
      

      
            $.ajax(
                {
                    type: 'POST',
                    url: '/report/repeate?file=" . $file . "',
                    dataType: 'json',
                    data: {'" . \yii::$app->request->csrfParam . "': '" . \yii::$app->request->csrfToken . "'
                  
                    }, //это передача body

                    success: function(response)
                    {
                        if(response=1) {
                            $(\".resp\").show();
                                $(\".buttons\").hide();
                        }

                    },
                    error: function()
                    {
                     //   alert(\"Failure\");
                    }
                });

            
            return false;


        });

        


    });
</script>
 
 
";


        return $data;


    }


    /** Модальное окно договора
     * @return string
     */
    public function actionDogovor()
    {
        $this->layout = false;

        $client = new Client();

        $dogovor = Dogovors::getMy();

        $invoices = $client->createRequest()
            ->setMethod('get')
            ->setUrl(\Yii::$app->params['api-url'] . '/report/invoices/')
            ->setData(['owner' => $dogovor['owner_guid']])->send();

        if (!$invoices) {
            throw new \yii\httpclient\Exception('не могу получить данные по договру');
        }

        $in = $invoices->data;

        $data = "";


        $data .= "Компания: <b>" . \Yii::$app->session['company'] . "</b><br>";
        $data .= "Договор: <b>" . \Yii::$app->session['dogovor'] . "</b> ";
        //$data .= "Гинеральный директор: <b>ss</b><br><br>";

        if (!empty($dogovor['date_dogovor'])) {
            $data .= "от <b>" . date('d.m.Y', strtotime($dogovor['date_dogovor'])) . "</b>";
        }

        $data .= "<br><br>";
        $data .= "Юридический Адрес: <b>" . $in['ur_address'] . "</b><br>";
        $data .= "Фактический адрес: <b>" . $in['fact_address'] . "</b><br>";
        $data .= "Почтовый Адрес: <b>" . $in['post_address'] . "</b><br><br>";


        $data .= "ИНН: <b>" . $in['inn'] . "</b><br>";

        if ($in['kpp']) {
            $data .= "КПП: <b>" . $in['kpp'] . "</b><br>";
        }


        print "<br>";
        if ($in['nome_s']) {
            $data .= "Расчетный счёт: <b>" . $in['nome_s'] . "</b><br>";
        }

        if ($in['bik']) {
            $data .= "БИК: <b>" . $in['bik'] . "</b><br>";
        }

        if ($in['korr_s']) {
            $data .= "Корреспондентский счёт: <b>" . $in['korr_s'] . "</b><br>";
        }


        $data .= "<br>";
        $data .= "<span style='color: #fff'>Внутренний номер: <b>" . Dogovors::getMyCode() . "</b></span>";


        return $data;
    }


    public function actionAnalyticsWeekendPdf($date1 = null, $date2 = null)
    {

        if (empty($date1)) {
            $date1 = null;
        }

        if (empty($date2)) {
            $date2 = null;
        }

        if (empty($date1)) {
            $dd = new \DateTime();
            $dd->modify('-1 year');
            $date1 = $dd->format('Y-m-d');
        }
        if (empty($date2)) {
            $date2 = date('Y-m-d');
        }


        $client   = new Client();
        $response = $client->createRequest()
            ->setMethod('get')
            ->setUrl(\Yii::$app->params['api-url'] . '/report/weekend-transaction/')
            ->setData(['dogovor' => \Yii::$app->user->identity->dogovor_guid, 'date_start' => $date1, 'date_end' => $date2])->send();


        $html = Report::getTable($response->data, $date1, $date2, ['print' => 1, 'name' => 'Заправки в выходные и праздники']);
        Help::Pdf('Заправки в выходные и праздники', $html);


    }


    public function actionAnalyticsDoublePdf($date1 = null, $date2 = null)
    {

        if (empty($date1)) {
            $date1 = null;
        }

        if (empty($date2)) {
            $date2 = null;
        }

        if (empty($date1)) {
            $dd = new \DateTime();
            $dd->modify('-1 year');
            $date1 = $dd->format('Y-m-d');
        }
        if (empty($date2)) {
            $date2 = date('Y-m-d');
        }


        $client   = new Client();
        $response = $client->createRequest()
            ->setMethod('get')
            ->setUrl(\Yii::$app->params['api-url'] . '/report/double-transaction/')
            ->setData(['dogovor' => \Yii::$app->user->identity->dogovor_guid, 'date_start' => $date1, 'date_end' => $date2])->send();


        $html = Report::getTable($response->data, $date1, $date2, ['print' => 1, 'name' => 'Двойные запрвки']);
        Help::Pdf('Двойные запрвки', $html);


    }


    public function actionAnalyticsWeekendExel($date1 = null, $date2 = null)
    {

        if (empty($date1)) {
            $date1 = null;
        }

        if (empty($date2)) {
            $date2 = null;
        }

        if (empty($date1)) {
            $dd = new \DateTime();
            $dd->modify('-1 year');
            $date1 = $dd->format('Y-m-d');
        }
        if (empty($date2)) {
            $date2 = date('Y-m-d');
        }


        $client   = new Client();
        $response = $client->createRequest()
            ->setMethod('get')
            ->setUrl(\Yii::$app->params['api-url'] . '/report/weekend-transaction/')
            ->setData(['dogovor' => \Yii::$app->user->identity->dogovor_guid, 'date_start' => $date1, 'date_end' => $date2])->send();


        Help::Exel('Заправки в выходные и праздники', $response->data);

    }


    public function actionAnalyticsDoubleExel($date1 = null, $date2 = null)
    {

        if (empty($date1)) {
            $date1 = null;
        }

        if (empty($date2)) {
            $date2 = null;
        }

        if (empty($date1)) {
            $dd = new \DateTime();
            $dd->modify('-1 year');
            $date1 = $dd->format('Y-m-d');
        }
        if (empty($date2)) {
            $date2 = date('Y-m-d');
        }


        $client   = new Client();
        $response = $client->createRequest()
            ->setMethod('get')
            ->setUrl(\Yii::$app->params['api-url'] . '/report/double-transaction/')
            ->setData(['dogovor' => \Yii::$app->user->identity->dogovor_guid, 'date_start' => $date1, 'date_end' => $date2])->send();


        Help::Exel('Двойные заправки', $response->data);

    }


    public function actionAnalytics()
    {


        if (\Yii::$app->request->post()['dates']) {
            $dates = explode(" - ", \Yii::$app->request->post()['dates']);
            $date1 = trim($dates[0]);
            $date2 = trim($dates[1]);
            if (Help::validateDate($date2) and Help::validateDate($date1)) {


                $date1 = trim($dates[0]);
                $date2 = trim($dates[1]);

            } else {
                $date1 = "";
                $date2 = "";
            }


        }


        $report = new Report();


        $client   = new Client();
        $response = $client->createRequest()
            ->setMethod('get')
            ->setUrl(\Yii::$app->params['api-url'] . '/dogovors/transaction/')
            ->setData(['dogovor' => \Yii::$app->user->identity->dogovor_guid, 'act' => 'all', 'date_start' => $date1, 'date_end' => $date2])
            ->send();

        $response2 = $client->createRequest()
            ->setMethod('get')
            ->setUrl(\Yii::$app->params['api-url'] . '/dogovors/transaction/')
            ->setData(['dogovor' => \Yii::$app->user->identity->dogovor_guid, 'act' => 'all-date', 'date_start' => $date1, 'date_end' => $date2])
            ->send();


        $data['oil'] = $response;
        $data['avg'] = $response2;


        //двойные заправки

        $client   = new Client();
        $response = $client->createRequest()
            ->setMethod('get')
            ->setUrl(\Yii::$app->params['api-url'] . '/report/double-transaction/')
            ->setData(['dogovor' => \Yii::$app->user->identity->dogovor_guid, 'date_start' => $date1, 'date_end' => $date2])->send();

        $double[] = $response->data;


        /*
        $double=[];
        if($doubles){

            foreach ($doubles as $d){

                if(isset($d['CodCard'])) {

                    $response = $client->createRequest()
                        ->setMethod('get')
                        ->setUrl(\Yii::$app->params['api-url'] . '/report/double-transaction-info/')
                        ->setData(['dogovor' => \Yii::$app->user->identity->dogovor_guid, 'cod_card' => $d['CodCard'], 'period' => $d['Period']])->send();

                    if ($response->data)
                        $double[] = $response->data;

                }
            }
        }
        */


        //Заправки в выходные и праздники

        $client   = new Client();
        $response = $client->createRequest()
            ->setMethod('get')
            ->setUrl(\Yii::$app->params['api-url'] . '/report/weekend-transaction/')
            ->setData(['dogovor' => \Yii::$app->user->identity->dogovor_guid, 'date1' => $date1, 'date2' => $date2])->send();

        $weekend = $response->data;


        //Заправки в выходные и праздники

        $client    = new Client();
        $oils_name = $client->createRequest()
            ->setMethod('get')
            ->setUrl(\Yii::$app->params['api-url'] . '/report/oils/')
            ->setData(['dogovor' => \Yii::$app->user->identity->dogovor_guid, 'date1' => $date1, 'date2' => $date2])->send();


        return $this->render('analytics', compact(['data', 'date1', 'date2', 'double', 'weekend', 'oils_name']));
    }


    public function actionNotifications()
    {


        //  $user = User::getMyUser(\Yii::$app->user->identity->id);

        $user = Dogovors::getMy();


        if (!$user) {
            throw new \yii\web\NotFoundHttpException;
        }


        $notification = new Notifications();

        if ($notification->load(\Yii::$app->request->post()) && $notification->validate()) {
            //   $decode = Json::decode($user->notifications);


            $newmails = [];
            foreach (\Yii::$app->request->post()['mails'] as $mail) {

                if (trim($mail) != "") {
                    $newmails[] = $mail;
                }
            }

            $data['mails'] = implode(";", $newmails);


            $fd = [];
            for ($i = 1; $i < 8; $i++) {

                $week = "week" . $i;
                if (\Yii::$app->request->post()[$week]) {
                    $data[$week] = '01';
                    $fd[]        = 1;
                } else {
                    $data[$week] = '00';
                    $fd[]        = 0;
                }
            }


            if (\Yii::$app->request->post()['Notifications']['ostatkiReminder'] == 2) {
                $data['DogovorMailing'] = 1;
            }


            $dogovor_code = Dogovors::getMyCode();


            $senddata = ['dogovor_code' => $dogovor_code, 'mailreport' => $data['mails'], 'service' => implode(";", $fd), 'balance' => (int)\Yii::$app->request->post()['Notifications']['ostatkiReminder']];

            //print_r($senddata);


            $client   = new Client();
            $response = $client->createRequest()
                ->setMethod('get')
                ->setUrl(\Yii::$app->params['api-url'] . '/notification/set-all')
                ->setData($senddata)->send();


            if (!$response->isOk) {

                \Yii::warning('НЕ могу Записать настройки уведомлений');
            }


            $user->notifications = Json::encode($data);
            $user->save(false);

            return $this->redirect('/report/notifications/');


        }


        $notification = new Notifications();


        if ((\Yii::$app->user->identity->status == USER::STATUS_SUPERADMIN or \Yii::$app->user->identity->status == USER::STATUS_ADMIN) and empty($user->notifications)) {


            $notification_data = new Client();
            $notification_data = $notification_data->createRequest()
                ->setMethod('get')
                ->setUrl(\Yii::$app->params['api-url'] . '/notification/get-notifications')
                ->setData(['dogovor' => \Yii::$app->user->identity->dogovor_guid])->send();


            if ($notification_data->isOk) {
                $notification_data = $notification_data->data;
            } else {
                $notification_data = [];
            }

            //Получаем настройки почты
            $mails = new Client();
            $mails = $mails->createRequest()
                ->setMethod('get')
                ->setUrl(\Yii::$app->params['api-url'] . '/report/invoices/')
                ->setData(['owner' => \Yii::$app->user->identity->owner_guid])->send();

            if ($mails->isOk) {
                $mails = $mails->data['mails'];
            } else {
                $mails = null;
            }

            $notification_data['mails'] = $mails;

            $user->notifications = Json::encode($notification_data);
            $user->save(false);


        } else {


            $decode = Json::decode($user->notifications);




            $exp = explode(";", $decode['mails']);

            //удаляем почту
            if (isset($_GET['delete_mail'])) {
                foreach ($exp as $key => $temp_mail) {
                    if ($key == (int)$_GET['delete_mail']) {
                        if (isset($exp[$key])) {
                            unset($exp[$key]);
                        }
                    }
                }
                $decode['mails'] = implode(";", $exp);
            }


            $notification_data = $decode;
        }


        if (!empty($notification_data['DogovorMailing'])) {
            $notification->ostatkiReminder = 2;
        }


        return $this->render('notification', compact(['user', 'password', 'notification', 'notification_data']));

    }


}
