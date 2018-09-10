window.ReactUJS = {

    CLASS_NAME_ATTR: 'data-react-class',
    PROPS_ATTR: 'data-react-props',

    mountComponents: function mountComponents() {
        var elements = document.querySelectorAll('[' + ReactUJS.CLASS_NAME_ATTR + ']');
        var reactClass, props;

        elements.forEach(function (item, i) {
            reactClass = item.getAttribute(ReactUJS.CLASS_NAME_ATTR).split('.');

            reactClass = reactClass.reduce(function (object, index) {
                return object[index]
            }, window);

            props = JSON.parse(item.getAttribute(ReactUJS.PROPS_ATTR));

            ReactDOM.render(React.createElement(reactClass, props), item);
        });
    },

    unmountComponents: function unmountComponents() {
        var elements = document.querySelectorAll(ReactUJS.CLASS_NAME_ATTR);

        elements.forEach(function (item, i) {
            ReactDOM.unmountComponentAtNode(item);
        })
    },

    handleEvents: function handleEvents() {
        document.addEventListener('DOMContentLoaded', ReactUJS.mountComponents);
        window.addEventListener('unload', ReactUJS.unmountComponents);
    }
};

ReactUJS.handleEvents();