<?php
/**
 * Created by PhpStorm.
 * User: DevAdmin
 * Date: 06.07.2017
 * Time: 11:26
 */
namespace my\components;

class CustomDbTarget extends \yii\log\DbTarget
{

    public function collect($messages, $final)
    {

        foreach ($this->messages as $index  => $message2) {
            if (stripos($message2[0], "log_") === false  and stripos($message2[0], "import_all") === false ) {

            } else {
                unset($this->messages[$index]);
            }
        }




        parent::collect($messages, $final);
    }
}