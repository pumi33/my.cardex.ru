<?php

namespace my\models;

use Yii;
use yii\base\Model;

/**
 * ContactForm is the model behind the contact form.
 */
class Mail extends Model
{
    public $to;
    public $subject;
    public $body;


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['to', 'subject', 'body'], 'required'],
            ['to', 'email'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'subject' => 'Тема',
        ];
    }

    /**
     * Sends an email to the specified email address using the information collected by this model.
     *
     * @param string $email the target email address
     *
     * @return bool whether the email was sent
     */
    public function send()
    {
        return Yii::$app->mail->compose(['html' => 'passwordResetToken-html'], $array)
            //->setTo($this->to)
            ->setSubject($this->subject)
            ->setTextBody($this->body)
            ->send();
    }


}
