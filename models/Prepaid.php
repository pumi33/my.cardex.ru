<?php

namespace my\models;

use Yii;
use yii\base\Model;
use kartik\mpdf\Pdf;


/**
 * Login form
 */
class Prepaid extends \yii\db\ActiveRecord
{


    public static function tableName()
    {
        return 'prepaid';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            // username and password are both required
            [['summa'], 'integer', 'max' => '10000000', 'min' => '1'],
            [['summa'], 'required'],
            [['dogovor_guid'], 'string'],

        ];
    }

    public function attributeLabels()
    {
        return [
            'summa' => "Сумма ₽",
            'print' => "С печатью",

        ];
    }

    public function Pdf($html, $filename = 'test')
    {
        $save = 1;
        $pdf  = new Pdf([
            'orientation'  => Pdf::ORIENT_PORTRAIT,
            //  'mode' => Pdf::MODE_CORE,
            //  'destination'=> Pdf::DEST_DOWNLOAD,
            'destination'  => ($save) ? Pdf::DEST_FILE : Pdf::DEST_BROWSER,
            //  'cssFile' => '@vendor/kartik-v/yii2-mpdf/assets/kv-mpdf-bootstrap.min.css',
            'cssInline'    => ' body{background-color: #3366CC;} ',
            'filename'     => 'Report.pdf',
            'marginRight'  => '5',
            'marginLeft'   => '5',
            'marginTop'    => '5',
            'marginBottom' => '20',
            'options'      => ['title' => 'Report'],

        ]); // or new Pdf();


        $mpdf = $pdf->api; // fetches mpdf api


        //$html = '565665';

        $mpdf->shrink_tables_to_fit = 8;
        $mpdf->use_kwt              = true;
        $mpdf->table_keep_together  = true;


        $mpdf->WriteHtml($html); // call mpdf write html


        $filename = \Yii::$app->basePath . '/temp/invoices/' . $filename . '.pdf';
        $mpdf->Output($filename, 'F'); // call the mpdf api output as needed
        $pdf->render();

    }

    public function Html($html, $filename = 'test')
    {
        $filename = \Yii::$app->basePath . '/temp/invoices/' . $filename . '.html';
        file_put_contents($filename, $html);
    }


}

?>