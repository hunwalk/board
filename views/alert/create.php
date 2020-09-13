<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\records\Alert */

$this->title = Yii::t('app', 'Create Alert');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Alerts'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="alert-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
