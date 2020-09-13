<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\records\Alert */
/* @var $form yii\widgets\ActiveForm */


?>

<div class="alert-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'project_id')
        ->dropDownList(\yii\helpers\ArrayHelper::map(\app\records\Project::find()->all(),'id', 'name'))
        ->label('Project')
    ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'body')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'type')->dropDownList($model->types) ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
