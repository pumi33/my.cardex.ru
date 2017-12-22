<?php
namespace my\models\feedback;

use yii\base\Model;
use yii\base\InvalidParamException;
use my\models\User;

/**
 * Password reset form
 */
class ActiveBlockCard extends Model
{
    public $own;

    /**
     * @var \common\models\User
     */




    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['own', 'required'],
            ['own', 'trim'],
            ['own', 'string', 'min' => 3,'max'=>200],
            //   ['username', 'match', 'pattern' => '/^[a-zA-Z0-9_-]+$/', 'message' => 'Your username can only contain alphanumeric characters, underscores and dashes.'],
        ];
    }




    public function attributeLabels()
    {
        return [
            'own' => 'Держатель',
            'login' => 'Логин',

        ];
    }



}
