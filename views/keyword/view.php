<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\records\Keyword */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Keywords'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
$alerts = $model->getAlerts()->orderBy(['created_at' => SORT_DESC])->all();
?>
<div class="keyword-view">

    <?= $model->render() ?>
    <br><br>
    <p>
        <?= Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ]) ?>
        <?= Html::a(Yii::t('app', 'Assign Keyword'), ['assign', 'id' => $model->id], ['class' => 'btn btn-success']) ?>
        <?= Html::a(Yii::t('app', '[ACTIVE MODE]: '.$model->name), ['/site/active', 'keyword' => $model->name], ['class' => 'btn btn-success']) ?>
    </p>
    <br><br>

    <div class="alert-index">
        <?php foreach ($model->alerts as $alert): ?>
            <?= $alert->render() ?>
        <?php endforeach; ?>
    </div>


</div>

<?php \richardfan\widget\JSRegister::begin() ?>
<script>
    $(document).ready(function () {
        let lastAlertId = '<?= $alerts ? $alerts[0]->id : '0' ?>'

        $(document).on('click', '.alert-delete', function (e){
            e.preventDefault();
            $(this).closest('.board-alert').slideUp();

            $.post($(this).attr('href'),{noRedirect: true},null)
        })

        $(document).on('click', '#clear-all', function (){
            console.log('clear-all')
            $.post('/api/v1/alert/clear-all',{},null)
            $('.alert-index .board-alert').fadeOut('slow')
            lastAlertId = 0
        })

        setInterval(function () {
            $.get('/api/v1/alert/pull-any?lastAlertId=' + lastAlertId + '&keyword=' + "<?= $model->name ?>",function (response) {
                if (response && response.hasOwnProperty('alert')){
                    lastAlertId = response.alert.id
                    $(response.content).hide().prependTo('.alert-index').slideDown()
                }
            })
        },5000)
    })
</script>
<?php \richardfan\widget\JSRegister::end() ?>
