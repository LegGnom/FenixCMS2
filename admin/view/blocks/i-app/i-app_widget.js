App.provide('App.blocks.iAppWidget');


App.blocks.iAppWidget = function () {

};


/**
 * Список доступных виджетов
 * @type {{}}
 */
App.blocks.iAppWidget.WIDGETS = {};


/**
 * Получение виджета
 */
App.blocks.iAppWidget.prototype.get = function (id, type) {
    if(App.blocks.iAppWidget.WIDGETS[type]){
        var i = 0,
            list = App.blocks.iAppWidget.WIDGETS[type];
        for (; i < list.length; i++){
            if(list[i].widget_id_ == id){
                return list[i];
            }
        }
    }
    return false;
};


/**
 * Получение ноды
 */
App.blocks.iAppWidget.prototype.get_widget = function (node) {
    if( node['widget_'] ){
        return node['widget_'];
    }
    return false;
};


/**
 * Получение списка виджетов
 * @param type
 */
App.blocks.iAppWidget.prototype.list = function (type) {
    if(App.blocks.iAppWidget.WIDGETS[type]){
        return App.blocks.iAppWidget.WIDGETS[type];
    }

    return [];
};


/**
 * Установка виджета
 * @param widget
 */
App.blocks.iAppWidget.prototype.set = function (widget, node, type) {
    if(!App.blocks.iAppWidget.WIDGETS[type]){
        App.blocks.iAppWidget.WIDGETS[type] = [];
    }

    widget.widget_id_ = App.unique();
    widget.node_ = node;
    App.blocks.iAppWidget.WIDGETS[type].push(widget);


    if(node){
        node.widget_ = widget;
    }
};


/**
 * Проверка на существование виджета
 */
App.blocks.iAppWidget.prototype.is = function (id, type) {
    return !!this.get(id, type);
};


/**
 * Колучество виджетов заданного типа
 */
App.blocks.iAppWidget.prototype.len = function (type) {
    if( App.blocks.iAppWidget.WIDGETS[type] ){
        return App.blocks.iAppWidget.WIDGETS[type].length;
    }
    return 0;
};


App.singleton(App.blocks.iAppWidget);


