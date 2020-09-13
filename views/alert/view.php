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
?>
<div class="alert-view">

    <?= $model->render() ?>
    <p>
        <code><strong>alert_sender</strong></code><br>
        <?php foreach ($sender as $key => $value): ?>
            <code><?= $key ?>: <?= $value ?></code><br>
        <?php endforeach; ?>
    </p>

    <p>
        <code><strong>body</strong></code><br>
        <code>type: <?= $model->type ?><br>
        <?php if ($model->type == Alert::TYPE_HTML || $model->type == Alert::TYPE_TEXT): ?>
            <?= $model->body ?>
        <?php endif; ?>

        <?php if (\yii\helpers\ArrayHelper::isIn($model->type, ['error'])): ?>
            <p style="white-space: pre-wrap"><?= json_decode($model->body)->stackTraceString ?></p>
        <?php endif; ?>

        </code>

        <?php if (\yii\helpers\ArrayHelper::isIn($model->type, ['error','json'])): ?>
            <?php dump(json_decode($model->body)) ?>
        <?php endif; ?>
    </p>

</div>
