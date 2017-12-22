<?php

namespace my\controllers;


use my\models\Dogovors;
use yii\filters\AccessControl;
use yii\httpclient\Client;
use yii\helpers\Json;
use  my\components\MyController;
use  my\models\form\Cards;
use yii\helpers\Html;

class CardController extends MyController
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


    public function actionIndex($status = null)
    {

        if ($status == 'all') {
            return $this->redirect('/card/');
        }


        $client   = new Client();
        $response = $client->createRequest()
            ->setMethod('get')
            ->setUrl(\Yii::$app->params['api-url'] . '/cards/info/')
            ->setData(['dogovor' => \Yii::$app->user->identity->dogovor_guid])->send(); //,'status'=>$status

        //if($status and $status!="")
        //   $client ->setData(['status' => $status]);

        // $response=$client->send();

        if ($response->isOk) {
            $data = $response->data;

            //if($status==null)
            // \Yii::$app->session['countCard']=count($data);

        } else {
            //    throw new \yii\httpclient\Exception('не могу получить данные');
        }

        return $this->render('index', ['data' => $data, 'status' => $status]);
    }


    public function actionInfo(int $id)
    {


        if (\Yii::$app->request->post()['owner']) {

            \Yii::$app->session['card_' . $id] = (string)\Yii::$app->request->post()['owner'];


            $client2   = new Client();
            $response2 = $client2->createRequest()
                ->setMethod('get')
                ->setUrl(\Yii::$app->params['api-url'] . '/exchange/owner')
                ->setData(['dogovor_code' => Dogovors::getMyCode(), 'card' => $id, 'owner' => (string)trim(\Yii::$app->request->post()['owner'])])->send();


            return 1;

        }


        $this->layout = false;


        $client   = new Client();
        $response = $client->createRequest()
            ->setMethod('get')
            ->setUrl(\Yii::$app->params['api-url'] . '/cards/info/')
            ->setData(['dogovor' => \Yii::$app->user->identity->dogovor_guid, 'card' => $id])->send();


        if ($response->isOk) {
            $data = $response->data;
        } else {
            throw new \yii\httpclient\NotFoundHttpException('карта не найдена');
        }

        $card = new Cards();

        $own = 'card_' . $data[0]['code'];
        if (isset(\Yii::$app->session[$own])) {
            $card->owner = \Yii::$app->session[$own];
        } else {

            $card->owner = $data[0]['owner'];
        }


        return $this->render('card', ['data' => $data, 'card' => $card]);
    }


}
