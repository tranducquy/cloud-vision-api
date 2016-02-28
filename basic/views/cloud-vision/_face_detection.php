<table class="table">
    <thead>
        <tr class="filters">                                        
            <th>Image</th>
            <th>#</th>
            <th>Description</th>                                        
            <th>Score</th>            
        </tr>
    </thead>
    <tbody>   
        <?php foreach ($result as $index => $annotation) { ?>        
            <tr>                                       
                <?php if ($index == 0) { ?>
                    <td rowspan="<?= count($result) ?>"><img style="max-height: 300px; max-width: 300px;" src="<?= Yii::$app->homeUrl . '/uploads/' . $model->imageFile->baseName . '.' . $model->imageFile->extension ?>" /></td>
                    <?php } ?>
                <td><?= $index + 1 ?></td>                                        
                <td><?php $ret = array_slice($annotation, 8, 12);
                        foreach($ret as $key => $value) {
                            echo "$key : $value <br/>";
                        }
                    ?>
                </td>                
                <td><?= empty($annotation['detectionConfidence']) ? '-' : $annotation['detectionConfidence'] ?></td>                                        
            </tr>  
        <?php } ?>
    </tbody>
</table>    
