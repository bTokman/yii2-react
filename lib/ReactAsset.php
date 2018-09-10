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
    public $sourcePath = '@npm/react';


    public $js = YII_ENV_DEV ?
        [
            'react.js',
        ] :
        [
            'react.min.js',
        ];
}

