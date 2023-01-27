<?php

use app\records\Alert;
use yii\helpers\ArrayHelper;
use yii\web\YiiAsset;

/* @var $this yii\web\View */
/* @var $model app\records\Alert */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Alerts'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
YiiAsset::register($this);

$sender = json_decode($model->sender);
$messages = [];

if ($model->type === 'log') {
    $messages = json_decode(json_decode($model->body), true);
    $messages = ArrayHelper::getValue($messages,'messages');
    dump($messages);
    dump($messages[1][2]);
}
?>
<div class="alert-view">

    <?= $model->render() ?>
    <p>
        <code><strong>alert_sender</strong></code><br>
        <?php if ($sender): ?>
            <?php foreach ($sender as $key => $value): ?>
                <code><?= $key ?>: <?= $value ?></code><br>
            <?php endforeach; ?>
        <?php endif; ?>
    </p>

    <p>
        <code><strong>body</strong></code><br>
        <code>type: <?= $model->type ?></code>
    </p>
            <?php if ($model->type == Alert::TYPE_HTML || $model->type == Alert::TYPE_TEXT): ?>
                <?= $model->body ?>
            <?php endif; ?>

            <?php if ($model->type === 'log'): ?>
                <?php foreach ($messages as $message): ?>
                    <?php
                    $log = $message[0];
                    $level = $message[1];
                    $category = $message[2];
                    $timestamp = $message[3];
                    $trace = $message[4];
                    $memory = $message[5];
                    ?>
                    <?php if($category === 'application'): ?>
                        <code>
                            <?= $log ?>
                        </code>
                    <?php else: ?>
                        <h1><?= is_string($log) ? $log : json_encode($log) ?></h1>
                    <?php endif; ?>
                    <h4 style="color: #1c7430"><?= $category ?></h4>
                    <span style="color: grey"><?= date('Y-m-d H:i:s', $timestamp) ?></span>
                    <?php dump($trace) ?>
                    <hr>
                <?php endforeach; ?>
            <?php endif; ?>

    <?php if (ArrayHelper::isIn($model->type, ['error'])): ?>
        <p style="white-space: pre-wrap"><?= json_decode($model->body)->stackTraceString ?></p>
    <?php endif; ?>


    <?php if (ArrayHelper::isIn($model->type, ['error', 'json'])): ?>
        <?php dump(json_decode($model->body)) ?>
    <?php endif; ?>

</div>
