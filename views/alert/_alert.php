<?php
 /** @var \app\records\Alert $model */

use yii\helpers\Html;
?>

<div class="board-alert">
    <div class="alert-sub">
        <img src="<?= $model->project->logo ?>" alt="<?= $model->project->name ?>">
    </div>
    <div class="alert-main">
        <a href="<?= \yii\helpers\Url::to(['alert/view', 'id' => $model->id])?>"><h1><?= $model->title ?></h1></a>
        <span class="alert-date"><?= Yii::$app->formatter->asDatetime($model->created_at) ?></span>
        <br><br>
        <div class="keyword-container">
            <?php foreach ($model->keywords as $keyword): ?>
                <?= $keyword->render() ?>
            <?php endforeach; ?>
        </div>
        <div class="action-container">
            <?php
            //TODO: create a freakin widget for this
            $url = ['/alert/view','id' => $model->id];
            $icon = Html::tag('span', '', ['class' => "fa fa-eye"]);
            echo  Html::a($icon, $url, []);
            ?>

            <?php
            //TODO: create a freakin widget for this
            $url = ['/alert/update','id' => $model->id];
            $icon = Html::tag('span', '', ['class' => "fa fa-pencil"]);
            echo  Html::a($icon, $url, []);
            ?>

            <?php
            //TODO: create a freakin widget for this
            $url = ['/alert/delete','id' => $model->id];
            $icon = Html::tag('span', '', ['class' => "fa fa-trash"]);
            echo  Html::a($icon, $url, ['class' => 'alert-delete']);
            ?>
        </div>
    </div>
</div>
