<?php

namespace my\models\feedback;

use yii\base\Model;
use yii\base\InvalidParamException;
use my\models\Dogovors;

/**
 * Password reset form
 */
class Other extends Model
{

  public $body;
  public  $file;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['body'], 'required'],
            [['file'], 'file', 'skipOnEmpty' => true, 'extensions' => 'pdf, png, jpg'],
            [['body'], 'safe'],

            //   ['username', 'match', 'pattern' => '/^[a-zA-Z0-9_-]+$/', 'message' => 'Your username can only contain alphanumeric characters, underscores and dashes.'],
        ];
    }


    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'subject' => 'Тема',
            'file' => 'Прикрепить файл',
            'body' => 'Сообщение',
            'created_at' => 'Created At',

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


    /*
    public static function cartTypeView($array){



    }
    */


}
