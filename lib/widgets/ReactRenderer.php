<?php


namespace bTokman\react\widgets;


use ReactJS;
use yii\base\Widget;
use yii\web\NotFoundHttpException;
use bTokman\react\ReactAsset;
use bTokman\react\ReactUiAsset;


/**
 * Class ReactRenderer - yii2 widget to server-side react rendering
 * and implementing it on client side.
 * This widget require V8JS PHP extension: http://php.net/v8js
 * @package app\widgets
 */
class ReactRenderer extends Widget
{


    public
        /**
         * Path to your React components js file
         * @var string
         */
        $componentsSourceJs,
        /**
         * Component name
         * @var string
         */
        $component,
        /**
         * React component props
         * @var array
         */
        $props,
        /**
         * Options for html attributes
         * @var array
         */
        $options;


    private $react = null;
    /**
     * Path to React bundle, must contain:
     * React Js : https://www.npmjs.com/package/react
     * React-dom Js : https://www.npmjs.com/package/react-dom
     * React-dom-server from React-dom package
     * @var string
     */
    private $reactSourceJs;
    private $defaultOptions;

    /**
     * Initializes the widget.
     * This renders the form open tag.
     */
    public function init()
    {
        if (empty($this->componentsSourceJs) || !file_exists($this->componentsSourceJs)) {
            throw new NotFoundHttpException('React component source js file doesn\'t exist');
        }

        /**
         *  Default options, "tag" - place to render react app - default to "div"
         *  "preload" - tell to widget render your react app on server side - default to true
         */
        $this->defaultOptions = [
            'tag' => 'div',
            'preload' => true
        ];
        parent::init();
    }

    /**
     * Runs the widget.
     */
    public function run()
    {
        $this->applyJs();
        return $this->renderReact();
    }


    /**
     * Get ReactJs server side render instance
     * @return ReactJS
     */
    private function getReact()
    {
        if ($this->react === null) {
            $this->react = new ReactJS($this->getReactSource(), $this->getSourceJs());
        }
        return $this->react;
    }

    /**
     * Get react source Js bundle
     * @return string
     */
    private function getReactSource()
    {
        if ($this->reactSourceJs === null) {
            $this->reactSourceJs = file_get_contents((new ReactAsset())->js[0]);
        }
        return $this->reactSourceJs;
    }

    /**
     * Apply js in view
     */
    public function applyJs()
    {
        ReactAsset::register($this->view);
        $this->getView()->registerJsFile($this->componentsSourceJs, ['depends' => 'app\assets\ReactAsset']);
        ReactUiAsset::register($this->view);

    }

    /**
     * Rendering function
     * @return string
     */
    public function renderReact()
    {
        $options = array_merge($this->defaultOptions, $this->options);
        $tag = $options['tag'];
        $markup = '';

        // Creates the markup of the component
        if ($options['prerender'] === true) {
            $markup = $this->getReact()->setComponent($this->componentsSourceJs, $this->props)->getMarkup();
        }

        // Pass props back to view as value of `data-react-props`
        $props = htmlentities(json_encode($this->props), ENT_QUOTES);

        // Gets all values that aren't used as options and map it as HTML attributes
        $htmlAttributes = array_diff_key($options, $this->defaultOptions);
        $htmlAttributesString = $this->arrayToHTMLAttributes($htmlAttributes);

        return "<{$tag} data-react-class='{$this->component}' data-react-props='{$props}' {$htmlAttributesString}>{$markup}</{$tag}>";
    }

    /**
     * Convert associative array to string of HTML attributes
     * @param $array
     * @return string
     */
    private function arrayToHTMLAttributes($array)
    {
        $htmlAttributesString = '';
        foreach ($array as $attribute => $value) {
            $htmlAttributesString .= "{$attribute}='{$value}'";
        }
        return $htmlAttributesString;
    }

    /**
     * Get source component js for ReactJs constructor
     * @return string
     */
    private function getSourceJs()
    {
        return file_get_contents($this->componentsSourceJs);
    }


}