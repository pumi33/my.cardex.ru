<?php

use yii\helpers\Html;


$this->title                   = 'Добавление';
$this->params['breadcrumbs'][] = ['label' => 'Контактные лица', 'url' => ['/user']];
$this->params['breadcrumbs'][] = $this->title;

?>




<?= $this->render('_form', [
    'user' => $user,
]) ?>
