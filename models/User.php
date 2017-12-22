<?php

namespace my\models;

use Yii;
use yii\base\NotSupportedException;
use yii\db\ActiveRecord;
use yii\helpers\Security;
use yii\web\IdentityInterface;
use my\models\Dogovors;
use my\helpers\Help;


/**
 * This is the model class for table "tbl_user".
 *
 * @property string $userid
 * @property string $username
 * @property string $password
 */
class User extends \yii\db\ActiveRecord implements IdentityInterface
{


    const STATUS_INACTIVE = 0;


    const STATUS_USER       = 8;
    const STATUS_ADMIN      = 9;
    const STATUS_SUPERADMIN = 10;

    public $full_name;

    /**
     * @inheritdoc
     */


    public static function tableName()
    {
        return 'user';
    }


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['surname', 'first_name', 'email', 'login', 'phone', 'position'], 'required'],
            [['username', 'patronymic', 'first_name', 'surname', 'position', 'phone', 'owner_guid', 'dogovor_guid', 'logged_in_ip'], 'string', 'min' => 2, 'max' => 200],
            [['username', 'patronymic', 'first_name', 'surname', 'email', 'position', 'phone', 'login'], 'filter', 'filter' => 'trim'],
            ['email', 'email'],
            ['email', 'email'],
            ['notifications', 'safe'],

            [['login'], 'unique'],
            [['phone'], 'match', 'pattern' => '/\(?([0-9]{3})\)?([ .-]?)([0-9]{3})\2([0-9]{4})/'],

            [['status', 'is_active'], 'integer', 'min' => 0, 'max' => 11],
        ];
    }


    public function attributeLabels()
    {
        return [
            'id'         => 'ID',
            'username'   => 'ФИО',
            'surname'    => 'Фамилия',
            'first_name' => 'Имя',
            'patronymic' => 'Отчество',

            'phone'     => 'Телефон',
            'phone_dob' => 'Добавочный',
            'mail'      => 'E-mail',
            'password'  => 'Пароль',
            'status'    => 'Права',
            'position'  => 'Должность',
            'login'     => 'Логин',
        ];
    }


    /** INCLUDE USER LOGIN VALIDATION FUNCTIONS**/
    /**
     * @inheritdoc
     */
    public static function findIdentity($id)
    {
        return static::findOne($id);
    }


    public function getDogovor()
    {
        return $this->hasOne(Dogovors::className(), ['guid' => 'dogovor_guid']);
    }


    public static function findByUsername($username)
    {
        return static::findOne(['emaila' => $username]);
    }

    /**
     * @inheritdoc
     */
    /* modified */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        return static::findOne(['access_token' => $token]);
    }

    /* removed
        public static function findIdentityByAccessToken($token)
        {
            throw new NotSupportedException('"findIdentityByAccessToken" is not implemented.');
        }

    /**
     * Finds user by username
     *
     * @param  string      $username
     * @return static|null
     */

    public static function findUserByEmail($username)
    {


        //  return static::findOne(['login' => $username]);  // Юзернайм это почта
        //   $username2 = str_replace('к', 'k', $username);
        //  $username2 = str_replace('к', 'K', $username2);

        //$username = str_replace('k', 'к', $username);
        //$username = str_replace('K', 'к', $username);


        $user      = mb_strtolower($username, 'UTF-8');
        $username2 = str_replace('k', 'к', $user);


        $user = static::find()->where("login IN(:username,:username2)", [':username' => $username, ':username2' => $username2])->joinWith('dogovor')->one();


        // print_r($user);
        //  exit;

        if (!$user->dogovor->guid) {
            \Yii::$app->session->setFlash('error', 'Неправильный логин или пароль.');

            return false;
        }


        return $user;
    }


    /**
     * Finds user by password reset token
     *
     * @param  string $token password reset token
     *
     * @return static|null
     */
    public static function findByPasswordResetToken($token)
    {
        $expire    = 86400;
        $parts     = explode('_', $token);
        $timestamp = (int)end($parts);
        if ($timestamp + $expire < time()) {
            // token expired
            return null;
        }

        return static::findOne([
            'password_reset_token' => $token,
        ]);
    }

    /**
     * @inheritdoc
     */
    public function getId()
    {
        return $this->getPrimaryKey();
    }

    /**
     * @inheritdoc
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }

    /**
     * @inheritdoc
     */
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

    /**
     * Validates password
     *
     * @param  string $password password to validate
     *
     * @return boolean if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        // file_put_contents("1.txt",$password);

        return Yii::$app->security->validatePassword($password, $this->password_hash);
    }

    /**
     * Generates password hash from password and sets it to the model
     *
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password_hash = Yii::$app->security->generatePasswordHash($password);
    }

    /**
     * Generates "remember me" authentication key
     */
    public function generateAuthKey()
    {
        $this->auth_key = Yii::$app->security->generateRandomString();
    }

    /**
     * Generates new password reset token
     */
    public function generatePasswordResetToken()
    {
        $this->password_reset_token = Yii::$app->security->generateRandomString() . '_' . time();
    }

    /**
     * Removes password reset token
     */
    public function removePasswordResetToken()
    {
        $this->password_reset_token = null;
    }

    /** EXTENSION MOVIE **/


    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            // if ($this->isNewRecord) {
            $this->auth_key     = Yii::$app->security->generateRandomString();
            $this->access_token = Yii::$app->security->generateRandomString();

            //  }

            if ($this->isNewRecord) {
                $this->password_hash        = \Yii::$app->security->generatePasswordHash(\Yii::$app->security->generateRandomString());
                $this->password_reset_token = \Yii::$app->security->generateRandomString() . '_' . time();;

                // if ($this->status == $this::STATUS_SUPERADMIN)
                //  $this->username = mb_substr($this->username, 2);

            }


            // if ($this->password_hash) {
            //$this->setPassword($this->password);
            // }

            return true;
        }

        return false;
    }


    public static function isPasswordResetTokenValid($token)
    {
        if (empty($token)) {
            return false;
        }
        $timestamp = (int)substr($token, strrpos($token, '_') + 1);
        $expire    = 86400; //24 hour

        return $timestamp + $expire >= time();
    }


    public function createNewUser()
    {
        //User::getMyMail()

        if ($this->save(false)) {


            \Yii::$app->mailCardex
                ->compose(
                    ['html' => 'userRegistration'],
                    ['user' => $this]
                )
                ->setTo(\Yii::$app->params['adminEmail'])//$this->email
                ->setSubject('Добавление нового контактного лица (ДУБЛЬ)')
                ->send();


            return \Yii::$app->mailCardex
                ->compose(
                    ['html' => 'userRegistration'],
                    ['user' => $this]
                )
                ->setTo($this->email)//$this->email
                ->setSubject(' Добавление нового контактного лица')
                ->send();
            //&#x1f4b3;


            //return true;

        } else {
            //  print_r($this->errors);
            Help::modelErrors($this->errors);
        }


        return false;

    }


    public static function getActiveUser()
    {
        return User::find()
            ->where(['dogovor_guid' => \Yii::$app->user->identity->dogovor_guid, 'is_active' => 1])
            // ->andWhere(['!=', 'deleted', 0])
            ->orderBy('id')
            ->all();
    }

    public static function getMyUser($id)
    {
        return User::findOne(['dogovor_guid' => \Yii::$app->user->identity->dogovor_guid, 'is_active' => 1, 'id' => $id]);

    }


    public static function deletes($id)
    {

        $user = User::find()
            ->where(['dogovor_guid' => \Yii::$app->user->identity->dogovor_guid, 'id' => $id])
            ->andWhere(['!=', 'status', User::STATUS_SUPERADMIN])
            ->andWhere(['!=', 'id', \Yii::$app->user->identity->id])
            ->one();;

        if ($user) {
            return $user->delete();
        }

        return false;
    }


    public function afterFind()
    {
        parent::afterFind();
        $this->full_name = $this->surname . " " . $this->first_name . " " . $this->patronymic;
        //$this->created_at=date('%d.%m.%Y',$this->created_at);


    }


    public static function getMyMail($mail = null)
    {

        if (isset($mail)) {
            return $mail;
        }

        if (\Yii::$app->session['is_admin'] == 1) {
            return \Yii::$app->params['adminEmail'];
        } else {
            return \Yii::$app->user->identity->email;
        }


    }


}