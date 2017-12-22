<?php

/* @var $this yii\web\View */
/* @var $name string */
/* @var $message string */
/* @var $exception Exception */

use yii\helpers\Html;


?>

<?php $this->beginContent('@app/views/layouts/main.php'); ?>
    <div class="site-error">

        <h1><?= Html::encode($this->title) ?></h1>

        <div class="alert alert-danger">
            <?= nl2br(Html::encode($message)) ?>
        </div>

<?=$content?>aaaaaaaaaaa

    </div>
<?php $this->endContent(); ?>