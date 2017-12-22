<?php

use yii\helpers\Html;
use yii\helpers\Url;

/**
 * @var string $subject
 * @var \amnah\yii2\user\models\User $user
 * @var \amnah\yii2\user\models\Profile $profile
 * @var \amnah\yii2\user\models\UserToken $userToken
 */
$formatter = new \yii\i18n\Formatter;
$formatter->datetimeFormat = 'php:d.m.Y H:i';
$formatter->timeZone = 'Europe/Moscow';
$date= $formatter->asDateTime("now");

?>

Оповещаем вас об успешной авторизации.
<br><br>

Логин: <?=Yii::$app->session['login']; ?>  <br>
IP: <?=\Yii::$app->getRequest()->getUserIP()?>  <br>
Дата и время: <?=$date;?> <br>