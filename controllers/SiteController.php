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
        $session = Yii::$app->session;
        $session->open();
        $user_data = $session->get('user_data');
        $session->close();
        return $this->render('index', ['user_data' => $user_data]);
    }


    public function actionRegister() {
//        Yii::$app->controller->enableCsrfValidation = false;
        if (Yii::$app->request->isAjax) {
            Yii::$app->response->format = 'json';

            $ref = Yii::$app->request->post('ref', 'test');
            $number = Yii::$app->request->post('number', '');

            if (empty($ref) || empty($number) || strlen($number) !== 12) {
                return [
                    'status' => "fail"
                ];
            }

            $password = "";
            do {
                $password = Yii::$app->security->generateRandomString(7);
            } while ( preg_match('/\w*[A-Z]\w*[0-9]\w*/', $password) !== 1 && strlen($password) === 7 );

            $pm = new PariMatch();
            $res = $pm->createRegister($ref, $number, $password);
//            return [
//                'status' => 'ok',
//                'number' => 127746355,
//                'password' => 'Pm12345'
//            ];
            if ($res['code'] == 200) {

                $session = Yii::$app->session;
                $session->open();
                $session->set('user_data', array(
                    'userId' => $res['data']['userId'],
                    'number' => $number,
                    'password' => $password,
                    'step' => 2
                ));
                $session->close();

                return [
                    'status' => "ok",
                    'data' => $res,
                    'userId' => $res['data']['userId'],
                    'number' => $number,
                    'password' => $password
                ];
            } else {
                return [
                    'status' => "fail",
                    'data' => $res
                ];
            }
        } else {
            $this->redirect('/');
        }
    }
    public function actionCheck () {
        if (Yii::$app->request->isAjax) {
            Yii::$app->response->format = 'json';

            $code = (int)Yii::$app->request->post('code', '');
            $user_id = (int)Yii::$app->request->post('user_id', '');
            $password = (string)Yii::$app->request->post('password', '');
            $number = (int)Yii::$app->request->post('number', '');

            if (empty($code) || empty($user_id) || empty($number) || empty($password) || strlen($number) !== 12 || strlen($password) !== 7) {
                return [
                    'status' => "fail"
                ];
            }
            $pm = new PariMatch();
            $res = $pm->checkCode($code, $user_id, $password);
            if ($res['code'] == 200) {

                $session = Yii::$app->session;
                $session->open();
                $session->remove('user_data');
                $session->close();
                $sms = $pm->sendSms($number, $password);
                return [
                    'status' => "ok",
                    'data' => $res
                ];
            } else {
                return [
                    'status' => "fail",
                    'data' => $res
                ];
            }
        } else {
            $this->redirect('/');
        }
    }

//    public function actionLogin () {
////        Yii::$app->controller->enableCsrfValidation = false;
//        if (Yii::$app->request->isAjax) {
//            Yii::$app->response->format = 'json';
//
//            $number = (int)Yii::$app->request->post('number', '');
//            $password = (string)Yii::$app->request->post('password', '');
//
////            $number = "000127746355";
////            $password = "Pm12345";
//            $pm = new PariMatch();
//            $res = $pm->login($number, $password);
//
//            if ($res['code'] == 200) {
//
//                preg_match('/X-ODDS-SESSION: (?P<value>(.*?)\n)/', $res['headers'], $matches);
//                $res['href'] = "https://parimatch.co.tz/?sessionAuth=".trim($matches['value']);
//                return [
//                    'status' => "ok",
//                    'data' => $res
//                ];
//            } else {
//                return [
//                    'status' => "fail",
//                    'data' => $res
//                ];
//            }
//        }
//    }
}
