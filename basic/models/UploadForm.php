<?php

namespace app\models;

use yii\base\Model;

class UploadForm extends Model
{
    /**
     * @var imageFile
     */
    public $imageFile;
        
    /**
     * @var type 
     */
    public $feature_type;

    public function rules()
    {
        return [
            [['imageFile'], 'file', 'skipOnEmpty' => false, 'checkExtensionByMimeType'=>false, 'extensions' => ['jpg', 'png']],
        ];
    }

    public function getFilePath() {
        if (empty($this->imageFile)) {
            return '';
        }
        return \Yii::getAlias('@webroot') . '/uploads/' . $this->imageFile->baseName . '.' . $this->imageFile->extension;
    }


    public function upload()
    {
        if ($this->validate()) {
            $this->imageFile->saveAs($this->getFilePath());
            return true;
        } else {
            return false;
        }
    }
}