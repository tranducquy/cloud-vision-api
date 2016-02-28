<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use yii\httpclient\Client;

class SiteController extends Controller {

    public function behaviors() {
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

    public function actions() {
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

    public function actionIndex() {
        $image_path = 'C:\Users\usr0101836\Documents\blog\google vision api\gmo_en.jpg';
        //$image_path = 'C:\Users\usr0101836\Documents\blog\google vision api\manga.jpg';
        //$image_path = 'C:\Users\usr0101836\Documents\blog\google vision api\gmo_jp.jpg';
        //$image_path = 'C:\Users\usr0101836\Documents\blog\google vision api\zcom.jpg';
        //$image_path = 'C:\Users\usr0101836\Documents\blog\google vision api\faulkner.jpg';
        //$image_path = 'C:\Users\usr0101836\Documents\blog\google vision api\train.jpeg';
        $file_contents = base64_encode(file_get_contents($image_path));  //引数にファイルを指定
       // var_dump($file_contents);
        //$file_contents = base64_encode('aaaaa');
        $request = '{
            "requests": [
                {
                    "image": {
                        "content": "' . $file_contents . '"
                    },
                    "features": [
                            {                               
                                "type": "TEXT_DETECTION"
                            }
                    ]
                }
            ]
        }';
// //"type": "LABEL_DETECTION"
//        $ch = curl_init();
//curl_setopt($ch, CURLOPT_URL,            "https://vision.googleapis.com/v1/images:annotate?key=AIzaSyCkMxGCvfzznceqMDxaSoLpP4t660cd4Kc" );
//curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1 );
//curl_setopt($ch, CURLOPT_POST,           1 );
//curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0); // for testing purposes
//curl_setopt($ch, CURLOPT_POSTFIELDS,     $request ); 
//curl_setopt($ch, CURLOPT_HTTPHEADER,     array('Content-Type: application/json')); 
//$result=curl_exec ($ch);
//var_dump($result);exit;
       
        $client = new Client();
        $response = $client->createRequest()
                ->setMethod('post')
                ->setFormat(\yii\httpclient\Client::FORMAT_JSON)
                ->addHeaders(['content-type' => 'application/json'])
                ->setUrl('https://vision.googleapis.com/v1/images:annotate?key=AIzaSyCkMxGCvfzznceqMDxaSoLpP4t660cd4Kc')
                ->setContent($request)
                ->send();
        if ($response->isOk) {
            $result = $response->data;
        }
        var_dump(json_encode($result));exit;
        return $this->render('index');
    }

    public function actionLogin() {
        if (!\Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }
        return $this->render('login', [
                    'model' => $model,
        ]);
    }

    public function actionLogout() {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    public function actionContact() {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        }
        return $this->render('contact', [
                    'model' => $model,
        ]);
    }

    public function actionAbout() {
        return $this->render('about');
    }

}
