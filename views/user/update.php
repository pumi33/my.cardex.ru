<?php

/* @var $this yii\web\View */

use yii\helpers\Html;
use yii\helpers\Url;
use my\helper\Help;


$this->title                   = $user->full_name;
$this->params['breadcrumbs'][] = ['label' => 'Контактные лица', 'url' => ['/user']];
$this->params['breadcrumbs'][] = $this->title;


?>






<?= $this->render('_form', [
    'user'     => $user,
    'password' => $password,
]) ?>

