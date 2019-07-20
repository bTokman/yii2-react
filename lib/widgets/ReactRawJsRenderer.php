<?php


namespace bTokman\react\widgets;


/**
 * Class ReactRenderer - yii2 widget to server-side react rendering
 * and implementing it on client side.
 * This widget require V8JS PHP extension: http://php.net/v8js
 * @package bTokman\react\widgets
 */
class ReactRawJsRenderer extends ReactRenderer
{


    public
        /**
         * raw js
         * @var string
         */
        $js;

    /**
     * Get source component js for ReactJs constructor
     * @return string
     */
    protected function getSourceJs()
    {
        return $this->js;
    }


}