<?php
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $user common\models\User */

$resetLink = Yii::$app->urlManager->createAbsoluteUrl(['site/reset-password', 'token' => $user->password_reset_token]);
?>
<div class="password-reset">




    <p>Вы получили это письмо, потому что создали запрос на изменение пароля.</p>

    <p>Чтобы создать новый пароль доступа к личному кабинету, нажмите на следующую ссылку:</p>

    <p> <?= Html::a(Html::encode($resetLink), $resetLink) ?></p>


    <br>
    <p>Если вы получили данное письмо по ошибке, игнорируйте его.</p>

</div>
