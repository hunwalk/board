<?php

use dektrium\user\widgets\Connect;
use dektrium\user\models\LoginForm;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/**
 * @var yii\web\View $this
 * @var dektrium\user\models\LoginForm $model
 * @var dektrium\user\Module $module
 */

$this->title = Yii::t('user', 'Sign in');
?>


<div class="site-login">
    <?php $form = ActiveForm::begin([
        'id' => 'login-form',
        'enableAjaxValidation' => true,
        'enableClientValidation' => false,
        'validateOnBlur' => false,
        'validateOnType' => false,
        'validateOnChange' => false,
    ]) ?>

    <?= $form->field($model, 'login',
        ['inputOptions' => ['autofocus' => 'autofocus', 'class' => 'form-control', 'tabindex' => '1']]
    ); ?>

    <?= $form->field(
        $model,
        'password',
        ['inputOptions' => ['class' => 'form-control', 'tabindex' => '2']])
        ->passwordInput()
    ?>

    <?= $form->field($model, 'rememberMe')->checkbox(['tabindex' => '3']) ?>

    <?= Html::submitButton(
        Yii::t('user', 'Sign in'),
        ['class' => 'login-btn', 'tabindex' => '4']
    ) ?>

    <?php ActiveForm::end(); ?>
</div>
