<?php


$params = array_merge(
    require(__DIR__ . '/../../yii/common/config/params.php'),
    require(__DIR__ . '/../../yii/common/config/params-local.php'),
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php')
);


return [
    'id'                  => 'my',
    'basePath'            => dirname(__DIR__),
    // 'vendorPath' => dirname(dirname(__DIR__)) . '../../yii/advanced/vendor',
    'bootstrap'           => ['log', 'debug'],
    'controllerNamespace' => 'my\controllers',


    'timeZone' => 'GMT+5',

    'components' => [

        'urlManager' => [
            'class'    => 'yii\web\UrlManager',
            'hostInfo' => 'https://my.card-oil.ru',
        ],


        'request' => [
            'csrfParam'           => '_csrf-my',
            'cookieValidationKey' => 'bUfjjxxxxfYGFL:"L046',
            //'baseUsrl' => 'https://my.card-oil.ru',
        ],
        'cache'   => [
            'class'     => 'yii\caching\FileCache',
            'keyPrefix' => 'my',       // a unique cache key prefix
        ],


        'formatter' => [
            'class'          => 'yii\i18n\Formatter',
            'dateFormat'     => 'php:d.m.Y',
            'datetimeFormat' => 'php:d.m.Y H:i:s',
            'timeFormat'     => 'php:H::i',
            'locale'         => 'ru-RU',
            'timeZone'       => 'Europe/Moscow',

        ],

        'session' => [
            // this is the name of the session cookie used for login on the frontend
            'name' => 'my',
        ],


        'log' => [
            'targets' => [

                'db'  => [
                    'class'      => 'yii\log\DbTarget',
                    'levels'     => ['error', 'warning'],
                    'logVars'    => ['_SESSION', '_GET', '_POST', '_SERVER'],
                    'categories' => ['yii\db\*', 'yii\base\*', 'yii\web\HttpException:500', 'application', 'yii\log\Dispatcher\*'],
                    'logTable'   => 'log_errors',
                    'db'         => 'db_log',
                    'prefix'     => function ($message) {
                        $user   = Yii::$app->has('user', true) ? Yii::$app->get('user') : null;
                        $userID = $user ? $user->getId(false) : '-';

                        return "[$userID] [" . \Yii::$app->session['dogovor'] . "] [" . \Yii::$app->getRequest()->getUserIP() . "]";
                    },

                ],
                'db2' => [
                    'class'      => '\my\components\CustomDbTarget',
                    'levels'     => ['profile'],
                    //'logVars' => ['_SESSION', '_GET', '_POST', '_SERVER'],
                    'categories' => ['yii\db\Command::execute'],
                    'logTable'   => 'log_db',
                    'db'         => 'db_log',

                    'prefix' => function ($message) {
                        $user   = Yii::$app->has('user', true) ? Yii::$app->get('user') : null;
                        $userID = $user ? $user->getId(false) : '-';

                        return "[$userID] [" . \Yii::$app->session['dogovor'] . "] [" . \Yii::$app->getRequest()->getUserIP() . "]";
                    },

                ],


                'file'  => [
                    'class'      => 'yii\log\FileTarget',
                    'categories' => ['yii\db\*', 'yii\base\*', 'yii\web\HttpException:500', 'application', 'yii\log\Dispatcher\*'],
                    'levels'     => ['error', 'warning'],
                    'logFile'    => '@runtime/logs/Error.log',
                    //  'logFile' => '@app/itmathrepetitor.txt',


                ],
                'email' => [
                    'class'      => 'yii\log\EmailTarget',
                    'categories' => ['yii\db\*', 'yii\base\*', 'yii\web\HttpException:500', 'application', 'yii\log\Dispatcher\*'],
                    'levels'     => ['error', 'warning'],
                    'message'    => ['to' => '', 'subject' => 'Error Cardex',],
                    'mailer'     => 'mailCardex',
                    'logVars'    => ['_SESSION', '_GET', '_POST', '_SERVER'],
                    //    'mailer' =>'mail',
                ],


            ],
        ],


        'mail' => [
            'class'         => 'yii\swiftmailer\Mailer',
            'transport'     => [
                'class'      => 'Swift_SmtpTransport',
                'host'       => '',
                'username'   => '',
                'password'   => '',
                'port'       => '',
                'encryption' => 'ssl',
            ],
            'messageConfig' => [
                'charset' => 'UTF-8',
                'from'    => ['mail@spharma.ru' => 'ООО "СоюзФарма-ТМ'],
            ],
        ],


        'mailCardex' => [
            'class'            => '\my\components\Mailer',
            'useFileTransport' => false,
            'transport'        => [
                'class' => 'Swift_SmtpTransport',
                'host'  => '192.168.50.5',
                // 'username' => 'noreply@card-oil.ru', //mail@spharma.ru
                // 'password' => 'mail123', //mail352
                'port'  => '25',
                //  'encryption' => 'tsl',
            ],
            'messageConfig'    => [
                'charset' => 'UTF-8',
                'from'    => ['noreply@card-oil.ru' => 'КАРДЕКС'],
                'to'      => '',
            ],
        ],

        'mailCardex2' => [
            'class'            => '\my\components\Mailer',
            'useFileTransport' => false,
            'transport'        => [
                'class' => 'Swift_SmtpTransport',
                'host'  => '',
                // 'username' => 'noreply@card-oil.ru', //mail@spharma.ru
                // 'password' => 'mail123', //mail352
                'port'  => '25',
                //  'encryption' => 'tsl',
            ],
            'messageConfig'    => [
                'charset' => 'UTF-8',
                'from'    => ['noreply@card-oil.ru' => 'КАРДЕКС'],
                'to'      => '',
            ],
        ],


        'user' => [
            'identityClass' => 'my\models\User',
        ],


        'db'     => require(__DIR__ . '/db.php'),
        'db_log' => require(__DIR__ . '/db-log.php'),
        //  'db2' => require(__DIR__ . '/db2.php'),


        'i18n' => [
            'translations' => [
                '*' => [
                    'class'          => 'yii\i18n\PhpMessageSource',
                    'basePath'       => '@app/messages', // if advanced application, set @frontend/messages
                    'sourceLanguage' => 'en-US',
                    'fileMap'        => [
                        'main' => 'main.php',
                    ],
                ],
            ],
        ],

        'authManager' => [
            'class'          => 'yii\rbac\PhpManager',
            'defaultRoles'   => ['user', 'admin', 'superadmin'],
            'itemFile'       => '@my/components/rbac/items.php',
            'assignmentFile' => '@my/components/rbac/assignments.php',
            'ruleFile'       => '@my/components/rbac/rules.php',
        ],


    ],
    'params'     => $params,

    'modules' => [
        'debug' => [
            'class'      => 'yii\\debug\\Module',
            'allowedIPs' => ['178.132.200.2142'],
            'panels'     => [
                'httpclient' => [
                    'class' => 'yii\\httpclient\\debug\\HttpClientPanel',
                ],
            ],
        ],
        'noty'  => [
            'class' => 'lo\modules\noty\Module',
        ],

    ],


];
