<?php

/* @var $this \yii\web\View */

/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use my\assets\AppAsset;
use common\widgets\Alert;

AppAsset::register($this);
$this->beginPage();
?>
    <!DOCTYPE html>
    <html lang="ru">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="">
        <meta name="author" content="">
        <meta name="robots" content="none"/>
        <title><?= Html::encode($this->title) ?></title>
        <!-- Bootstrap Core CSS -->
        <link href="/amp/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
        <!-- animation CSS -->
        <link href="/amp/css/animate.css" rel="stylesheet">
        <!-- Custom CSS -->
        <link href="/amp/css/style.css" rel="stylesheet">
        <!-- color CSS -->
        <link href="/amp/css/colors/megna.css" id="theme" rel="stylesheet">
        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
        <![endif]-->

        <?= Html::csrfMetaTags() ?>
        <?php $this->head() ?>
    </head>
    <body>
    <?php $this->beginBody() ?>
    <?
    \lavrentiev\widgets\toastr\NotificationFlash::widget([
        'type'    => 'error',
        'title'   => 'Toast Notifications',
        'message' => 'Simple javascript toast notifications',
        'options' => [
            "closeButton"       => false,
            "debug"             => false,
            "newestOnTop"       => false,
            "progressBar"       => false,
            "preventDuplicates" => false,
            "onclick"           => null,
            "showDuration"      => "300",
            "hideDuration"      => "1000",
            "timeOut"           => "10000",
            "extendedTimeOut"   => "1000",
            "showEasing"        => "swing",
            "hideEasing"        => "linear",
            "showMethod"        => "fadeIn",
            "hideMethod"        => "fadeOut",
        ],
    ]);

    ?>


    <!-- Preloader -->
    <div class="preloader">
        <div class="cssload-speeding-wheel"></div>
    </div>
    <section id="wrapper" class="new-login-register">
        <div class="lg-info-panel">
            <div class="inner-panel">
                <a href="javascript:void(0)" class="p-20 di"><img src="/images/logo_original.png"></a>
                <div class="lg-content">
                    <h2>Универсальные Топливные Карты КАРДЕКС + Топливные Карты ЛУКОЙЛ.</h2>
                    <p class="text-muted"></p>
                    <a href="http://card-oil.ru/nachat_zapravljatsja/" class="btn btn-rounded btn-danger p-l-20 p-r-20" target="_blank"> Стать клиентом</a>
                </div>
            </div>
        </div>

        <?= $content ?>


    </section>


    <!-- Yandex.Metrika MY counter -->
    <script type="text/javascript">
      (function (d, w, c) {
        (w[c] = w[c] || []).push(function () {
          try {
            w.yaCounter23133127 = new Ya.Metrika({
              id: 23133127,
              webvisor: false,
              clickmap: true,
              trackLinks: true,
              accurateTrackBounce: true,
              ut: "noindex"

            });
          } catch (e) {
          }
        });

        var n = d.getElementsByTagName("script")[0],
          s = d.createElement("script"),
          f = function () {
            n.parentNode.insertBefore(s, n);
          };
        s.type = "text/javascript";
        s.async = true;
        s.src = "https://mc.yandex.ru/metrika/watch.js";

        if (w.opera == "[object Opera]") {
          d.addEventListener("DOMContentLoaded", f, false);
        } else {
          f();
        }
      })(document, window, "yandex_metrika_callbacks");
    </script>
    <noscript>
        <div><img src="//mc.yandex.ru/watch/23133127?ut=noindex" style="position:absolute; left:-9999px;" alt=""/></div>
    </noscript>
    <!-- /Yandex.Metrika MY counter -->


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
    <!--Style Switcher -->
    <script src="/plugins/bower_components/styleswitcher/jQuery.style.switcher.js"></script>


    <?php $this->endBody() ?>
    </body>
    </html>
<?php $this->endPage();