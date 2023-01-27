<?php

/* @var $this \yii\web\View */
/* @var $content string */

use app\widgets\Alert;
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <link rel="stylesheet" type="text/css" href="../../web/css/site.css"/>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php $this->registerCsrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
    <link rel="icon" href="/favicon.png">
</head>
<body>
<?php $this->beginBody() ?>

<main>
    <header>
        <div class="logo">
            <img src="/images/logo.png" alt="Board">
        </div>
        <nav>
            <?php if (!Yii::$app->user->isGuest): ?>
                <a href="/site/index">Main</a>
                <a href="/site/active">Active mode</a>
                <a href="/project/index">Projects</a>
                <a href="/alert/index">Alerts</a>
                <a href="/keyword/index">Keywords</a>
                <a data-method="POST" href="/user/logout">Logout</a>
            <?php endif; ?>
        </nav>
    </header>

    <?php if (!Yii::$app->user->isGuest): ?>
    <div class="mobile-nav">
        <div class="top-part">
            <div class="logo">
                <img src="/images/logo.png" alt="Board">
            </div>
            <a style="display: none" id="menu-close" href="#!"><span class="fa fa-close"></span></a>
            <a id="menu-open" href="#!"><span class="fa fa-list"></span></a>
        </div>

        <hr>

        <nav style="display: none" id="mobile-nav">
            <a href="/site/index">Main</a>
            <a href="/project/index">Projects</a>
            <a href="/alert/index">Alerts</a>
            <a href="/keyword/index">Keywords</a>
            <a data-method="POST" href="/user/logout">Logout</a>
        </nav>
    </div>
    <?php endif; ?>

    <div class="container">
        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
        <?= Alert::widget() ?>
        <?= $content ?>
    </div>
</main>


<footer class="footer">
</footer>

<?php \richardfan\widget\JSRegister::begin() ?>
<script>
    $(document).ready(function () {
        $('#menu-open').on('click', function () {
            $(this).hide()
            $('#menu-close').show()
            $('#mobile-nav').show()
        })

        $('#menu-close').on('click', function () {
            $(this).hide()
            $('#mobile-nav').hide()
            $('#menu-open').show()
        })


    })
</script>
<?php \richardfan\widget\JSRegister::end() ?>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
