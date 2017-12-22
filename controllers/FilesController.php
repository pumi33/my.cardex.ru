<?php

namespace my\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\httpclient\Client;
use my\models\Dogovors;
use  my\components\MyController;


class FilesController extends MyController
{


    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                //  'only' => ['index'],
                'rules' => [

                    [
                        //  'actions' => ['index'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],

                ],

            ],

        ];
    }


    public function actionGet($file)
    {

        // \Yii::$app->response->format = 'raw';


        $params = ['dogovor_code' => Dogovors::getMyCode(), 'file' => $file];
        header("X-Accel-Redirect: /filestore/?" . http_build_query($params));


        // header("Content-Type: application/x-force-download");


        //header("Content-disposition: attachment; filename=\"" . basename('11.txt') . "\"");


        /*
                return \Yii::$app->response->xSendFile(
                    "/filestore/", // '/reports/000000812/1.txt',
                    null
                    ,
                    [
                        'inline' => true,
                        'xHeader' => 'X-Accel-Redirect'
                    ]
                );
        */


    }


}
