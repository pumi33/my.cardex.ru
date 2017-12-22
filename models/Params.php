<?php

namespace my\models;

use Yii;


/**
 * ContactForm is the model behind the contact form.
 */
class Params extends \yii\db\ActiveRecord
{
    public $name;
    public $email;
    public $subject;
    public $body;
    public $verifyCode;


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            // name, email, subject and body are required
            [['key', 'value'], 'string'],
            // email has to be a valid email address
            [['key', 'value'], 'required'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'key'   => 'Ключ',
            'value' => 'Значение',
        ];
    }


    public static function getValue($array, $key)
    {

        foreach ($array as $arr) {

            if ($arr['key'] == $key) {
                return $arr['val'];
            }
        }

        return null;

    }


}
