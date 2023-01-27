<?php

/* @var View $this  */
/* @var string $keyword  */
/** @var ActiveDataProvider $dataProvider */

use yii\data\ActiveDataProvider;
use yii\web\View;

$dataProvider->prepare();
$models = $dataProvider->getModels();
?>

<div class="site-active">

</div>

<?php \richardfan\widget\JSRegister::begin() ?>
<script>
    $(document).ready(function () {

        // var ctx = document.getElementById('pingchart');
        // var chart = new Chart(ctx, {
        //     type: 'bar',
        //     data: {
        //         labels: ['red', 'blue'],
        //         datasets: [{
        //             label: 'Ping',
        //             data: [3,3],
        //             borderWidth: 1
        //         }]
        //     },
        //     options: {
        //         scales: {
        //             yAxes: [{
        //                 ticks: {
        //                     beginAtZero: true
        //                 }
        //             }]
        //         }
        //     }
        // });

        let lastAlertId = '<?= $models ? $models[0]->id : '0' ?>'


        // console.log()
        // console.log(chart.data.datasets)

        setInterval(function () {
            if (<?= $keyword ? 'true' : 'false' ?>){
                $.get('/api/v1/alert/active-pull-any-keyword?lastAlertId=' + lastAlertId + '&keyword=' + "<?= $keyword ?>",function (response) {
                    if (response && response.hasOwnProperty('alert')){
                        lastAlertId = response.alert.id
                        $('.site-active').fadeOut(500, function (){
                            $('.site-active').html(response.content).fadeIn(500)
                        })
                    }
                })
            }else {
                $.get('/api/v1/alert/active-pull-any?lastAlertId=' + lastAlertId,function (response) {
                    if (response && response.hasOwnProperty('alert')){
                        lastAlertId = response.alert.id
                        $('.site-active').fadeOut(500, function (){
                            $('.site-active').html(response.content).fadeIn(500)
                        })
                    }
                })
            }


            // $.get('/api/v1/alert/get-pings?project_id=1&handle=visitor',function (response) {
            //     if (response && response.hasOwnProperty('timestamps')){
            //         response.timestamps.map(function(timestamp, index){
            //             chart.data.labels[index] = timestamp.label
            //             chart.data.datasets[0].data[index] = timestamp.count;
            //             chart.update();
            //         })
            //     }
            // })



        },2000)



        function addData(chart, label, data) {
            chart.data.labels.push(label);
            chart.data.datasets.forEach((dataset) => {
                dataset.data.push(data);
            });
            chart.update();
        }
    })
</script>
<?php \richardfan\widget\JSRegister::end() ?>
