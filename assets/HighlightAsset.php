<?php

namespace app\assets;

use yii\web\AssetBundle;

class HighlightAsset extends AssetBundle
{
    public $sourcePath = '@vendor/scrivo/highlight.php/styles';

    public $css = [
        'dark.css'
    ];
}