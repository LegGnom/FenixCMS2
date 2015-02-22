App.require('App.blocks.bSelect');
App.require('App.blocks.bInput');

App.provide('App.blocks.iAppWidgetConstructor');


App.blocks.iAppWidgetConstructor = function (node) {
    App.blocks.bSelect.init(node);
    App.blocks.bInput.init(node);
};