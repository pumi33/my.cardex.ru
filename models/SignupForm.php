<?php

namespace my\models;

use yii\base\Model;
use my\components\User;

/**
 * Signup form
 */
class SignupForm extends Model
{
    public $username;
    public $email;
    public $password;
    public $identity;


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['username', 'trim'],
            ['username', 'required'],
            ['username', 'string', 'min' => 2, 'max' => 255],

            ['email', 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'string', 'max' => 255],
            ['email', 'unique', 'targetClass' => '\my\models\User', 'message' => 'This email address has already been taken.'],

            ['password', 'required'],
            ['password', 'string', 'min' => 6],
        ];
    }

    /**
     * Signs user up.
     *
     * @return User|null the saved model or null if saving fails
     */
    public function signup()
    {
        if (!$this->validate()) {
            return null;
        }

        $user           = new User();
        $user->username = $this->username;
        $user->email    = $this->email;
        $user->setPassword($this->password);
        $user->generateAuthKey();

        return $user->save() ? $user : null;
    }


    public function authenticate()
    {
        if (!$user = User::findIdentityByUsernameOrEmail($this->identity)) {
            $this->addError('identity', Yii::t('app', 'invalid_credentials_on_login'));

            return false;
        }

        if (!$user->validatePassword($this->password)) {
            $this->addError('identity', Yii::t('app', 'invalid_credentials_on_login'));

            return false;
        }

        return $user;
    }


}
