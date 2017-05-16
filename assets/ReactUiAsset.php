<?php
namespace bTokman\react\assets;

use yii\web\AssetBundle;

class ReactUiAsset extends AssetBundle
{
    public $js = [
        YII_ENV_DEV ?
        '../build/reactUi.js' :  '../build/reactUi.min.js'
    ];

    public $depends = [
        'app\assets\ReactAsset'
    ];
}