<?php

namespace app\controllers;

use app\models\SaveForm;
use Yii;
use yii\filters\AccessControl;
use yii\httpclient\Client;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use app\models\anticaptcha\AntiCaptcha;
use app\models\anticaptcha\ImageToText;
class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        $model = new SaveForm();

        return $this->render('index', [
            'model' => $model
        ]);
    }

    public function actionParse(){
        $api = new ImageToText();
        $api->setVerboseMode(true);
        $api->setKey("7ab1a26549ec3798e80e61e3feaeed7e");
        $api->setFile("http://kgd.gov.kz/apps/services/CaptchaWeb/generate?uid=8f752b8d-c6c2-4c57-9561-2e70efb1139b&t=a14e60a2-422c-427b-b7b0-32d97999c237");
        if (!$api->createTask()) {
            $api->debout("API v2 send failed - ".$api->getErrorMessage(), "red");
            return false;
        }
        $taskId = $api->getTaskId();
        if (!$api->waitForResult()) {
            $api->debout("could not solve captcha", "red");
            $api->debout($api->getErrorMessage());
        } else {
            echo "\nhash result: ".$api->getTaskSolution()."\n\n";
        }
//        $client = new Client();
//        $response = $client->createRequest()
//            ->setMethod('POST')
//            ->setUrl('http://kgd.gov.kz/ru/apps/services/culs-taxarrear-search-web/resources/rest/search')
//            ->setData(['iinBin' => '791005350297', 'captcha-user-value' => 'XDCOB'])
//            ->send();
//        if ($response->isOk) {
//            $newUserId = $response->data['id'];
//        }


    }
    /**
     * Login action.
     *
     * @return Response|string
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }

        $model->password = '';
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Displays contact page.
     *
     * @return Response|string
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        }
        return $this->render('contact', [
            'model' => $model,
        ]);
    }

    /**
     * Displays about page.
     *
     * @return string
     */
    public function actionAbout()
    {
        return $this->render('about');
    }
}
