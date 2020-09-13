<?php

/* @var $this yii\web\View */
/** @var \yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Main';

$dataProvider->prepare();
$models = $dataProvider->getModels();
?>
<br>
<a id="clear-all" href="#!" class="btn">Clear All</a>
<br>
<br>
<div class="site-index">
    <?php foreach ($models as $model): ?>
        <?= $this->render('/alert/_alert',[
            'model' => $model
        ]) ?>
    <?php endforeach; ?>
</div>

<?php \richardfan\widget\JSRegister::begin() ?>
<script>
    $(document).ready(function () {
        let lastAlertId = '<?= $models ? $models[0]->id : '0' ?>'

        $(document).on('click', '.alert-delete', function (e){
            e.preventDefault();
            $(this).closest('.board-alert').slideUp();

            $.post($(this).attr('href'),{noRedirect: true},null)
        })

        $(document).on('click', '#clear-all', function (){
            console.log('clear-all')
            $.post('/api/v1/alert/clear-all',{},null)
            $('.site-index .board-alert').fadeOut('slow')
            lastAlertId = 0
        })

        setInterval(function () {
            $.get('/api/v1/alert/pull-any?lastAlertId=' + lastAlertId,function (response) {
                if (response && response.hasOwnProperty('alert')){
                    lastAlertId = response.alert.id
                    $(response.content).hide().prependTo('.site-index').slideDown()
                }
            })
        },5000)
    })
</script>
<?php \richardfan\widget\JSRegister::end() ?>
