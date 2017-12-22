<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use my\assets\AppAsset;
use common\widgets\Alert;
use  my\helpers\Help;
use my\models\User;
use lo\modules\noty\Wrapper;


AppAsset::register($this);
?>
<?php $this->beginPage() ?>
    <!DOCTYPE html>
    <html lang="ru">

    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="">
        <meta name="author" content="">
        <meta charset="<?= Yii::$app->charset ?>">

        <title><?= Html::encode($this->title) ?></title>
        <!-- Bootstrap Core CSS -->
        <link href="/amp//bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
        <link href="/plugins/bower_components/datatables/jquery.dataTables.min.css" rel="stylesheet" type="text/css"/>
        <link href="/css/buttons.dataTables.min.css" rel="stylesheet"
              type="text/css"/>
        <!-- Menu CSS -->
        <link href="/plugins/bower_components/sidebar-nav/dist/sidebar-nav.min.css" rel="stylesheet">
        <!-- animation CSS -->
        <link href="/amp/css/animate.css" rel="stylesheet">
        <!-- Custom CSS -->
        <link href="/amp/css/style.css" rel="stylesheet">
        <!-- color CSS -->
        <link href="/amp/css/colors/megna.css" id="theme" rel="stylesheet">
        <link href="/plugins/chartist/chartist.css" id="theme" rel="stylesheet">


        <link href="https://fonts.googleapis.com/icon?family=Material+Icons"
              rel="stylesheet">

        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
        <![endif]-->




        <?= Html::csrfMetaTags() ?>
        <?php $this->head() ?>
    </head>

    <body class="fix-header">



    <?php $this->beginBody() ?>

    <?/*
\lavrentiev\widgets\toastr\NotificationFlash::widget([
    'type' => 'error',
    'title' => 'Toast Notifications',
    'message' => 'Simple javascript toast notifications',
    'options' => [
        "closeButton" => false,
        "debug" => false,
        "newestOnTop" => false,
        "progressBar" => false,
        "positionClass" => "toast-top-center",
        "preventDuplicates" => false,
        "onclick" => null,
        "showDuration" => "300",
        "hideDuration" => "1000",
        "timeOut" => "10000",
        "extendedTimeOut" => "1000",
        "showEasing" => "swing",
        "hideEasing" => "linear",
        "showMethod" => "fadeIn",
        "hideMethod" => "fadeOut"
    ]
]);



*/
    ?>




    <div>

        <?= $content ?>




    </div>










    <!-- /#wrapper -->
    <!-- jQuery -->
    <script src="/plugins/bower_components/jquery/dist/jquery.min.js"></script>
    <!-- Bootstrap Core JavaScript -->
    <script src="/amp/bootstrap/dist/js/bootstrap.min.js"></script>
    <!-- Menu Plugin JavaScript -->

    <script src="/plugins/bower_components/datatables/jquery.dataTables.min.js"></script>
    <!-- start - This is for export functionality only -->

    <script src="https://cdn.datatables.net/buttons/1.2.2/js/dataTables.buttons.min.js"></script>


    <script src="https://cdn.datatables.net/buttons/1.2.2/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.2.2/js/buttons.print.min.js"></script>
    <!-- end - This is for export functionality only -->










    <?php $this->endBody() ?>



    </body>
    </html>
<?php $this->endPage() ?>