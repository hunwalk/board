<?php

use kartik\color\ColorInput;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\records\Keyword */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="keyword-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'alert_id')
        ->dropDownList(\yii\helpers\ArrayHelper::map(\app\records\Alert::find()->all(),'id', 'title'))
        ->label('Alert')
    ?>

    <?= $form->field($model, 'keyword_id')
        ->dropDownList(\yii\helpers\ArrayHelper::map(\app\records\Keyword::find()->all(),'id', 'name'))
        ->label('Keyword')
    ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
