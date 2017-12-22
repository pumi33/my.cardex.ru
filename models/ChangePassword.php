<?php

namespace my\models;

use yii\base\Model;
use yii\base\InvalidParamException;
use my\models\User;

/**
 * Password reset form
 */
class ChangePassword extends Model
{
    public $oldpass;
    public $newpass;
    public $repeatnewpass;


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [


            ['newpass', 'string', 'min' => 6, 'max' => 30],

            [['oldpass', 'newpass', 'repeatnewpass'], 'required'],
            ['oldpass', 'findPasswords'],
            ['repeatnewpass', 'compare', 'compareAttribute' => 'newpass'],
            ['newpass', 'match', 'pattern' => '/^.*(?=.{4,10})(?=.*\d)(?=.*[a-zA-Z]).*$/', 'message' => 'Пароль должен содержать  латинские буквы и цифры'],
            //  ['login', 'match', 'pattern' => '/^[a-zA-Z0-9_\-\!\@\#\$\%\/\&\*\+\=\?\|\{\}\[\]\(\)]{4,30}$/', 'message' => 'Логин должен содержать  латинские буквы и цифры'],

        ];
    }

    public function findPasswords($attribute, $params)
    {


        $user = User::find()->where([
            'username' => \Yii::$app->user->identity->username,
        ])->one();

        if (\Yii::$app->security->validatePassword($this->oldpass, $user->password_hash)) {
            return true;
        } else {
            $this->addError($attribute, 'Неправильно указан старый пароль');
        }


    }

    /**
     * Resets password.
     *
     * @return bool if password was reset.
     */
    public function resetPassword()
    {
        $user = $this->_user;
        $user->setPassword($this->newpass);
        $user->removePasswordResetToken();

        return $user->save(false);
    }


    public function attributeLabels()
    {
        return [
            'oldpass'       => 'Старый пароль',
            'newpass'       => 'Новый пароль',
            'repeatnewpass' => 'Новый пароль еще раз',

        ];
    }


}
