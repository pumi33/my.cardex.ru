<?php

namespace my\models;

use yii\base\Model;
use yii\base\InvalidParamException;
use my\models\User;

/**
 * Password reset form
 */
class NewLoginPassword extends Model
{
    public $login;
    public $password;
    public $repeatnewpass;

    /**
     * @var \common\models\User
     */
    public $_user;


    /**
     * Creates a form model given a token.
     *
     * @param string $token
     * @param array  $config name-value pairs that will be used to initialize the object properties
     *
     * @throws \yii\base\InvalidParamException if token is empty or not valid
     */
    public function __construct($token, $config = [])
    {
        if (empty($token) || !is_string($token)) {
            throw new InvalidParamException('Password reset token cannot be blank.');
        }
        $this->_user = User::findByPasswordResetToken($token);
        if (!$this->_user) {
            throw new InvalidParamException('Ссылка устарела');
        }
        parent::__construct($config);
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['login'], 'unique', 'targetClass' => '\my\models\User', 'targetAttribute' => 'login'],
            [['password', 'login'], 'required'],
            [['password', 'login'], 'trim'],
            [['login'], 'string', 'min' => 4, 'max' => 200],
            [['password'], 'string', 'min' => 6, 'max' => 200],
            //['login', 'match', 'pattern' => '/^[a-zA-Z][a-zA-Z0-9]*[._-]?[a-zA-Z0-9]+$/', 'message' => 'Логин должен содержать только латинские буквы и цифры'],
            //['password', 'match', 'pattern' => '^(?=.*[0-9])(?=.*[a-z])(?=.*[A-Z])(?=.*[@#$%^&+=])(?=\S+$).{8,}$', 'message' => 'Пароль должен содержать только латинские буквы и цифры'],

            ['password', 'match', 'pattern' => '/^.*(?=.{4,10})(?=.*\d)(?=.*[a-zA-Z]).*$/', 'message' => 'Пароль должен содержать  латинские буквы и цифры'],

            //  ['login', 'match', 'pattern' => '/^[a-zA-Z0-9_\-\!\@\#\$\%\/\&\*\+\=\?\|\{\}\[\]\(\)]{4,30}$/', 'message' => 'Логин должен содержать  латинские буквы и цифры'],


            //['password', 'match', 'pattern' => '/^[a-zA-Z]+$/', 'message' => 'Логин должен содержать  латинские буквы'],
            ['repeatnewpass', 'compare', 'compareAttribute' => 'password'],
        ];
    }

    //^[a-z0-9_-]{3,15}$
    // /^[a-zA-Z0-9_-]+$/
    /**
     * Resets password.
     *
     * @return bool if password was reset.
     */
    public function resetPassword()
    {
        $user = $this->_user;

        //if($this->_user->status==10)
        //  $user->login =  mb_substr($this->_user->login, 2);


        //Не для суперадминов
        if ($this->login != null) {
            $user->login = $this->login;
        }


        \Yii::$app->session['my_login'] = $this->login;

        $user->setPassword($this->password);
        $user->removePasswordResetToken();

        return $user->save(false);
    }

    public function validateLogin()
    {
        if ($this->login == null) {
            $this->login = $this->_user->login = mb_substr($this->_user->login, 2);
        }

        return true;

    }


    public function attributeLabels()
    {
        return [
            'password'      => 'Пароль',
            'login'         => 'Логин',
            'repeatnewpass' => 'Новый пароль еще раз',

        ];
    }


}
