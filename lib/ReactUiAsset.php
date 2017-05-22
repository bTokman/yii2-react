<?php
namespace bTokman\react;

use yii\web\AssetBundle;

/**
 * Class ReactUiAsset
 * @package bTokman\react
 */
class ReactUiAsset extends AssetBundle
{
    /**
     * @inheritdoc
     */
    public $sourcePath = __DIR__ . '/assets';

    public $js = [
        YII_ENV_DEV ?
            'reactUi.js' : 'reactUi.min.js'
    ];

    public $depends = [
        'bTokman\react\ReactAsset'
    ];
}