<?php

namespace my\controllers;

use my\components\MyController;
use my\models\ImportAll;
use Yii;
use yii\helpers\ArrayHelper;
use yii\helpers\VarDumper;
use yii\httpclient\Client;
use yii\rbac\PhpManager;
use yii\web\Controller;

/**
 * Copy user module to your app/modules folder
 */
class CronController extends MyController

{

    public function actionAll()
    {

        $importAll = new ImportAll();
        $importAll->import();

    }


    public function actionOne($code)
    {

        $importAll = new ImportAll();
        $importAll->importOne($code);

    }


    public function actionTest()
    {

        //  $user=User::findUserByEmail('07-K/6-4181111');

        $client   = new Client();
        $response = $client->createRequest()
            ->setMethod('get')
            ->setUrl(\Yii::$app->params['api-url'] . '/dogovors/transaction/')
            ->setData(['dogovor' => \Yii::$app->user->identity->dogovor_guid])
            ->send();
        if ($response->isOk) {
            $data = $response->data;
        }
    }


    public function actionRbac()
    {
        $auth = \Yii::$app->authManager;
        $auth->removeAll(); //удаляем старые данные
        //Создадим для примера права для доступа к админке
        $dashboard              = $auth->createPermission('dashboard');
        $dashboard->description = 'Админ панель';
        $auth->add($dashboard);
        //Включаем наш обработчик
        $rule = new \my\components\rbac\UserRule();
        $auth->add($rule);
        //Добавляем роли
        $user              = $auth->createRole('user');
        $user->description = 'Пользователь';
        $user->ruleName    = $rule->name;
        $auth->add($user);
        $moder              = $auth->createRole('admin');
        $moder->description = 'Администратор';
        $moder->ruleName    = $rule->name;
        $auth->add($moder);
        //Добавляем потомков
        $auth->addChild($moder, $user);
        $auth->addChild($moder, $dashboard);
        $admin              = $auth->createRole('superadmin');
        $admin->description = 'СуперАдминистратор';
        $admin->ruleName    = $rule->name;
        $auth->add($admin);
        $auth->addChild($admin, $moder);


        $createManager              = $auth->createPermission('createManager');
        $createManager->description = 'Создание менеджеров';
        $auth->add($createManager);
        $auth->addChild($admin, $createManager);


        $changeStatus              = $auth->createPermission('changeStatus');
        $changeStatus->description = 'Смена статуса';
        $auth->add($changeStatus);
        $auth->addChild($admin, $changeStatus);

        $edits              = $auth->createPermission('edits');
        $edits->description = 'Редактирование';
        $auth->add($edits);
        $auth->addChild($moder, $edits);

        return "ok";


    }


}





