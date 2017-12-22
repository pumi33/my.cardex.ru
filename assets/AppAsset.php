<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace my\assets;

use yii\web\AssetBundle;

/**
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
       // '/css/site.css?i=1',
       // 'https://cdn.datatables.net/1.10.10/css/jquery.dataTables.css',
       // 'https://cdn.datatables.net/scroller/1.4.0/css/scroller.dataTables.css',
       // '/css/check.css',
        'https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css'

        //'https://yastatic.net/bootstrap/3.3.4/css/bootstrap.min.css'
    ];
    public $js = [

        //"https://yastatic.net/bootstrap/3.3.4/js/bootstrap.min.js",
      //  "https://cdn.datatables.net/1.10.10/js/jquery.dataTables.js",
      //  "https://cdn.datatables.net/scroller/1.4.0/js/dataTables.scroller.js",
      //  "https://cdn.datatables.net/fixedcolumns/3.2.0/js/dataTables.fixedColumns.min.js",

        '/js/app.js'
       // 'web/js/material.min.js'
    ];

/*
    public $jsOption = [
        //'position' => \yii\web\View::POS_END
        'position' => \yii\web\View::POS_HEAD
    ];
*/

    public $jsOptions = ['position' => \yii\web\View::POS_HEAD];

    public $depends = [
        'yii\web\YiiAsset',
      //  'yii\bootstrap\BootstrapAsset',
    ];
}
