<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use app\models\PariMatch;

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
        return $this->render('index');
    }


    public function actionRegister() {
        Yii::$app->controller->enableCsrfValidation = false;
//        if (Yii::$app->request->isAjax) {
            Yii::$app->response->format = 'json';
//            $amount = (double)Yii::$app->request->post('value1', '');

        $ref = (double)Yii::$app->request->post('ref', '');
        $number = (double)Yii::$app->request->post('number', '');
        $ref = null;
        $number = 255111212111;
            $pm = new PariMatch();
            $res = $pm->createRegister($ref, $number);
            var_dump($res['data']['userId']);die();

//            if ($answer['result'] == 'ok') {
//                return [
//                    'msg' => 'ok',
//                    'status'=>'Транзакция создана успешно',
//                    'result'=>$answer,
//                    'transaction' => $transaction
//                ];
//            } else {
//                return ['msg' => 'error','status'=>$answer];
//            }
//        }
    }
    public function actionCheck () {
        Yii::$app->controller->enableCsrfValidation = false;
        Yii::$app->response->format = 'json';

        $code = "tuohyzxljb";
        $user_id = 194124;
        $pm = new PariMatch();
        $res = $pm->checkCode($code,$user_id);
        var_dump($res->data->userId);die();
    }


    public function actionLogin () {
        Yii::$app->controller->enableCsrfValidation = false;
        Yii::$app->response->format = 'json';

        $number = 123223121;
        $password = "qwerty123";
        $pm = new PariMatch();
        $res = $pm->login($number, $password);
        var_dump($res);die();
    }
}
