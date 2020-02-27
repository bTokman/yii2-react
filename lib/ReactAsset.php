<?php
namespace bTokman\react;

use yii\web\AssetBundle;

/**
 * Class ReactAsset
 * @package bTokman\react
 */
class ReactAsset extends AssetBundle
{
    /**
     * @inheritdoc
     */
    public $sourcePath = __DIR__ . '/assets';


    public $js = [
        'react' => YII_ENV_DEV ? 'react-bundle.js' : 'react-bundle.min.js'
    ];
}

