<?php

use app\records\Alert;
use yii\helpers\Html;
use yii\web\YiiAsset;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\records\Alert */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Alerts'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
YiiAsset::register($this);

$sender = json_decode($model->sender);

$messages = [];
if ($model->type === 'log'){
    $messages = json_decode($model->body,true);
}

?>
<div class="alert-view">

    <?php if ($model->type == Alert::TYPE_HTML || $model->type == Alert::TYPE_TEXT): ?>
        <?= $model->body ?>
    <?php endif; ?>

    <?php if($model->type === 'log'): ?>
        <?php foreach ($messages as $message): ?>
            <?php
                $title = $message[0];
                $level = $message[1];
                $category = $message[2];
                $timestamp = $message[3];
                $trace = $message[5];
            ?>
            <h1><?= is_string($title) ? $title : json_encode($title) ?></h1>
            <h4 style="color: #1c7430"><?= $category ?></h4>
            <span style="color: grey"><?= date('Y-m-d H:i:s',$timestamp)?></span>
            <hr>

            <p style="white-space: pre-wrap"><?= dump($trace) ?></p>
        <?php endforeach; ?>
    <?php endif; ?>

    <?php if (\yii\helpers\ArrayHelper::isIn($model->type, ['error'])): ?>
        <p style="white-space: pre-wrap"><?= json_decode($model->body)->stackTraceString ?></p>
    <?php endif; ?>

    <?php if (\yii\helpers\ArrayHelper::isIn($model->type, ['error','json'])): ?>
        <?php dump(json_decode($model->body)) ?>
    <?php endif; ?>

    <hr>

    <?= $model->render() ?>
    <p>
        <code><strong>alert_sender</strong></code><br>
        <?php if ($sender): ?>
            <?php foreach ($sender as $key => $value): ?>
                <code><?= $key ?>: <?= $value ?></code><br>
            <?php endforeach; ?>
        <?php endif; ?>
    </p>

    <code><strong>body</strong></code><br>
    <code>type: <?= $model->type ?><br></code>

</div>