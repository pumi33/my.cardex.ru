<?php

namespace my\models;

use yii\base\Model;
use yii\base\InvalidParamException;
use my\models\User;

/**
 * Password reset form
 */
class Notifications extends Model
{
    public $ostatkiReminder;
    public $weekReminder;
    public $repeatnewpass;


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [

            [['ostatkiReminder', 'weekReminder'], 'integer'],

        ];
    }


    public function attributeLabels()
    {
        return [


        ];
    }


}





