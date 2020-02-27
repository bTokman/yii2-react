# Yii2-React

This is Yii2 widget that able to use [ReactJS](https://facebook.github.io/react/) components in your Yii2 app, with options of server-side rendering.


# Installation
This widget require [v8js](https://pecl.php.net/package/v8js) php extesion.
How to setup V8Js PHP extension? Use the links below:
  - [On Linux](https://github.com/phpv8/v8js/blob/master/README.Linux.md)
  - [On MacOs](https://github.com/phpv8/v8js/blob/master/README.MacOS.md)
  - [On Windows](https://github.com/phpv8/v8js/blob/master/README.Win32.md)
### Composer
Set the `minimum-stability` in your composer.json to `dev`
2. This widget compile react bundle from npm react and react-dom packages using browserify and uglify-js
 _BUT_ since composer run scripts only for root composer.json, need to add the following lines to your composer.json:
 ```composer
... 
"scripts": {
"regenerate_react_bundle": [
    "vendor/b-tokman/yii2-react/node_modules/.bin/browserify vendor/b-tokman/yii2-react/build-react-bundle.js > vendor/b-tokman/yii2-react/lib/assets/react-bundle.js",
    "vendor/b-tokman/yii2-react/node_modules/.bin/uglifyjs  vendor/b-tokman/yii2-react/lib/assets/react-bundle.js -c -m -o vendor/b-tokman/yii2-react/lib/assets/react-bundle.min.js"
],
"post-install-cmd":[
    "@regenerate_react_bundle",
],
"post-update-cmd": [
    "@regenerate_react_bundle",
]
...
``` 
This way composer will run browserify to create react-bundle.js and uglifyjs to minify it, each time after upgrade or install
 
2. Then run 

```sh
  $ composer require b-tokman/yii2-react
```
Composer will download yii2-react package with all dependenices, then npm will download react and react-dom npm packages and scripts will compile it.
 
# Usage
After the installation you'll be able to use the `bTokman\react\widgets\ReactRenderer` widget in your app.
```php
ReactRenderer::widget([
    'componentsSourceJs' => <pathToYourComponentJsFile>,
    'component' => <componentName>,
    'props' => [props],
    'options' => [options],
    'useTranspiler' => true //or false
])
```

  - `componentsSourceJs` - path to your react components js file
  - `component` - the name of global variable the contain your React component, you also can use [namespased components](https://facebook.github.io/react/docs/jsx-in-depth.html#namespaced-components) by dot-notation
  - `props` - [props](https://facebook.github.io/react/docs/components-and-props.html) array that'll be passed to your component
* `options` - Array of options that you can pass to widget:
  * `prerender` -  Tells widget to render your component server-side, by default - `true`
  * `tag` - The tag of the element where your component would be passed
  * _html attributes_ -  HTML attribute that will be added to the wrapper element of your component. Example: `'id' => 'root'`.
* `useTranspiler` - boolean, whatever to transpile js code, using bable or not. If you dont have JSX or other specific syntax,  dont use transpiler, to save some time

### All your reactJs components must be in `window` scope.

# Example

In your view file:
```php
echo ReactRenderer::widget([
    'componentsSourceJs' => 'js/main.js',
    'component' => 'Main',
    'props' => [ 'title' => 'Hello' ],
]);

```
Example `main.js`

```js
class Main extends React.Component {
    render() {
        let title = this.props.title;
        return React.createElement(
            "main",
            null,
            React.createElement("div", null, title)
        );
    }
}
window.Main = Main;
```
Namespased components:

```php
echo ReactRenderer::widget([
      'componentsSourceJs' => 'js/layout.js',
      'component' => 'Layout.Header',
      'props' => ['title' => 'Hello'],
]);

```
Example `layout.js`

```js
class Header extends React.Component {
    render() {
        let title = this.props.title;
        return React.createElement(
            "header",
            null,
            React.createElement("div", null, title)
        );
    }
}
class Layout extends React.Component {
    render() {
        return React.createElement(
            "div",
            null,
            React.createElement(Layout.Header, {title: this.props.title})
        );
    }
}
Layout.Header = Header;
window.Header = Header;
```