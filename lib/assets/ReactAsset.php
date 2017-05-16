<?php
namespace bTokman\react\assets;

use yii\web\AssetBundle;

class ReactAsset extends AssetBundle
{
    public $js = [
        YII_ENV_DEV ?
            '../../build/react-bundle.js' : '../../build/react-bundle.min.js',
    ];
}

