<?php
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $user common\models\User */

$resetLink = Yii::$app->urlManager->createAbsoluteUrl(['site/new-user', 'token' => $user->password_reset_token]);

if($user->status==10){
    $login=mb_substr($user->login,2);
}else{
$login=null;
}

?>
<div class="password-reset">




    <p> Уважаемый партнер!</p>


        Мы рады сообщить, что на Ваш электронный адрес (<?=$user->email?>) была зарегистрирована новая учётная запись контактного лица в Личном кабинете клиента  «Кардекс».</p>
 <br>
    <p>  1. Чтобы активировать Вашу учетную запись (получить доступ в Личный кабинет) и создать пароль, нажмите на ссылку активации, указанную ниже:</p>



    <p>  <?= Html::a(Html::encode($resetLink), $resetLink) ?></p>
    Обращаем внимание, что ссылка активна в течение 24 часов.


    <p>2. Для дальнейшего доступа в Личный кабинет клиента ООО «Кардекс» используйте следующие данные:</p>



    <p>Личный кабинет: <?= Yii::$app->urlManager->createAbsoluteUrl(['/'])?></p>


    <? if(isset($login)){?>
    <p>Логин: <b><?=$login?></p></b>
<?}?>


    <br><br>
    ЭТО ПИСЬМО СФОРМИРОВАНО АВТОМАТИЧЕСКИ. ПОЖАЛУЙСТА, НЕ ОТВЕЧАЙТЕ НА НЕГО. <br>
    Ответы на данное письмо будут направлены в почтовый ящик, который не проверяется.<br>
    Вся информация, изложенная в настоящем сообщении и (или) его приложениях, является конфиденциальной и предназначена только адресату.<br>
    Если Вы получили данное сообщение по ошибке, просим стереть его.<br>
    Незаконное разглашение, использование, распространение или объявление данного сообщения или отдельных его частей строго запрещено.<br>


</div>
