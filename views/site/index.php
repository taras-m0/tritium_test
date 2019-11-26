<?php
use \yii\helpers\Html;
use \yii\widgets\ActiveForm;

/* @var $this yii\web\View */

$this->title = 'My Yii Application';
?>
<div class="site-index">

    <div class="content-model-form">
        <?php $form = ActiveForm::begin(); ?>

        <?= $form->field($model, 'csv')->fileInput(['multiple' => false, 'accept' => '*/*'])->label('CSV File'); ?>

        <div class="form-group">
            <?= Html::submitButton(Yii::t('app', 'Загрузить'), ['class' => 'btn btn-primary']) ?>
        </div>

        <?php ActiveForm::end(); ?>
    </div>
</div>
