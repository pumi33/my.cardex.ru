<?php

namespace my\models;

use Yii;
use my\helpers\Help;

use yii\web\Controller;
use yii\httpclient\Client;
use yii\helpers\ArrayHelper;
use yii\helpers\VarDumper;
use my\models\User;
use my\models\Dogovors;

/**
 * This is the model class for table "import_all".
 *
 * @property integer $id
 * @property string  $owner
 * @property string  $mail
 * @property string  $created_at
 */
class ImportAll extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'import_all';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['created_at'], 'safe'],
            [['owner_gid', ':dogovor_guid', 'mail', 'full_name', 'code'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id'         => 'ID',
            'owner'      => 'Owner',
            'mail'       => 'Mail',
            'created_at' => 'Created At',
        ];
    }


    public function import()
    {

        $client   = new Client();
        $response = $client->createRequest()
            ->setMethod('get')
            ->setUrl(\Yii::$app->params['api-url'] . '/dogovors/all/')
            //->setData(['name' => 'John Doe', 'email' => 'johndoe@example.com'])
            ->send();

        if ($response->isOk) {


            Yii::$app->db->createCommand()->truncateTable('import_all')->execute();

            if (count($response->data)) {
                foreach ($response->data as $res) {

                    /*

                         */

                    if ($res['dogovor_guid'] != "ADE8448A5BD93EE411E4ADFD491DFBCC") { //07-K/5-177
                        $result[] = [$res['owner_giud'], $res['email'], $res['fullName'], $res['dogovor'], $res['dogovor_guid'], $res['status'], $res['code'], Help::normalDate($res['date_dogovor'], true, 'Y-m-d')];
                    }


                    // STATUS
                    //81D78BAB7F30C39A427AC024BC45119F = OK
                    //B0750601E13D90F3485BCD7EAB90AA21 = BLOCK
                }

                Yii::$app->db->createCommand()->batchInsert($this::tableName(), ['owner_guid', 'mail', 'full_name', 'dogovor', 'dogovor_guid', 'status', 'code', 'date_dogovor'], $result)->execute();

            }


            $imports = $this::find()->all();


            //ДОГОВОРЫ
            $count['users'] = $count['dogovors'] = $count['update'] = 0;


            foreach ($imports as $import) {

                $dogovors = Dogovors::find()->where(['guid' => $import['dogovor_guid']])->one();
                if (!$dogovors) {

                    $new_dogovor               = new Dogovors();
                    $new_dogovor->guid         = $import['dogovor_guid'];
                    $new_dogovor->title        = $import['dogovor'];
                    $new_dogovor->status       = $import['status'];
                    $new_dogovor->code         = $import['code'];
                    $new_dogovor->date_dogovor = $import['date_dogovor'];
                    $new_dogovor->full_name    = $import['full_name'];
                    $new_dogovor->owner_guid   = $import['owner_guid'];

                    if (!$new_dogovor->save()) {
                        print_r($new_dogovor->errors);
                        Help::modelErrors($this->errors);
                    }

                    $count['dogovors']++;
                } else {

                    $dogovors->full_name    = $import['full_name'];
                    $dogovors->status       = $import['status'];
                    $dogovors->code         = $import['code'];
                    $dogovors->status       = $import['status'];
                    $dogovors->date_dogovor = $import['date_dogovor'];
                    $dogovors->owner_guid   = $import['owner_guid'];
                    if (!$dogovors->save()) {
                        print_r($dogovors->errors);
                        Help::modelErrors($this->errors);
                    }
                }


                //ПОЛЬЗОВАТЕЛИ
                $users = User::find()->where(['dogovor_guid' => $import['dogovor_guid']])->andWhere(['status' => User::STATUS_SUPERADMIN])->one();


                if ($import['mail'] == 'mc_laud@bk.ru') {
                    $import['mail'] = "";
                }


                if (!$users) {


                    $user               = new User();
                    $user->username     = $import['dogovor'];
                    $user->login        = '__' . $import['dogovor'];
                    $user->email        = $import['mail'];
                    $user->owner_guid   = $import['owner_guid'];
                    $user->dogovor_guid = $import['dogovor_guid'];
                    $user->status       = User::STATUS_SUPERADMIN;
                    $user->createNewUser();
                    $count['users']++;
                } elseif ($users->email != $import['mail']) {
                    $users->delete();

                    $user               = new User();
                    $user->username     = $import['dogovor'];
                    $user->login        = '__' . $import['dogovor'];
                    $user->email        = $import['mail'];
                    $user->owner_guid   = $import['owner_guid'];
                    $user->dogovor_guid = $import['dogovor_guid'];
                    $user->status       = User::STATUS_SUPERADMIN;
                    $user->createNewUser();
                    $count['update']++;
                } else {
                    //все ок
                    //  print $users->login;
                    // print $users->email;
                }


            }


            print_r($count);

        } else {
            throw new \yii\httpclient\Exception('не могу подключиться к api');
        }


    }


    public function importOne($code)
    {
        $client   = new Client();
        $response = $client->createRequest()
            ->setMethod('get')
            ->setUrl(\Yii::$app->params['api-url'] . '/dogovors/all/')
            ->setData(['code' => $code])
            ->send();

        if ($response->isOk) {


            Yii::$app->db->createCommand()->truncateTable('import_all')->execute();

            if (count($response->data)) {

                //
                foreach ($response->data as $res) {


                    if ($res['dogovor_guid'] != "ADE8448A5BD93EE411E4ADFD491DFBCC") { //07-K/5-177
                        $result[] = [$res['owner_giud'], $res['email'], $res['fullName'], $res['dogovor'], $res['dogovor_guid'], $res['status'], $res['code'], Help::normalDate($res['date_dogovor'], true, 'Y-m-d')];
                    }


                    // STATUS
                    //81D78BAB7F30C39A427AC024BC45119F = OK
                    //B0750601E13D90F3485BCD7EAB90AA21 = BLOCK
                }

                Yii::$app->db->createCommand()->batchInsert($this::tableName(), ['owner_guid', 'mail', 'full_name', 'dogovor', 'dogovor_guid', 'status', 'code', 'date_dogovor'], $result)->execute();

            }


            $imports = $this::find()->all();


            //ДОГОВОРЫ
            $count['users'] = $count['dogovors'] = $count['update'] = 0;


            foreach ($imports as $import) {

                $dogovors = Dogovors::find()->where(['guid' => $import['dogovor_guid']])->one();
                if (!$dogovors) {

                    $new_dogovor               = new Dogovors();
                    $new_dogovor->guid         = $import['dogovor_guid'];
                    $new_dogovor->title        = $import['dogovor'];
                    $new_dogovor->status       = $import['status'];
                    $new_dogovor->code         = $import['code'];
                    $new_dogovor->date_dogovor = $import['date_dogovor'];
                    $new_dogovor->full_name    = $import['full_name'];
                    $new_dogovor->owner_guid   = $import['owner_guid'];

                    if (!$new_dogovor->save()) {
                        print_r($new_dogovor->errors);
                        Help::modelErrors($this->errors);
                    }

                    $count['dogovors']++;
                } else {

                    $dogovors->full_name    = $import['full_name'];
                    $dogovors->status       = $import['status'];
                    $dogovors->code         = $import['code'];
                    $dogovors->status       = $import['status'];
                    $dogovors->date_dogovor = $import['date_dogovor'];
                    $dogovors->owner_guid   = $import['owner_guid'];
                    if (!$dogovors->save()) {
                        print_r($dogovors->errors);
                        Help::modelErrors($this->errors);
                    }
                }


                //ПОЛЬЗОВАТЕЛИ
                $users = User::find()->where(['dogovor_guid' => $import['dogovor_guid']])->andWhere(['status' => User::STATUS_SUPERADMIN])->one();


                if ($import['mail'] == 'mc_laud@bk.ru') {
                    $import['mail'] = "";
                }


                if (!$users) {
                    $user               = new User();
                    $user->username     = $import['dogovor'];
                    $user->login        = '__' . $import['dogovor'];
                    $user->email        = "";
                    $user->owner_guid   = $import['owner_guid'];
                    $user->dogovor_guid = $import['dogovor_guid'];
                    $user->status       = User::STATUS_SUPERADMIN;
                    $user->createNewUser();
                    $count['users']++;
                } else {
                    //все ок
                    //  print $users->login;
                    // print $users->email;
                }


            }


            print_r($count);

            return true;

        } else {
            throw new \yii\httpclient\Exception('не могу подключиться к api');
        }
    }


}
