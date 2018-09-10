<?php

namespace bTokman\react;

use yii\web\AssetBundle;

class ReactDomAsset extends AssetBundle
{
    /**
     * @inheritdoc
     */
    public $sourcePath = '@npm/react-dom/dist';


    public $js = YII_ENV_DEV ?
        [
            'react-dom.js',
            'react-dom-server.js',
        ] :
        [
            'react-dom.min.js',
            'react-dom-server.min.js',
        ];
}