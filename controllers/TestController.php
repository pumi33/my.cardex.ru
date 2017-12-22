<?php

namespace my\controllers;


use yii\filters\AccessControl;
use yii\httpclient\Client;
use yii\helpers\Json;


class TestController extends MyController
{


    public function actionIndex($status = null)
    {


        return $this->render('/card/index', ['data' => $data, 'status' => $status]);
    }


}
