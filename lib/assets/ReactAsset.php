<?php
namespace bTokman\react\assets;

use yii\web\AssetBundle;

class ReactAsset extends AssetBundle
{
    /**
     * @inheritdoc
     */
    public $sourcePath = '@bTokman/web/build';


    public $js = [
        YII_ENV_DEV ?
            'react-bundle.js' : '.react-bundle.min.js',
    ];
}

