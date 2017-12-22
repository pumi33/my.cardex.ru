<?php

namespace my\models\feedback;

use yii\base\Model;
use yii\base\InvalidParamException;
use my\models\User;

/**
 * Password reset form
 */
class AddCard extends \yii\db\ActiveRecord
{

    /*
      public $own;
      public $fuel_type;
      public $card_type;

      public $limite_fuel_type;
      public $limite_fuel_value;

      public $limite_service_type;
      public $limite_service_value;
  */


    /**
     * @var \common\models\User
     */


    public static function tableName()
    {
        return 'feedback_addcard';
    }


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['fuel_type','card_type','limite_fuel_value'], 'required'],
            ['own', 'trim'],

            [['own', 'limite_fuel_type'], 'string'],
            [['own'], 'string'],
            ['fuel_type', 'safe'],
            [['card_type', 'limite_fuel_value'], 'integer'],


            //   ['username', 'match', 'pattern' => '/^[a-zA-Z0-9_-]+$/', 'message' => 'Your username can only contain alphanumeric characters, underscores and dashes.'],
        ];
    }


    public function attributeLabels()
    {
        return [
            'own' => 'Держатель',
            'fuel_type' => 'Вид топлива/услуги',
            'card_type' => 'Тип топливной карты',
            'limite_fuel_value' => 'Лимит топлива (литры)',
            'limite_fuel_type' => 'Тип топлива',

        ];
    }


    public function beforeSave($insert)
    {


        if (parent::beforeSave($insert)) {

            $this->user_id = \Yii::$app->user->identity->id;
            $this->fuel_type = serialize($this->fuel_type);


            return true;
        }
        return false;
    }


    public function afterFind()
    {
        parent::afterFind();
        if (!empty($this->fuel_type)) {
            // $this->fuel_type = unserialize($this->fuel_type);
            $data = "";

            $types = (array)unserialize($this->fuel_type);


            foreach ($types as $type) {
                $data .= \Yii::$app->params['oil'][$type] . ", ";

            }
            $data = mb_substr(trim($data), 0, -1);
            $this->fuel_type = $data;

        }
    }


    /*
    public static function cartTypeView($array){



    }
    */


}
