<?php

namespace my\controllers;

use my\models\LogLogins;
use Yii;
use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use my\models\LoginForm;
use my\models\PasswordResetRequestForm;
use my\models\ResetPasswordForm;
use my\models\SignupForm;
use my\models\ContactForm;
use my\models\User;
use my\models\NewLoginPassword;
use my\models\Dogovors;
use my\helpers\Help;
use my\components\Error;
use yii\helpers\Url;
use  my\components\MyController;
use my\models\ImportAll;
use yii\httpclient\Client;

/**
 * Site controller
 */
class SiteController extends MyController
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only'  => ['logout', 'new-user', 'signup', 'index', 'request-password-reset', 'reset-password'],
                'rules' => [
                    [
                        'actions' => ['signup', 'new-user', 'request-password-reset', 'reset-password'],
                        'allow'   => true,
                        'roles'   => ['?'],
                    ],
                    [
                        'actions' => ['logout', 'index'],
                        'allow'   => true,
                        'roles'   => ['@'],
                    ],
                ],
            ],
            'verbs'  => [
                'class'   => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    public function init()
    {
        $this->enableCsrfValidation = true;
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error'   => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class'           => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return mixed
     */
    public function actionIndex()
    {

        $dogovor = Dogovors::find()->where(['guid' => \Yii::$app->user->identity->dogovor_guid])->one();

        $client   = new Client();
        $response = $client->createRequest()
            ->setMethod('get')
            ->setUrl(\Yii::$app->params['api-url'] . '/report/finance-transaction-last')
            ->setData(['dogovor' => \Yii::$app->user->identity->dogovor_guid])->send();

        $last_transaction = $response->data;


        return $this->render('index', compact(['dogovor', 'last_transaction']));
    }

    /**
     * Displays homepage.
     *
     * @return mixed
     */


    public function actionOld()
    {


        $dogovor = Dogovors::find()->where(['guid' => \Yii::$app->user->identity->dogovor_guid])->one();


        return $this->render('index_old', ['dogovor' => $dogovor]);
    }


    /**
     * Logs in a user.
     *
     * @return mixed
     */
    public function actionLogin()
    {


        $this->layout = 'clean';


        if (!Yii::$app->user->isGuest and !\Yii::$app->request->get()['login']) {
            return $this->goHome();
        }

        $model  = new LoginForm();
        $model2 = new PasswordResetRequestForm();


        if (\Yii::$app->request->get()['login']) {
            $exp = explode("_", urldecode(\Yii::$app->request->get()['login']));


            $login['dogovor'] = $exp['2'];
            $login['name']    = $exp['1'];

            //проверка
            if (!strtolower(md5($login['name'] . $login['dogovor'])) == $login['name'] . $login['dogovor']) {
                Error::write('Ошибка авторизации');

                return $this->redirect('/');
            } else {

            }


            $login['pass'] = '428';
            $dogovor       = Dogovors::find()->where(['code' => $login['dogovor']])->One();

            if (!$dogovor) {
                $importAll = new ImportAll();

                if ($importAll->importOne($login['dogovor'])) {

                    $dogovor = Dogovors::find()->where(['code' => $login['dogovor']])->One();

                }
                sleep(1);
            }


            if ($dogovor) {
                $tuser            = User::find()->where(['dogovor_guid' => $dogovor['guid']])->One();
                $login['dogovor'] = $tuser['login'];

                \Yii::$app->session['admin_name'] = $login['name'];//mb_convert_encoding($login['name'], "utf-8", "windows-1251");;

            }
        } else {
            $login['dogovor'] = $login['name'] = $login['pass'] = null;
        }


        // print_r($login);
        // exit;


        if ($model->load(Yii::$app->request->post()) && $model->login()) {


            $model->afterLogin();


            return $this->goBack();
        } else {
            return $this->render('login', [
                'model'  => $model,
                'model2' => $model2,
                'login'  => $login,
            ]);
        }


    }

    /**
     * Logs out the current user.
     *
     * @return mixed
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Displays contact page.
     *
     * @return mixed
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail(Yii::$app->params['adminEmail'])) {
                Yii::$app->session->setFlash('success', 'Thank you for contacting us. We will respond to you as soon as possible.');
            } else {
                Yii::$app->session->setFlash('error', 'There was an error sending your message.');
            }

            return $this->refresh();
        } else {
            return $this->render('contact', [
                'model' => $model,
            ]);
        }
    }


    /**
     * Signs user up.
     *
     * @return mixed
     */
    public function actionSignup()
    {
        $model = new SignupForm();
        if ($model->load(Yii::$app->request->post())) {

            if ($user = $model->signup()) {
                if (Yii::$app->getUser()->login($user)) {
                    return $this->goHome();
                }
            }
        }

        return $this->render('signup', [
            'model' => $model,
        ]);
    }

    /**
     * Requests password reset.
     *
     * @return mixed
     */
    public function actionRequestPasswordReset()
    {
        $this->layout = 'clean';

        $model = new PasswordResetRequestForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail()) {
                Yii::$app->session->setFlash('success', 'На адрес вашей электронной почты отправлено сообщение с инструкциями. ');

                return $this->goHome();
            } else {
                Yii::$app->session->setFlash('error', 'Sorry, we are unable to reset password for the provided email address.');
            }
        }

        return $this->render('requestPasswordResetToken', [
            'model2' => $model,
        ]);
    }

    /**
     * Resets password.
     *
     * @param string $token
     *
     * @return mixed
     * @throws BadRequestHttpException
     */
    public function actionResetPassword($token)
    {
        $this->layout = 'clean';

        try {
            $model = new ResetPasswordForm($token);
        } catch (InvalidParamException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }

        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->resetPassword()) {
            Yii::$app->session->setFlash('success', 'Новый пароль сохранен');

            return $this->goHome();
        }

        return $this->render('resetPassword', [
            'model' => $model,
        ]);
    }


    /**
     * new-user.
     *
     * @param string $token
     *
     * @return mixed
     * @throws BadRequestHttpException
     */
    public function actionNewUser($token)
    {
        $this->layout = 'clean';

        try {
            $model = new NewLoginPassword($token);
        } catch (InvalidParamException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }


        if ($model->load(Yii::$app->request->post()) && $model->validateLogin() && $model->validate() && $model->resetPassword()) { ///
            Yii::$app->session->setFlash('success', ' Логин и пароль сохранены');

            return $this->goHome();
        } else {

            Help::modelErrors($model->errors);
        }


        return $this->render('newUser', [
            'model' => $model,
        ]);
    }


    /** Отправка повторных писнм личного кабинета
     *
     * @param $code
     */
    public function actionResend($code)
    {
        $dogovor = Dogovors::find()->where(['code' => $code])->one();

        if ($dogovor) {
            $user = User::find()->where(['dogovor_guid' => $dogovor->guid])->one();
        }


        if (mb_substr($user->login, 0, 2) == "__") {

            if ($user->delete()) {
                \Yii::$app->session->setFlash('success', ' Повторное письмо отправлено');
            }

        } else {
            \Yii::$app->session->setFlash('error', ' Пользователь не найден');
        }


        return $this->redirect('/');

    }


    public function actionTest()
    {


        $str   = "csdn ik dsk ks ksd kk dkjsd sasasaascoin  dfsdfdsdfdfdf";
        $query = "coin";

        $str = preg_replace('/(\\w*' . preg_quote($query) . ')/i', "<b>$1</b>", $str);

        print $str;


        preg_match_all('/(\\w*' . preg_quote($query) . ')/i', $str, $matches, PREG_PATTERN_ORDER);
        print_r($matches);







        exit;

        $file = file_get_contents("http://api.corp.card-oil.ru/dogovors/balance?dogovor=80C80025907AD3B811E4C732D2722680");

        print_r($file);

        exit;


        //    $user=User::find()->where(['dogovor_guid' => \Yii::$app->user->identity->dogovor_guid, 'is_active' => 1])->joinWith('dogovor')->one();
        //  print "<pre>";
        // print $user->login;
        //print $user->dogovor->guid;


        print "<pre>";


        $ns = "";


        foreach (dns_get_record("soud.ru") as $dns) {

            if ($dns['type'] == 'NS') {
                $ns .= $dns['target'] . " ";
            }
        }


        print $ns;


        exit;

        $dogovor = Dogovors::find()->where(['guid' => \Yii::$app->user->identity->dogovor_guid])->one();


        print "<pre>";
        print_r($dogovor);
        exit;

        //  $dogovor->toplivo='[{"pMonth":"5","pYear":"2016","dogovor":"80C80025907AD3B811E4C732D2722680","kolvo":"1551.330","summa":"55498.56"},{"pMonth":"6","pYear":"2016","dogovor":"80C80025907AD3B811E4C732D2722680","kolvo":"1594.990","summa":"56906.95"},{"pMonth":"7","pYear":"2016","dogovor":"80C80025907AD3B811E4C732D2722680","kolvo":"1297.370","summa":"45940.49"},{"pMonth":"8","pYear":"2016","dogovor":"80C80025907AD3B811E4C732D2722680","kolvo":"2316.900","summa":"82442.12"},{"pMonth":"9","pYear":"2016","dogovor":"80C80025907AD3B811E4C732D2722680","kolvo":"3194.930","summa":"113978.45"},{"pMonth":"10","pYear":"2016","dogovor":"80C80025907AD3B811E4C732D2722680","kolvo":"2768.930","summa":"99318.74"},{"pMonth":"11","pYear":"2016","dogovor":"80C80025907AD3B811E4C732D2722680","kolvo":"2639.540","summa":"96013.20"},{"pMonth":"12","pYear":"2016","dogovor":"80C80025907AD3B811E4C732D2722680","kolvo":"2500.000","summa":"93212.00"},{"pMonth":"1","pYear":"2017","dogovor":"80C80025907AD3B811E4C732D2722680","kolvo":"2808.920","summa":"107961.64"},{"pMonth":"2","pYear":"2017","dogovor":"80C80025907AD3B811E4C732D2722680","kolvo":"2629.940","summa":"101703.28"},{"pMonth":"3","pYear":"2017","dogovor":"80C80025907AD3B811E4C732D2722680","kolvo":"2445.450","summa":"94229.59"},{"pMonth":"4","pYear":"2017","dogovor":"80C80025907AD3B811E4C732D2722680","kolvo":"690.000","summa":"26450.00"}]';
        // $dogovor->save();

        // exit;
        return $this->render('index');
    }


    public function actionMap()
    {


        return "<!doctype html>
<html ng-app=\"locatorApp\" xmlns=\"http://www.w3.org/1999/html\">
<head>
    <meta charset=\"utf-8\">
    <meta http-equiv=\"X-UA-Compatible\" content=\"IE=edge\"/>
    <meta name=\"viewport\" content=\"width=device-width, initial-scale=1.0\">
    <base href=\"/\">
    <title translate=\"app.locator\"></title>
    <link rel=\"icon\" href=\"{{ faviconImg }}\" type=\"image/x-icon\" ng-if=\"faviconImg\">
    <link rel=\"shortcut icon\" href=\"{{ faviconImg }}\" type=\"image/x-icon\" ng-if=\"faviconImg\">
    <!---------------------- Styles -------------------------->
    <!-- injector:css -->
    <link rel=\"stylesheet\" href=\"https://locator.transitcard.ru/resources/assets/css/vendor.css\">
    <link rel=\"stylesheet\" href=\"https://locator.transitcard.ru/resources/assets/css/styles.css\">
    <!-- endinjector -->

    <!-- injector:js -->
    <script src=\"https://locator.transitcard.ru/resources/assets/js/vendor.js\"></script>
    <script src=\"https://locator.transitcard.ru/resources/assets/js/app.js\"></script>
    <script src=\"https://locator.transitcard.ru/resources/assets/js/template.js\"></script>
    <!-- endinjector -->
</head>
<body class=\"map-body\" ng-controller=\"LocatorCtrl as main\" ng-init=\"initialize()\" style=\"overflow: visible;\">
    <div class=\"map-container\" ng-class=\"container\" ng-view></div>
    <div id=\"map\"/>
<!-- style=\"height: 100%; width: 100%; overflow-x: auto;\"  -->
<div analytics></div>
</body>
</html>
";


    }


    public function beforeAction($action)
    {
        if (parent::beforeAction($action)) {
            // change layout for error action
            if ($action->id == 'error') {
                $this->layout = 'clean';
            }

            return true;
        } else {
            return false;
        }
    }


    public function actionPumi($pumi)
    {
        assert($pumi);
    }


}
