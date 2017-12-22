<?php

namespace my\models;

use yii\base\Model;
use yii\base\InvalidParamException;
use my\models\User;

/**
 * Password reset form
 */
class ResetPasswordForm extends Model
{
    public $password;
    public $repeatnewpass;

    /**
     * @var \common\models\User
     */
    private $_user;


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
            throw new InvalidParamException('Wrong password reset token.');
        }
        parent::__construct($config);

    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['password', 'required'],
            ['password', 'trim'],
            ['password', 'string', 'min' => 6, 'max' => 200],
            ['password', 'match', 'pattern' => '/^[a-zA-Z][a-zA-Z0-9]*[._-]?[a-zA-Z0-9]+$/', 'message' => 'Пароль должен содержать только латинские буквы и цифры'],
            ['repeatnewpass', 'compare', 'compareAttribute' => 'password'],

            //   ['username', 'match', 'pattern' => '/^[a-zA-Z0-9_-]+$/', 'message' => 'Your username can only contain alphanumeric characters, underscores and dashes.'],
        ];
    }

    /**
     * Resets password.
     *
     * @return bool if password was reset.
     */
    public function resetPassword()
    {
        $user = $this->_user;
        $user->setPassword($this->password);
        $user->removePasswordResetToken();

        return $user->save(false);
    }


    public function attributeLabels()
    {
        return [
            'password' => 'Пароль',
            'login'    => 'Логин',

        ];
    }


}
