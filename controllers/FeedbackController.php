<?php

namespace my\controllers;

use my\models\feedback\BlockCard;
use my\models\feedback\ChangeCard;
use my\models\feedback\Other;
use Yii;
use yii\filters\AccessControl;
use my\models\Feedback;
use my\models\feedback\AddCard;
use yii\web\UploadedFile;
use yii\httpclient\Client;
use yii\helpers\Json;
use  my\components\MyController;

class FeedbackController extends MyController
{


    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                //  'only' => ['index'],
                'rules' => [

                    [
                        //  'actions' => ['index'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],

                ],

            ],

        ];
    }


    public function actionIndexOld($cards = null)
    {


        $client = new Client();
        $card   = $client->createRequest()
            ->setMethod('get')
            ->setUrl(\Yii::$app->params['api-url'] . '/cards/info/')
            ->setData(['dogovor' => \Yii::$app->user->identity->dogovor_guid])->send();  //Активные карты


        if ($card->data['status'] == '404') {
            $card->data = "";
        }

        $model = new Feedback();

        if ($cards) {
            $model->subject = 3;
        }

        $model_addcard = new AddCard();

        if ($model->load(Yii::$app->request->post())) {


            if (Yii::$app->request->post()['card_block'] == null) {
                $post_block = [];
            } else {
                $post_block = Yii::$app->request->post()['card_block'];
            }


            switch (Yii::$app->request->post()['Feedback']['subject']) {


                case 1:
                    print $body = Feedback::card_add(Yii::$app->request->post()['card_add']);
                    break;

                case 2:
                    print $body = Feedback::card_block($card->data, $post_block);
                    break;


            }


            if ($model->validate() && $model->save()) {

                if ($model->file = UploadedFile::getInstance($model, 'file')) {
                    $model->file->saveAs($model->setFileName());
                }


                if ($model->sendEmail()) {
                    Yii::$app->session->setFlash('success', 'Ваше сообщение отправлено. Мы обязательно ответим вам.');
                } else {
                    \Yii::warning('НЕ удалось отправить почту на info');
                    Yii::$app->session->setFlash('error', 'There was an error sending your message.');
                }

                return $this->refresh();
            }
        }

        return $this->render('index', [
            'model'         => $model,
            'card'          => $card->data,
            'cards'         => $cards,
            'model_addcard' => $model_addcard,
        ]);


    }

    /**
     * @param null $theme
     *
     * @return mixed
     */
    public function actionIndex($theme = null)
    {

        $feedback = new Feedback();

        if (isset($theme)) {
            $feedback->subject = (int)$theme;
        }

        $client = new Client();
        $card   = $client->createRequest()
            ->setMethod('get')
            ->setUrl(\Yii::$app->params['api-url'] . '/cards/info/')
            ->setData(['dogovor' => \Yii::$app->user->identity->dogovor_guid])->send();
        if ($card->data['status'] == '404') {
            $card->data = "";
        }

        $card = $card->data;


        if (!\Yii::$app->user->can('edits')) {
            \Yii::$app->params['feedbackList'] = ['6' => 'Другое'];
        }

        $feedback->user_id      = \Yii::$app->user->identity->id;
        $feedback->dogovor_guid = \Yii::$app->user->identity->dogovor_guid;


        switch ($theme) {

            case 1:
                $model = new AddCard();
                //   $model->addButton();


                $save_card = AddCard::find()->where(['user_id' => \Yii::$app->user->identity->id])->all();


                //Удаление карты
                if (is_numeric(\Yii::$app->request->get()['delete_id'])) {
                    $delete_card = AddCard::find()->where(['id' => \Yii::$app->request->get()['delete_id'], 'user_id' => \Yii::$app->user->identity->id])->one();


                    if ($delete_card && $delete_card->delete()) {
                        \Yii::$app->session->setFlash('success', 'Карта убрана ');

                        return $this->redirect('/feedback?theme=1');
                    }
                }

                //Отправка на почту
                if (is_numeric(\Yii::$app->request->get()['submit'])) {


                    AddCard::deleteAll(['user_id' => \Yii::$app->user->identity->id]);


                    $add = $this->renderPartial('addcard_table', compact(['save_card']));


                    $feedback->body = $add;
                    $feedback->save(false);
                    $fid = sprintf("%'.09d", $feedback->id);
                    $feedback->sendEmail();
                    \Yii::$app->session->setFlash('success', 'Заявка на выпуск карт создана. Номер завки <b>#' . $fid . '</b> ');

                    return $this->redirect('/feedback/');

                }


                if (isset(\Yii::$app->request->post()['addcard']) and $model->load(Yii::$app->request->post()) and $model->validate() and $model->save()) {
                    \Yii::$app->session->setFlash('success', 'Карта добавлена ');

                    $save = 1;

                    return $this->refresh();


                } else {
                    // print_r($model->error);

                }

                return $this->render('addcard', compact(['model', 'theme', 'save_card']));


                break;


            case 2:

                $model = [];


                if (\Yii::$app->request->post()) {


                    $feedback->body = BlockCard::card_block($card, \Yii::$app->request->post()['card_block'], 1);

                    $feedback->save(false);
                    $fid = sprintf("%'.09d", $feedback->id);
                    $feedback->sendEmail();
                    \Yii::$app->session->setFlash('success', 'Заявка на блокировку карт создана. Номер завки <b>#' . $fid . '</b> ');

                    return $this->redirect('/feedback/');

                }

                return $this->render('blockcard', compact(['model', 'theme', 'card']));
                break;


            case 3:

                $model = [];


                if (\Yii::$app->request->post()) {


                    $feedback->body = BlockCard::card_block($card, \Yii::$app->request->post()['card_block'], 2);

                    $feedback->save(false);
                    $fid = sprintf("%'.09d", $feedback->id);
                    $feedback->sendEmail();
                    \Yii::$app->session->setFlash('success', 'Заявка на разблокировку карт создана. Номер завки <b>#' . $fid . '</b> ');

                    return $this->redirect('/feedback/');

                }

                return $this->render('unblockcard', compact(['model', 'theme', 'card']));
                break;


            case 4:
                $model = [];

                if (\Yii::$app->request->post()) {
                    $feedback->body = ChangeCard::compare($card, \Yii::$app->request->post());

                    $feedback->save(false);
                    $fid = sprintf("%'.09d", $feedback->id);
                    $feedback->sendEmail();
                    \Yii::$app->session->setFlash('success', 'Заявка на изменения лимитов создана. Номер завки <b>#' . $fid . '</b> ');

                    return $this->redirect('/feedback/');
                }


                return $this->render('change', compact(['model', 'theme', 'card']));


                break;

            case 5:
                $model = new Other();


                if ($model->load(Yii::$app->request->post())) {
                    //y = ;
                    $feedback->body = $model->body . "<br><br>\n";

                    if ($feedback->file = UploadedFile::getInstance($model, 'file')) {
                        $feedback->file->saveAs($feedback->setFileName());
                    }

                    //  $feedback->file=$model->file;
                    $feedback->save(false);


                    $feedback->sendEmail();
                    \Yii::$app->session->setFlash('success', 'Заявка на изменения реквизитов создана. ');

                    return $this->redirect('/feedback/');
                }


                return $this->render('requisites', compact(['model', 'theme', 'card']));
                break;


            case 6:
                $model = new Other();


                if ($model->load(Yii::$app->request->post())) {
                    //y = ;
                    //y = ;
                    $feedback->body = $model->body . "<br><br>\n";

                    if ($feedback->file = UploadedFile::getInstance($model, 'file')) {
                        $feedback->file->saveAs($feedback->setFileName());
                    }


                    $feedback->save(false);
                    $fid = sprintf("%'.09d", $feedback->id);

                    if ($feedback->sendEmail()) {
                        \Yii::$app->session->setFlash('success', 'Письмо отправлено в службу поддержки. Номер завки <b>#' . $fid . '</b> ');
                    } else {
                        \Yii::warning('НЕ удалось отправить почту на info');
                    }


                    return $this->redirect('/feedback/');
                }


                return $this->render('other', compact(['model', 'theme', 'card']));
                break;


            default:
                return $this->render('index', []);
                break;


        }


    }


}
