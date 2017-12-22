<?php

namespace my\models\feedback;

use yii\base\Model;
use yii\base\InvalidParamException;
use my\models\User;

/**
 * Password reset form
 */
class BlockCard extends Model
{


    /**
     * @var \common\models\User
     */


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['fuel_type'], 'required'],

        ];
    }


    public function attributeLabels()
    {
        return [


        ];
    }


    public static function card_block($all_card, $block_card = [], $block = 1)
    {
        $need_block = $need_unblock = null;


        foreach ($all_card as $all) {
            if (in_array($all['code'], $block_card)) {
                $need_block .= $all['code'] . "<br>\n";
            }


        }


        if ($block==1) {
            $need_block = 'Нужно заблокировать карты: <br><br>' . $need_block;
        }else {
            $need_unblock = 'Нужно раблокировать карты: <br><br>' . $need_block;
        }

        $data = $need_block . $need_unblock."<br><br>\n\n";

        return $data;


    }





}
