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
    public $sourcePath = '@npm/react/cjs';


    public $js = YII_ENV_DEV ?
        [
            'react.development.js',
        ] :
        [
            'react.production.min.js',
        ];
}

