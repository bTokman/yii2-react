<?php
namespace bTokman\react;

use yii\web\AssetBundle;

class ReactAsset extends AssetBundle
{
    /**
     * @inheritdoc
     */
    public $sourcePath = __DIR__ . '/assets';


    public $js = [
        YII_ENV_DEV ?
            'react-bundle.js' : '.react-bundle.min.js',
    ];
}

