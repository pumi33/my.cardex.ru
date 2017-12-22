<?php

namespace my\models;

use Yii;

/**
 * This is the model class for table "log_logins".
 *
 * @property integer $id
 * @property integer $ip
 * @property string  $login
 * @property string  $created_at
 * @property integer $status
 */
class LogLogins extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */


    public static function tableName()
    {
        return 'log_logins';
    }


    public static function getDb()
    {
        return \Yii::$app->db_log;
    }


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['status'], 'integer'],
            [['created_at'], 'safe'],
            [['login', 'ip', 'admin_name'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id'         => 'ID',
            'ip'         => 'Ip',
            'login'      => 'Login',
            'created_at' => 'Created At',
            'status'     => 'Status',
        ];
    }


    /*
    SELECT ip, COUNT(*) AS c
    FROM
    log_logins
    WHERE
    created_at >= DATE_SUB(NOW(), INTERVAL 1352 MINUTE)
    AND STATUS=0
    GROUP BY ip
    ORDER BY c DESC;
    */

    /** Проверка на количество неуспешных входов
     * @return bool
     */
    public static function checkCountLogins()
    {
        $login = static::find()
            ->select('ip, COUNT(*) AS c')
            ->where('created_at >= DATE_SUB(NOW(), INTERVAL 15 MINUTE)')
            ->andWhere(['=', 'status', 0])
            ->andWhere(['=', 'ip', \Yii::$app->getRequest()->getUserIP()])
            ->orderBy('c DESC')
            ->asArray()->one();


        if ($login['c'] > 10) {
            return false;
        } else {
            return true;
        }

    }


}
