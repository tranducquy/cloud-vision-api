<?php

use yii\widgets\ActiveForm;

/* @var $this yii\web\View */

$this->title = 'My Cloud Vision API Test Application';
?>
<div class="site-index">

    <div class="jumbotron">
        <h1>Google Cloud Vision API</h1>

        <p class="lead">Googleの強力な機械学習モデルの能力を活用する画像認識サービスを使ってみる</p>

        <p>
            <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]) ?>
            <?= $form->field($model, 'imageFile')->fileInput() ?>
            <?= $form->field($model, 'feature_type')->dropDownList($feature_types) ?>
            <button type="submit" class="btn btn-lg btn-success">画像認識！</button>
<?php ActiveForm::end() ?>
        </p>
    </div>
<?php if (!empty($result)) { ?>
    <div class="body-content">
        <div class="row">
            <div class="col-lg-9">
                <h2>画像認識結果</h2>
                <p>                    
                    <div class="row">
                        <div class="panel panel-primary filterable">
                            <div class="panel-heading">
                                <h3 class="panel-title"><?= $feature_types[$model->feature_type] ?></h3>                
                            </div>
                            <?php if($model->feature_type == \app\code\FeatureType::FACE_DETECTION) {
                                echo $this->render( '_face_detection', ['result' => $result, 'model' => $model]);
                             } else { 
                                echo $this->render( '_normal_detection', ['result' => $result, 'model' => $model]);
                             } ?>
                        </div>
                        <h2>Raw Response Data</h2>
                        <div class="panel panel-primary" style="word-wrap: break-word;">
                            <?= json_encode($result) ?>
                        </div>
                    </div>                    
                </p>                
            </div>            
        </div>
    </div>
    <?php } ?>
</div>
