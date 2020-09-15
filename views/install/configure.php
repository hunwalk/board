<?php
/** @var \app\models\ConfigureForm $model */
use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = 'Installing Board | Config';

?>

<div class="install-configure">
    <div class="configure-container">
        <h1>Configure board</h1>
        <p>Please fill out this form to connect to your database</p>
        <?php $form = ActiveForm::begin([
            'id' => 'configure-form',
        ]) ?>

        <?= $form->field($model, 'dbDriver')->textInput(['placeholder' => 'mysql']); ?>

        <?= $form->field($model, 'dbHost')->textInput(['placeholder' => 'localhost']); ?>

        <?= $form->field($model, 'dbPort')->textInput(['placeholder' => '3306']) ?>

        <?= $form->field($model, 'dbName')->textInput(['placeholder' => 'board']) ?>

        <?= $form->field($model, 'dbUser')->textInput(['placeholder' => 'root']) ?>

        <?= $form->field($model, 'dbPassword')->passwordInput() ?>

        <?= $form->field($model, 'dbCharset')->textInput(['placeholder' => 'utf8']) ?>

        <?= Html::submitButton(
            Yii::t('app', 'Next'),
            ['class' => 'btn']
        ) ?>

        <?php ActiveForm::end(); ?>
    </div>
</div>
