# Yii2-React

This is Yii2 widget that able to use [ReactJS](https://facebook.github.io/react/) components in your Yii2 app, with options of server-side rendering.


# Installation
This widget require [v8js](https://pecl.php.net/package/v8js) php extesion.
How to setup V8Js PHP extension? Use the links below:
  - ##### [On Linux](https://github.com/phpv8/v8js/blob/master/README.Linux.md)
  - ##### [On MacOs](https://github.com/phpv8/v8js/blob/master/README.MacOS.md)
  - ##### [On Windows](https://github.com/phpv8/v8js/blob/master/README.Win32.md)

# Usage
After the installation you'll be able to use the `bTokman\react\widgets\ReactRenderer` widget in your app.
```php
ReactRenderer::widget([
    'componentsSourceJs' => <pathToYourComponentJsFile>',
    'component' => <componentName>,
    'props' => [props],
    'options' => [options]
    
// example

ReactRenderer::widget([
    'componentsSourceJs' => 'js/layout.js',
    'component' => 'Layout',
    'props' => [ 'title' => 'Hello' ],
    'options' => [
        'id' => 'root',
        'prerender' => true 
    ]
]); 
// you also can use namespased components
ReactRenderer::widget([
    'componentsSourceJs' => 'js/layout.js',
    'component' => 'Layout.Header',
    'props' => [ 'title' => 'Hello' ],
    'options' => [
        'id' => 'root',
        'prerender' => true 
    ]
]); 
```
  - `componentsSourceJs` - path to your react components js file
  - `component` - the name of global warioable the contain your React component, you also can use [namespased components](https://facebook.github.io/react/docs/jsx-in-depth.html#namespaced-components) by dot-notation
  - `props` - [props](https://facebook.github.io/react/docs/components-and-props.html) array that'll be passed to your component
* `options` - Array of options that you can pass to widget:
  * `prerender` -  Tells widget to render your component server-side, by default - `true`
  * `tag` - The tag of the element where your component would be passed
  * _html attributes_ -  HTML attribute that will be added to the wrapper element of your component. Example: `'id' => 'root'`.
 
### To right working - your reactJs components must be in window scope.

  