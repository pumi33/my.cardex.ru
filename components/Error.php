<?php

namespace my\components;

use yii;


/**
 * Исключение, которое будет автоматически обрабатываться на уровне yii\base\Application
 */
class Error
{

    public  static function write($model=null,$display=1)
    {


        if (isset($errors)) {

            if (is_array($errors)) {
                foreach ($errors as $error) {

                    if ($display)
                        \Yii::$app->session->setFlash('warning', $error);


                    \Yii::warning($error);
                }

            } else {
                if ($display)
                    \Yii::$app->session->setFlash('warning', $errors);

                \Yii::warning($errors);
            }
        }

    }
}