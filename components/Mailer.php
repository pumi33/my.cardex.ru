<?php
/**
 * Created by PhpStorm.
 * User: DevAdmin
 * Date: 06.07.2017
 * Time: 11:26
 */

namespace my\components;


use my\models\LogMails;

class Mailer extends \yii\swiftmailer\Mailer
{



    public function send($message) {

        $log=new LogMails();
        $log->action=\Yii::$app->controller->id.'/'.\Yii::$app->controller->action->id;
        $log->to=key($message->getTo());
        $log->from=key($message->getFrom());
        $log->subject=$message->getSubject();
        $log->body=$message->toString();
        $log->user=\Yii::$app->session['login'];
        $log->save();

        return parent::send($message);;
    }


}