<?php

namespace my\models;

use my\models\User;

use Yii;

/**
 * This is the model class for table "dogovors".
 *
 * @property integer $id
 * @property string $gid
 * @property string $title
 * @property string $owner_gid
 * @property string $status
 */
class Dogovors extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'dogovors';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['status', 'days_to_block', 'n_ostatok','date_dogovor'], 'string'],
            [['guid'], 'unique'],
            [['code'], 'integer'],
            [['guid', 'title', 'owner_guid', 'full_name'], 'string', 'max' => 255],
            ['notifications', 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'gid' => 'Gid',
            'title' => 'Title',
            'owner_gid' => 'Owner Gid',
            'status' => 'Status',
        ];
    }


    public static function getMyCode()
    {

        $find = self::find()->where(['guid' => \Yii::$app->user->identity->dogovor_guid])->one();


        if (!$find)
            return false;

        return sprintf("%'.09d", $find['code']);

    }


    /**получить информация о моем договоре
     * @return bool
     */
    public static function getMy()
    {

        //получаем главного по договору
        $user = User::find()->where(['dogovor_guid' => \Yii::$app->user->identity->dogovor_guid])->andWhere(['status'=>User::STATUS_SUPERADMIN])->one();

        $find = self::find()->where(['guid' => $user['dogovor_guid']])->one();


        if (!$find)
            return false;

        return $find;

    }







}
