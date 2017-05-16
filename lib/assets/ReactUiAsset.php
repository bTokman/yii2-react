<?php
namespace bTokman\react\assets;

use yii\web\AssetBundle;

class ReactUiAsset extends AssetBundle
{
    /**
     * @inheritdoc
     */
    public $sourcePath = '@bTokman/web/build';

    public $js = [
        YII_ENV_DEV ?
        'reactUi.js' :  'reactUi.min.js'
    ];

    public $depends = [
        'app\assets\ReactAsset'
    ];
}