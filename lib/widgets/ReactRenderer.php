<?php


namespace bTokman\react\widgets;


use ReactJS;
use Yii;
use yii\base\Widget;
use yii\web\NotFoundHttpException;
use bTokman\react\ReactAsset;
use bTokman\react\ReactUiAsset;


/**
 * Class ReactRenderer - yii2 widget to server-side react rendering
 * and implementing it on client side.
 * This widget require V8JS PHP extension: http://php.net/v8js
 * @package bTokman\react\widgets
 */
class ReactRenderer extends Widget
{


    public
        $js,
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
        $options = [];


    /**
     * Instance of ReactJS object
     * More information https://github.com/reactjs/react-php-v8js
     * @var $_react ReactJS
     */
    private $_react;
    /**
     * Path to React bundle, must contain:
     * React Js : https://www.npmjs.com/package/react
     * React-dom Js : https://www.npmjs.com/package/react-dom
     * React-dom-server from React-dom package
     * @var string
     */
    private $_reactSourceJs;

    /**
     *  Default options, "tag" - place to render react app - default to "div"
     *  "prerender" - tell to widget render your react app on server side - default to true
     * @var $_defaultOptions array
     */
    private $_defaultOptions = [
        'tag' => 'div',
        'prerender' => true
    ];


    /**
     * Initializes the widget.
     */
    public function init()
    {
        if (!$this->js and (empty($this->componentsSourceJs) || !file_exists($this->componentsSourceJs )) ) {
            throw new NotFoundHttpException('React component source js file doesn\'t exist, and raw js is empty');
        }
        /**
         * Get ReactJs server side render instance
         */
        $this->_react = new ReactJS($this->getReactSource(), $this->getSourceJs());

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
     * Get react source Js bundle
     * @return string
     */
    private function getReactSource()
    {
        if ($this->_reactSourceJs === null) {
            $bundle = new ReactAsset();
            $alias = Yii::getAlias($bundle->sourcePath) . DIRECTORY_SEPARATOR;
            $this->_reactSourceJs = file_get_contents($alias . $bundle->js[0]);
        }
        return $this->_reactSourceJs;
    }

    /**
     * Apply js in view
     */
    public function applyJs()
    {
        ReactAsset::register($this->view);
        $this->getView()->registerJsFile($this->componentsSourceJs, ['depends' => 'bTokman\react\ReactAsset']);
        ReactUiAsset::register($this->view);

    }

    /**
     * Rendering function
     * @return string
     */
    public function renderReact()
    {
        $options = array_merge($this->_defaultOptions, $this->options);
        $tag = $options['tag'];
        $markup = '';

        // Creates the markup of the component
        if ($options['prerender'] === true) {
            $markup = $this->_react->setComponent($this->component, $this->props)->getMarkup();
        }

        // Pass props back to view as value of `data-react-props`
        $props = htmlentities(json_encode($this->props), ENT_QUOTES);

        // Gets all values that aren't used as options and map it as HTML attributes
        $htmlAttributes = array_diff_key($options, $this->_defaultOptions);
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
            $htmlAttributesString .= "{$attribute} = '{$value}'";
        }
        return $htmlAttributesString;
    }

    /**
     * Get source component js for ReactJs constructor
     * @return string
     */
    protected function getSourceJs()
    {
        return file_get_contents($this->componentsSourceJs);
    }


}