<?php

namespace my\models\form;

use Yii;
use yii\base\Model;

/**
 * ContactForm is the model behind the contact form.
 */
class Cards extends Model
{
    public $owner;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            // name, email, subject and body are required
            [['owner'], 'string'],

        ];
    }



}