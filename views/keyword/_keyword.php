<?php

/**
 * @var Keyword $model
 */

use app\records\Keyword;

?>

<a href="<?= \yii\helpers\Url::to(['keyword/view','id' => $model->id])?>" class="keyword" style="background: <?= $model->color?>; color: <?= $model->textColor ?>">
    <?= $model->name ?>
</a>