<?php

namespace my\models\feedback;

use yii\base\Model;
use yii\base\InvalidParamException;
use my\models\User;

/**
 * Password reset form
 */
class ChangeCard extends Model
{


    /** Сравнение лимитов
     * @param $all_card
     * @param $cards
     */
    public  static function compare($all_card, $cards){

        $cards2=$cards;
        $data="";

      //  print_r($cards);
        $tr=null;
        foreach ($all_card as $all){
            $limite_value=$fuel=$limite_type=null;


            if(in_array($all['code'],$cards['card_block'])) {


              //  if($cards['limite_value'][$all['code']]!=$all['limite'])
                    $limite_value="<tr><td>Лимит</td><td>".$all['limite']." л.</td><td>".$cards['limite_value'][$all['code']]." л.</td></tr>\n";

               // if($cards['limite_type'][$all['code']] and $cards['limite_type'][$all['code']]!=$all['typeLimite']) {
                 $code1=$all['typeLimite'];
                 $code2=$cards['limite_type'][$all['code']];
                    $limite_type = "<tr><td>Тип лимита</td><td>" . \Yii::$app->params['typeLimite2'][$code1] . "</td><td>" . \Yii::$app->params['typeLimite2'][$code2] . " </td></tr>\n";
               // }

                if(isset($cards['fuel'][$all['code']])) {


                   // $cards['fuel'][$all['code']] = [];

                    $keys = array_keys($cards['fuel'][$all['code']]);

               //   print "<pre>";
                  //  print_r($cards['fuel']);




                    if(!empty($keys)) {
                        $fuel = "<tr><td>Виды топлива</td><td>" . $all['fuelView'] . "</td><td> &nbsp; ||| &nbsp; " . implode(",", $keys) . " </td></tr>\n";
                    }

                }


                if($limite_value or $fuel or $limite_type) {
                    $tr .="<tr><td colspan='3' bgcolor='#f0f8ff'>Карта: <b>".$all['code']."</b></td></tr>\n";

                    $tr .= $fuel . $limite_value . $limite_type;
                }

            }

        }

        if(isset($tr))
        print $data="<table border='0'><tr><th>Параметр</th><th>Старое значение</th><th>Новое значение</th></tr>\n".$tr."</table><br><br>\n";




       // exit;

        return $data;


    }









}