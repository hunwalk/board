<?php

use app\records\Project;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel app\records\search\ProjectSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Projects');
$this->params['breadcrumbs'][] = $this->title;

\app\assets\HighlightAsset::register($this);
?>

<div class="project-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Create Project'), ['create'], ['class' => 'btn btn-success']) ?>
        <?= Html::a(Yii::t('app', 'Download board.js'), ['download-boardjs'], ['class' => 'btn']) ?>
    </p>
    <br>
    <p>Example push script: </p>
    <?php
    $hl = new \Highlight\Highlighter();
    $code = file_get_contents(Yii::getAlias('@webroot/js/push-script.js'));

    $highlighted = $hl->highlight('javascript', $code);

    echo "<pre><code class=\"hljs {$highlighted->language}\">";
    echo $highlighted->value;
    echo "</code></pre>";
    ?>

    <br>
    <br>

    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            [
                'attribute' => 'icon',
                'value' => function (Project $model) {
                    return Html::img($model->logo, ['style' => ['width' => '100px']]);
                },
                'format' => 'raw',
                'label' => '',
                'filter' => false
            ],
            'name',
            'api_push_key',
            'created_at',
            //'updated_at',

            ['class' => 'app\grid\ActionColumn'],
        ],
    ]); ?>

    <?php Pjax::end(); ?>

</div>
