<?php

namespace my\models;

use \my\models\Dogovors;
use Yii;


/**
 * This is the model class for table "feedback".
 *
 * @property integer $id
 * @property integer $user_id
 * @property string  $title
 * @property string  $body
 * @property string  $created_at
 *
 * @property User    $user
 */
class Feedback extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */

    public $file;
    public $fileName;
    public $dogovor;


    public static function tableName()
    {
        return 'feedback';
    }

    /**
     * @inheritdoc
     */

    public function __construct()
    {
        $this->dogovor = Dogovors::find()->where(['guid' => \Yii::$app->user->identity->dogovor_guid])->one();

    }


    public function rules()
    {
        return [
            [['id', 'user_id', 'subject'], 'integer'],
            [['body'], 'string'],
            [['created_at', 'dogovor_guid'], 'safe'],
            [['file'], 'file', 'skipOnEmpty' => true, 'extensions' => 'pdf, png, jpg'],

            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => \my\models\User::className(), 'targetAttribute' => ['user_id' => 'id']],
            [['subject'], 'required'],
        ];
    }

    public function setFileName()
    {
        return $this->fileName = \Yii::getAlias('@app') . "/temp/mail_attachment/" . date("dmYHis") . "_" . Dogovors::getMyCode() . '.' . $this->file->extension;
    }

    public function getFileName()
    {
        return $this->fileName;
    }


    public function validatePassword()
    {
        //     $this->addError('file', 'error');
    }


    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id'         => 'ID',
            'user_id'    => 'User ID',
            'subject'    => 'Тема',
            'file'       => 'Прикрепить файл',
            'body'       => 'Сообщение',
            'created_at' => 'Created At',
        ];
    }


    /**
     * @return \yii\db\ActiveQuery
     */


    public function getUser()
    {
        return $this->hasOne(\my\models\User::className(), ['id' => 'user_id']);
    }


    public function sendEmail()
    {

        $my_user = User::findOne(\Yii::$app->user->identity->id);


        $prev = "Уважаемый представитель компании Кардекс.<br>
             Из Личного Кабинета пришла заявка:<br>";

        $info = "<br></b>\n\n Договор: " . $this->dogovor['title'] . "\n<br>";
        $info .= "\n\n Компания: " . \Yii::$app->session['company'] . "\n<br>";
        $info .= "Пользователь: " . $my_user->full_name . "\n<br>";
        $info .= "E-mail: " . \Yii::$app->user->identity->email . "\n<br>";
        $info .= "Роль: " . Yii::$app->params['role'][\Yii::$app->user->identity->status] . "\n<br><br>";

        $info2 = "<br><br><b>Выполните заявку как можно быстрее.</b><br>
С уважением,<br>
личный кабинет компании Кардекс<br>
Не отвечайте на это письмо.<br>";


        $send2 = \Yii::$app->mailCardex->compose()
            ->setTo(\Yii::$app->params['adminEmail'])
            ->setSubject(sprintf("%'.09d", $this->dogovor['code']) . "_" . $this->subject . "_" . \Yii::$app->params['feedbackList'][$this->subject] . "_[Ticket " . sprintf("%'.09d", $this->id) . "]")
            ->setHtmlBody($prev . $info . $this->body . $info2);
        if ($this->getFileName()) {
            $send2->attach($this->getFileName());
        }
        $send2->send();


        $send = \Yii::$app->mailCardex->compose()
            ->setTo(\Yii::$app->params['infoEmail'])
            ->setSubject(sprintf("%'.09d", $this->dogovor['code']) . "_" . $this->subject . "_" . \Yii::$app->params['feedbackList'][$this->subject] . "_[Ticket " . sprintf("%'.09d", $this->id) . "]")
            ->setHtmlBody($prev . $info . $this->body . $info2);

        if ($this->getFileName()) {
            $send->attach($this->getFileName());
        }


        return $send->send();//$send->send()
    }


    /** Обработка запроса на блокиировку - разблокировку карт
     *
     * @param null $block_card
     * @param      $all_card
     *
     * @return string
     */
    public static function card_block($all_card, $block_card = [])
    {
        $need_block = $need_unblock = null;


        foreach ($all_card as $all) {


            //какие карты заблокировать (ранее НЕ заблокированы)
            if ($all['status'] != 'B0750601E13D90F3485BCD7EAB90AA21') {
                if (in_array($all['code'], $block_card)) {
                    $need_block .= $all['code'] . "<br>\n";
                }
            }

            //нужно разблокировать
            if ($all['status'] == 'B0750601E13D90F3485BCD7EAB90AA21') {
                if (in_array($all['code'], $block_card)) {
                    $need_unblock .= $all['code'] . "<br>\n";
                }
            }


        }


        if (isset($need_block)) {
            $need_block = 'Нужно заблокировать карты: <br><br>' . $need_block;
        }

        if (isset($need_unblock)) {
            $need_unblock = 'Нужно заблокировать карты: <br><br>' . $need_block;
        }


        $data = $need_block . $need_unblock;

        return $data;


    }


    /** Дозаказ карт
     *
     * @param $post
     */
    public static function card_add($post)
    {

        print_r($_POST);
        exit;


        $data = 'Количество карт: ' . count($post) . "\n\t";

        $n = 0;
        foreach ($post as $pos) {

            $data .= "Тип карты: " . \Yii::$app->params['cards'][$pos['type']] . "\n\t";
            $data .= "Держатель: " . \Yii::$app->params['cards'][$pos['own']] . "\n\t";
            $data .= "Лимит: " . \Yii::$app->params['cards'][$pos['limit']] . "\n\t";


            print    \Yii::$app->params['cards'][$pos['type']];


            $n++;
        }
        print_r($post);
        exit;


    }


}
