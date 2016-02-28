<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\httpclient\Client;
use app\code\FeatureType;
use app\code\AnnotationType;
use app\models\UploadForm;
use yii\web\UploadedFile;

class CloudVisionController extends Controller {

    /**
     * Google Cloud Vision APIで画像認識するメソッド
     * @return type
     */
    public function actionIndex() {
        
        $model = new UploadForm();
        $result= '';
        if (Yii::$app->request->isPost) {         
            $model->imageFile = UploadedFile::getInstance($model, 'imageFile');
            $post_data = Yii::$app->request->post('UploadForm');
            $model->feature_type = $post_data['feature_type'];
            
            if ($model->upload()) {
                // file is uploaded successfully
                $file_contents = base64_encode(file_get_contents($model->getFilePath()));  //引数にファイルを指定
                $response = $this->execCloudVisionApi($file_contents, $model->feature_type);               // var_dump($response); exit;
                $annotation = AnnotationType::getAnnotation($model->feature_type);
                $result = empty($response['responses'][0][$annotation])?[]:$response['responses'][0][$annotation];                
            }
        }

        $feature_types = [
            FeatureType::LABEL_DETECTION => '画像コンテンツの認識 (ラベリング)', 
            FeatureType::TEXT_DETECTION => '画像内テキストの認識 (OCR)', 
            FeatureType::LOGO_DETECTION => '製品ロゴの認識',
            FeatureType::FACE_DETECTION => '顔認識', 
            FeatureType::LANDMARK_DETECTION => 'ランドマークの認識',
        ];
                
        return $this->render('index', compact('result', 'model', 'feature_types'));
    }
    
    /**
     * Cloud Vision APIを実行し、画像認識結果を取得する
     * @param type $image_data
     * @param type $type
     */
    private function execCloudVisionApi($image_data, $type) {
        $request = '{
            "requests": [{
                "image": {
                    "content": "' . $image_data . '"
                },
                "features": [{                               
                    "type": "' . $type . '"
                }]
            }]
        }';
        
        $client = new Client();
        $response = $client->createRequest()
                ->setMethod('post')
                ->setFormat(\yii\httpclient\Client::FORMAT_JSON)
                ->addHeaders(['content-type' => 'application/json'])
                ->setUrl(Yii::$app->params['cloud_vision_api_url'])
                ->setContent($request)
                ->send();
        if ($response->isOk) {
            return $response->data;
        }
        return [];
    }
}
