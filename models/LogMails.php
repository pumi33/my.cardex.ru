<?php

namespace my\models;

use Yii;


class LogMails extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */


    public static function tableName()
    {
        return 'log_mails';
    }


    public static function getDb()
    {
        return \Yii::$app->db_log;
    }


}
