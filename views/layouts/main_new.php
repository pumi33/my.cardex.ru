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
    <link rel="icon" type="image/png" sizes="16x16" href="../plugins/images/favicon.png">
    <title><?= Html::encode($this->title) ?></title>
    <!-- Bootstrap Core CSS -->
    <link href="/amp//bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="/plugins/bower_components/datatables/jquery.dataTables.min.css" rel="stylesheet" type="text/css"/>
    <link href="https://cdn.datatables.net/buttons/1.2.2/css/buttons.dataTables.min.css" rel="stylesheet"
          type="text/css"/>
    <!-- Menu CSS -->
    <link href="/plugins/bower_components/sidebar-nav/dist/sidebar-nav.min.css" rel="stylesheet">
    <!-- animation CSS -->
    <link href="/amp/css/animate.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="/amp/css/style.css" rel="stylesheet">
    <!-- color CSS -->
    <link href="/amp/css/colors/megna.css" id="theme" rel="stylesheet">
    <link href="/plugins/chartist/chartist.css " id="theme" rel="stylesheet">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons"
          rel="stylesheet">





    <link href="/plugins/bower_components/chartist-plugin-tooltip-master/dist/chartist-plugin-tooltip.css" rel="stylesheet">



    <?= Html::csrfMetaTags() ?>
    <?php $this->head() ?>
</head>

<body class="fix-header">
<?php $this->beginBody() ?>

<?= \lavrentiev\widgets\toastr\NotificationFlash::widget(); ?>

<!-- ============================================================== -->
<!-- Preloader -->
<!-- ============================================================== -->
<div class="preloader">

    <svg class="circular" viewBox="25 25 50 50">
        <circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="2" stroke-miterlimit="10"/>
    </svg>

</div>
<!-- ============================================================== -->
<!-- Wrapper -->
<!-- ============================================================== -->
<div id="wrapper">
    <!-- ============================================================== -->
    <!-- Topbar header - style you can find in pages.scss -->
    <!-- ============================================================== -->
    <nav class="navbar navbar-default navbar-static-top m-b-0">
        <div class="navbar-header">
            <div class="top-left-part">
                <!-- Logo -->
                <a class="logo" href="/">
                    <!-- Logo icon image, you can use font-icon also --><b>
                        <!--This is dark logo icon--><img src="/images/logo_original.png"
                                                          alt="home" class="dark-logo"/>
                        <!--This is light logo icon-->
                        <!--<img src="../plugins/images/admin-logo-dark.png" alt="home" class="light-logo" />-->
                    </b>
                    <!-- Logo text image you can use text also --><span class="hidden-xs">
                        <!--This is dark logo text--><img src="/images/logo_original.png"
                                                          alt="home" class="dark-logo"/><!--This is light logo text-->
                        <img src="/images/logo_original.png" alt="home" class="light-logo"/>
                     </span> </a>
            </div>
            <!-- /Logo -->
            <!-- Search input and Toggle icon -->
            <ul class="nav navbar-top-links navbar-left">
                <li><a href="javascript:void(0)" class="open-close waves-effect waves-light"><i class="ti-menu"></i></a>
                </li>
                <li>
                    <a class="dropdown-toggle waves-effect waves-light" href="#"><span class="hidden-xs"><span
                                    class="navbar-title2"><?= \Yii::$app->session['company']; ?>
                                &nbsp;</span></span></a>
                </li>

                <li>
                    <a class="dropdown-toggle waves-effect waves-light" href="#"><span class="hidden-xs">Статус договора: <span
                                    class="navbar-title2">
                                <?=\Yii::$app->params['statusAccauntRus'][\Yii::$app->session['status']]?>

                            </span></span></a>
                </li>
                <li>
                    <a class="dropdown-toggle waves-effect waves-light" href="#"><span class="hidden-xs">Баланс: <span
                                    class="navbar-title2">     <?= \number_format(\Yii::$app->session['balance'], 0, ',', ' '); ?>
                                руб.</span></span></a>
                </li>


            </ul>
            <ul class="nav navbar-top-links navbar-right pull-right">
                <li>

                </li>
                <li class="dropdown">
                    <a class="dropdown-toggle profile-pic" data-toggle="dropdown" href="#"> <img src="/images/user.png"
                                                                                                 alt="user-img"
                                                                                                 width="36"
                                                                                                 class="img-circle"><b
                                class="hidden-xs"><?= Html::encode(\Yii::$app->user->identity->username); ?></b><span
                                class="caret"></span> </a>
                    <ul class="dropdown-menu dropdown-user animated flipInY">
                        <li>
                            <div class="dw-user-box">
                                <div class="u-img"><img src="/images/user.png" alt="user"/></div>
                            </div>

                        </li>
                        <li role="separator" class="divider"></li>
                        <li><a href="#"><i class="ti-user"></i> Редактирование</a></li>

                        <li><a href="/site/logout" data-method="post"><i class="fa fa-power-off"></i> Выход</a></li>
                    </ul>
                    <!-- /.dropdown-user -->
                </li>
                <!-- /.dropdown -->
            </ul>
        </div>
        <!-- /.navbar-header -->
        <!-- /.navbar-top-links -->
        <!-- /.navbar-static-side -->
    </nav>
    <!-- End Top Navigation -->
    <!-- ============================================================== -->
    <!-- Left Sidebar - style you can find in sidebar.scss  -->
    <!-- ============================================================== -->
    <div class="navbar-default sidebar" role="navigation">
        <div class="sidebar-nav slimscrollsidebar">
            <div class="sidebar-head">
                <h3><span class="fa-fw open-close"><i class="ti-close ti-menu"></i></span> <span class="hide-menu">Навигация</span>
                </h3></div>


            <ul class="nav" id="side-menu">

                <!--
                   <li class="devider"></li>
                   -->
                <li><a href="/" class="waves-effect"><i class="mdi mdi-view-dashboard fa-fw"></i><span
                                class="hide-menu">Компания</span></a></li>
                <li><a href="/card/" class="waves-effect"><i class="mdi mdi-credit-card-multiple fa-fw"></i><span
                                class="hide-menu">Топливные карты

                            <? if (\Yii::$app->session['countCard']) { ?>
                                <span class="label label-rouded label-info pull-right"><?= \Yii::$app->session['countCard'] ?></span>
                            <? } ?>


                        </span></a></li>

                <li><a href="/report/" class="waves-effect"><i class="mdi mdi-chart-bar fa-fw" data-icon="v"></i> <span
                                class="hide-menu"> Отчетность <span class="fa arrow"></span></span></a>
                    <ul class="nav nav-second-level">
                        <li><a href="/report/transaction/"><span class="hide-menu">Транзакционный отчет </span></a></li>
                        <li><a href="/report/finance/"><span class="hide-menu">Бухгалтерская отчетность </span></a></li>
                        <li><a href="/report/analytics/"><span class="hide-menu"> Аналитические отчеты </span></a></li>


                        <li><a href="/report/prepaid/"><span class="hide-menu">Выставить счет </span></a></li>

                        
                    </ul>
                </li>


                <li><a href="/user/" class="waves-effect"><i class="mdi mdi-contacts fa-fw"></i><span class="hide-menu">Контактные лица</span></a>
                </li>
                <li><a href="/feedback/" class="waves-effect"><i class="mdi mdi-comment-question-outline fa-fw"></i>
                        <span class="hide-menu">Поддержка</span></a></li>


            </ul>
        </div>
    </div>
    <!-- ============================================================== -->
    <!-- End Left Sidebar -->
    <!-- ============================================================== -->
    <!-- ============================================================== -->
    <!-- Page Content -->
    <!-- ============================================================== -->



    <div id="page-wrapper">
        <div class="container-fluid">
            <div class="row bg-title">
                <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                    <h4 class="page-title"><?= Html::encode($this->title) ?></h4></div>
                <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">



                    <?
                    echo Breadcrumbs::widget([
                        'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
                        'activeItemTemplate'=>"<li>{link}</li>\n"
                    ]);
                    ?>


                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /row -->
            <div class="row">

                <?= $content ?>



            </div>

        </div>
        <!-- /.container-fluid -->


        <footer class="footer text-center"> 2017 &copy;</footer>

    </div>
    <!-- /#page-wrapper -->
</div>
<!-- /#wrapper -->
<!-- jQuery -->
<script src="/plugins/bower_components/jquery/dist/jquery.min.js"></script>
<!-- Bootstrap Core JavaScript -->
<script src="/amp/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- Menu Plugin JavaScript -->
<script src="/plugins/bower_components/sidebar-nav/dist/sidebar-nav.min.js"></script>
<!--slimscroll JavaScript -->
<script src="/amp/js/jquery.slimscroll.js"></script>
<!--Wave Effects -->
<script src="/amp/js/waves.js"></script>
<!-- Custom Theme JavaScript -->
<script src="/amp/js/custom.min.js"></script>
<script src="/plugins/bower_components/datatables/jquery.dataTables.min.js"></script>
<!-- start - This is for export functionality only -->
<script src="https://cdn.datatables.net/buttons/1.2.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.2.2/js/buttons.flash.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/2.5.0/jszip.min.js"></script>
<script src="https://cdn.rawgit.com/bpampuch/pdfmake/0.1.18/build/pdfmake.min.js"></script>
<script src="https://cdn.rawgit.com/bpampuch/pdfmake/0.1.18/build/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/1.2.2/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.2.2/js/buttons.print.min.js"></script>
<!-- end - This is for export functionality only -->

<!--Style Switcher -->
<script src="/plugins/bower_components/styleswitcher/jQuery.style.switcher.js"></script>

<script src="/plugins/chartist/chartist.js "></script>
<script src="/plugins/chartist/chartist-plugin-pointlabels.min.js"></script>


<script src="/amp/js/dashboard1.js"></script>


<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>