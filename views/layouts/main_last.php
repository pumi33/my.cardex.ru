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


AppAsset::register($this);
?>
<?php $this->beginPage() ?>
    <!DOCTYPE html>
    <html>
    <head>
        <title><?= Html::encode($this->title) ?></title>
        <meta charset="<?= Yii::$app->charset ?>">

        <meta name="viewport" content="width=device-width, initial-scale=1">

        <link rel="stylesheet" type="text/css" href="/css/vendor.css">
        <link rel="stylesheet" type="text/css" href="/css/flat-admin.css">

        <!-- Theme -->

        <link rel="stylesheet" type="text/css" href="/css/red.css">
        <link rel="stylesheet" type="text/css" href="/css/yellow.css">
        <?= Html::csrfMetaTags() ?>
        <?php $this->head() ?>
    </head>
    <body>

    <?= \lavrentiev\widgets\toastr\NotificationFlash::widget(); ?>


    <div class="app app-red">

        <aside class="app-sidebar" id="sidebar">
            <div class="sidebar-header">
                <a class="sidebar-brand" href="/"><span class="highlight">КАРДЕКС</span> </a>
                <button type="button" class="sidebar-toggle">
                    <i class="fa fa-times"></i>
                </button>
            </div>
            <div class="sidebar-menu">


                <ul class="sidebar-nav">


                    <li class="<?= Help::menu('') ?>">
                        <a href="/">
                            <div class="icon">
                                <i class="fa fa-tasks" aria-hidden="true"></i>
                            </div>
                            <div class="title">Компания</div>
                        </a>
                    </li>
                    <li class="<?= Help::menu('card/') ?>">
                        <a href="/card/">
                            <div class="icon">
                                <i class="fa fa-credit-card-alt" aria-hidden="true"></i>
                            </div>
                            <div class="title">Топливные карты</div>
                        </a>
                    </li>
                    <li class="dropdown <?= Help::menu('report/') ?>">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <div class="icon">
                                <i class="fa fa-bar-chart" aria-hidden="true"></i>
                            </div>
                            <div class="title">Отчетность</div>
                        </a>
                        <div class="dropdown-menu">
                            <ul>
                                <!--<li class="section"><i class="fa fa-file-o" aria-hidden="true"></i> Выставить счет</li>-->

                                <li><a href="/report/transaction/">Транзакционный отчет </a></li>
                                <li><a href="/report/finance/">Бухгалтерская отчетность </a></li>
                            </ul>
                        </div>
                    </li>


                    <li class="<?= Help::menu('user/') ?>">
                        <a href="/user/">
                            <div class="icon">
                                <i class="fa fa-users" aria-hidden="true"></i>
                            </div>
                            <div class="title">Контактые лица</div>
                        </a>
                    </li>

                    <li class=<?= Help::menu('feedback/') ?>">
                        <a href="/feedback/">
                    <div class="icon">
                        <i class="fa fa-question-circle " aria-hidden="true"></i>
                    </div>
                    <div class="title">Поддержка</div>
                    </a>
                    </li>
                </ul>


            </div>
            <div class="sidebar-footer">
                <ul class="menu">
                    <li>
                        <a href="/" class="dropdown-toggle" data-toggle="dropdown">
                            <i class="fa fa-cogs" aria-hidden="true"></i>
                        </a>
                    </li>
                    <li><a href="#"><span class="flag-icon  flag-icon-squared"></span></a></li>
                </ul>
            </div>
        </aside>


        <script type="text/ng-template" id="sidebar-dropdown.tpl.html">
            <div class="dropdown-background">
                <div class="bg"></div>
            </div>
            <div class="dropdown-container">
                {{list}}
            </div>
        </script>


        <div class="app-container">

            <nav class="navbar navbar-default" id="navbar">
                <div class="container-fluid">
                    <div class="navbar-collapse collapse in">
                        <ul class="nav navbar-nav navbar-mobile">
                            <li>
                                <button type="button" class="sidebar-toggle">
                                    <i class="fa fa-bars"></i>
                                </button>
                            </li>
                            <li class="logo">
                                <a class="navbar-brand" href="#"><span class="highlight">Кардекс</a>
                            </li>
                            <li>
                                <button type="button" class="navbar-toggle">
                                    <img class="profile-img" src="/images/profile.png">
                                </button>
                            </li>
                        </ul>
                        <ul class="nav navbar-nav navbar-left">
                            <li class="navbar-title"><span
                                        class="highlight"><?= \Yii::$app->session['company']; ?></span>
                                &nbsp; <?= \Yii::$app->session['dogovor']; ?><span> </span></li>

                            <!--<li class="navbar-search hidden-sm">
                                <input id="search" type="text" placeholder="Search..">
                                <button class="btn-search"><i class="fa fa-search"></i></button>
                            </li>
                            -->

                            <li class="navbar-search hidden-sm">

                                <div class="row">
                                    <div class="col-md-6">
                                        <nobr> Статус</nobr>
                                        <br>
                                        <span class="navbar-title2"> <?= \Yii::$app->params['statusAccauntRus'] ?> </span>
                                    </div>

                                    <div class="col-md-6">Баланс <br>
                                        <span class="navbar-title2"> <nobr><?= \number_format(\Yii::$app->session['balance'], 2, ',', ' '); ?> </span>руб.</nobr>
                                    </div>


                                </div>

                            </li>
                        </ul>
                        <ul class="nav navbar-nav navbar-right">


                            <li class="dropdown profile">
                                <a href="/html/pages/profile.html" class="dropdown-toggle" data-toggle="dropdown">

                                    <i class="fa fa-user" aria-hidden="true" style="font-size:40px"></i>

                                    <div class="title">Profile</div>
                                </a>
                                <div class="dropdown-menu">
                                    <div class="profile-info">
                                        <h4 class="username"><?= Html::encode(\Yii::$app->user->identity->username); ?></h4>
                                    </div>
                                    <ul class="action">
                                        <li>
                                            <a href="/user/i" data-method="post">
                                                Профиль
                                            </a>
                                        </li>
                                        <li>
                                            <a href="/site/logout" data-method="post">
                                                Выход
                                            </a>
                                        </li>

                                    </ul>
                                </div>
                            </li>


                        </ul>
                    </div>
                </div>
            </nav>


            <?= $content ?>


        </div>

    </div>

    <script type="text/javascript" src="/js/vendor.js"></script>
    <script type="text/javascript" src="/js/app.js"></script>

    <?php $this->endBody() ?>
    </body>
    </html>
<?php $this->endPage() ?>