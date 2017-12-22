<?php

namespace my\models;

use Yii;
use yii\base\Model;
use my\models\User;

/**
 * Password reset request form
 */
class PasswordResetRequestForm extends Model
{
    public $login;


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['login', 'trim'],
            ['login', 'required'],
            // ['email', 'email'],
            [
                'login',
                'exist',
                'targetClass' => '\my\models\User',
                //'filter' => ['status' => User::STATUS_SUPERADMIN],
                'message'     => 'Пользователь в системе не найдет',
            ],
        ];
    }

    /**
     * Sends an email with a link, for resetting the password.
     *
     * @return bool whether the email was send
     */
    public function sendEmail()
    {
        /* @var $user User */
        $user = User::findOne([
            //'status' => User::STATUS_SUPERADMIN,
            'login' => $this->login,
        ]);

        if (!$user) {
            return false;
        }


        if (!User::isPasswordResetTokenValid($user->password_reset_token)) {
            $user->generatePasswordResetToken();
            if (!$user->save(false)) {
                return false;
            }
        }


        return Yii::$app
            ->mailCardex
            ->compose(
                ['html' => 'passwordResetToken-html', 'text' => 'passwordResetToken-text'],
                ['user' => $user]
            )
            ->setTo(User::getMyMail($user->email))//$user->email
            ->setSubject('Восстановление пароля')
            ->send();
    }


    public function attributeLabels()
    {
        return [
            'password' => 'Пароль',
            'login'    => 'Логин',

        ];
    }

}
