<?php

namespace my\controllers;

use my\models\Notifications;
use my\models\User;
use my\models\ChangePassword;
use my\models\ResetPasswordForm;
use yii\filters\AccessControl;
use my\helpers\Help;
use  my\components\MyController;
use yii\httpclient\Client;
use yii\helpers\Json;
use my\models\Dogovors;


class UserController extends MyController
{


    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                //  'only' => ['index'],


                'rules' => [
                    [
                        'actions' => ['notifications'],
                        'allow'   => true,
                        'roles'   => ['superadmin'],

                    ],

                    [
                        'actions' => ['create', 'delete'],
                        'allow'   => true,
                        'roles'   => ['superadmin', 'admin'],

                    ],


                    [
                        'actions' => ['index', 'update', 'i', 'update-password'],
                        'allow'   => true,
                        'roles'   => ['@'],
                    ],

                ],

            ],

        ];
    }


    public function actionIndex()
    {
        $users = User::getActiveUser();

        return $this->render('index', ['users' => $users]);
    }


    /**
     * @param $id
     *
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $user = User::getMyUser($id);


        if (!$user) {
            throw new \yii\web\NotFoundHttpException;
        }

        if ($user->load(\Yii::$app->request->post()) && $user->validate()) {
            \Yii::$app->session->setFlash('success', 'Контакт обновлен');
            $user->save();
        } else {
            Help::modelErrors($user->errors);
        }

        //$password=new ChangePassword();


        $password = new ChangePassword();


        return $this->render('update', compact(['user', 'password']));
    }


    /** Настройки уведомлений
     * @return mixed
     */
    public function actionNotificationsOLD()
    {
        $user         = User::getMyUser(\Yii::$app->user->identity->id);
        $notification = new Notifications();


        if ($notification->load(\Yii::$app->request->post()) && $notification->validate()) {
            //   $decode = Json::decode($user->notifications);


            $newmails = [];
            foreach (\Yii::$app->request->post()['mails'] as $mail) {

                if (trim($mail) != "") {
                    $newmails[] = $mail;
                }
            }

            $data['mails'] = implode(";", $newmails);


            $fd = [];
            for ($i = 1; $i < 8; $i++) {

                $week = "week" . $i;
                if (\Yii::$app->request->post()[$week]) {
                    $data[$week] = '01';
                    $fd[]        = 1;
                } else {
                    $data[$week] = '00';
                    $fd[]        = 0;
                }


            }


            if (\Yii::$app->request->post()['Notifications']['ostatkiReminder'] == 2) {
                $data['DogovorMailing'] = 1;
            }


            $dogovor_code = Dogovors::getMyCode();


            $senddata = ['dogovor_code' => $dogovor_code, 'mailreport' => $data['mails'], 'service' => implode(";", $fd), 'balance' => (int)\Yii::$app->request->post()['Notifications']['ostatkiReminder']];

            //print_r($senddata);


            $client   = new Client();
            $response = $client->createRequest()
                ->setMethod('get')
                ->setUrl(\Yii::$app->params['api-url'] . '/notification/set-all')
                ->setData($senddata)->send();


            if (!$response->isOk) {
                print "no";
                print_r($response->data);
                \Yii::warning('НЕ могу Записать настройки уведомлений');
            }


            $user->notifications = Json::encode($data);
            $user->save(false);


        }


        return $this->redirect(["/user/update/" . \Yii::$app->user->identity->id . "?notifications=1"]);

    }


    /** Изменить свой пароль
     *
     * @param $id
     *
     * @return mixed
     */
    public function actionUpdatePassword()
    {
        $user = User::getMyUser(\Yii::$app->user->identity->id); // выбрать себя

        $password = new ChangePassword();

        if ($password->load(\Yii::$app->request->post()) && $password->validate()) {


            //   $user->password=$password->newpass;
            $user->setPassword($password->newpass);
            $user->removePasswordResetToken();
            $user->save();
            \Yii::$app->session->setFlash('success', 'Новый пароль установлен');
        } else {
            //Error::write($model->errors);
            Help::modelErrors($password->errors);

            //$password->errors
        }


        return $this->redirect(["/user/update/" . \Yii::$app->user->identity->id . "?change-password=1"]);
    }


    public function actionDelete($id)
    {

        if (User::deletes($id)) {
            \Yii::$app->session->setFlash('success', 'Контакт удален');
        } else {
            \Yii::$app->session->setFlash('warning', 'Ошибка удаленения');
        }


        return $this->redirect(["/user/"]);

    }


    public function actionCreate()
    {
        $user        = new User;
        $user->login = \Yii::$app->security->generateRandomString();
        if ($user->load(\Yii::$app->request->post()) && $user->validate()) {


            $user->dogovor_guid = \Yii::$app->user->identity->dogovor_guid;


            if ($user->createNewUser()) {
                \Yii::$app->session->setFlash('success', 'Контакт создан');

                return $this->redirect(["/user/"]);
            } else {
                \Yii::$app->session->setFlash('error', 'Контакт не создан');
            }
        } else {
            Help::modelErrors($user->errors);
        }

        return $this->render('create', ['user' => $user]);
    }

    public function actionI()
    {
        $i = \Yii::$app->user->identity->id;

        return $this->redirect(["/user/update/", 'id' => $i]);
    }


}
