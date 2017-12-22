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
class LogPages extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'log_pages';
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
            // [['user_login'], 'required'],
            [['page', 'method', 'user_login'], 'string', 'max' => 255],
        ];
    }


    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            $this->user_id    = \Yii::$app->user->identity->id;
            $this->user_login = \Yii::$app->user->identity->login;
            $this->ip         = \Yii::$app->getRequest()->getUserIP();

            return true;
        }

        return false;
    }


}
