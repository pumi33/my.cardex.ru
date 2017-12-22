<?php
use yii\helpers\Html;
$link=\Yii::$app->urlManager->createAbsoluteUrl(['/']);
/* @var $this \yii\web\View view component instance */
/* @var $message \yii\mail\MessageInterface the message being composed */
/* @var $content string main view render result */
?>
<?php $this->beginPage() ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
    <?php $this->beginBody() ?>



    <?= $content ?>

    <br><br>
    ----------------------

    <p>Если у Вас возникли вопросы, Вы можете обратиться в службу поддержки Клиентов:</p>
   <p> тел.: <?=\Yii::$app->params['phone'];?></p>
   <p> e-mail:<?=\Yii::$app->params['infoEmail'];?></p>

    <p><?= Html::a(Html::encode($link), $link) ?></p>


    <?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
