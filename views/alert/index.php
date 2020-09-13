<?php

use app\records\Alert;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel app\records\search\AlertSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Alerts');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="alert-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Create Alert'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [

//            'id',
            [
                'attribute' => 'project_id',
                'value' => function (Alert $model) {
                    return Html::img($model->project->logo,['style'=>['width' => '50px']]);
                },
                'format' => 'raw',
                'label' => 'Project'
            ],
            'title',
//            'body:ntext',
            'type',
            //'created_at',
            //'updated_at',

            ['class' => 'app\grid\ActionColumn'],
        ],
    ]); ?>

    <?php Pjax::end(); ?>

</div>
