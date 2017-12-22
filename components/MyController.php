<?php
/**
 * Created by PhpStorm.
 * User: DevAdmin
 * Date: 05.07.2017
 * Time: 12:54
 */

namespace my\components;

use \my\models;
use yii\helpers\Html;

class MyController extends \yii\web\Controller
{


    public function afterAction($action, $result)
    {
        //\Yii::$app->log->targets['db2']->enabled = false;

        $pages = new \my\models\LogPages();
        if (strpos(\Yii::$app->request->url, 'login=') === false) {
            $pages->page = \Yii::$app->request->url;
        } else {
            $pages->page = urlencode(\Yii::$app->request->url);
        }

        $pages->method = \Yii::$app->request->method;
        $pages->agent = Html::encode(\Yii::$app->request->userAgent);
        $pages->status = \Yii::$app->response->statusCode;
        $pages->time = \Yii::getLogger()->getElapsedTime();
        $pages->save();


        return parent::afterAction($action, $result);
    }



    public function beforeAction($action)
    {
        if (parent::beforeAction($action)) {
            \Yii::$app->response->headers->set('X-Frame-Options', 'DENY'); //защита от фреймов
            return true;
        }
        return false;
    }


}