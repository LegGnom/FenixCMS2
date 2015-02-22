App.require('App.blocks.iAppWidgetConstructor');
App.provide('App.blocks.bPopup');


App.blocks.bPopup = function (options) {

    this.options = App.merge({
        head: '',
        body: '',
        width: 'normal', // small, normal, full
        center: false,
        parent: document.body
    }, options || {});
    this.body = jQuery(document.body);
    this.node = null;
    this.dom_ = null;


    this.widget = App.blocks.iAppWidget.getInstance();
    this.widget.set(this, null, 'App.blocks.bPopup');
};


/**
 * Время выполнения анимации
 * @type {number}
 */
App.blocks.bPopup.DURATION = 100;


/**
 * Стартовый z-index
 * @type {number}
 */
App.blocks.bPopup.START_INDEX = 102;


/**
 * Путь к шаблону
 * @type {string}
 */
App.blocks.bPopup.TEMPLATE = '/blocks/b-popup/b-popup.twig';


/**
 * Показать виджет
 * @param data
 */
App.blocks.bPopup.prototype.show = function (data, callback) {
    var self = this,
        zIndex = '',
        data = data || {},
        template = App.render(App.blocks.bPopup.TEMPLATE, App.merge({
            head: this.options.head,
            body: this.options.body
        }, data, {
            options: {
                width: this.options.width
            }
        }));


    if(this.widget.len('App.blocks.bPopup')){
        var index = 0;
        App.each(this.widget.list('App.blocks.bPopup'), function (item) {
            if(item.is_show()){
                index++;
            }
        });

        if(index){
            zIndex = App.blocks.bPopup.START_INDEX + index;
        }
    }


    this.node = jQuery(template);

    new App.blocks.iAppWidgetConstructor(this.node);

    this.dom_ = {
        background: this.node.find('.b-popup__background'),
        content: this.node.find('.b-popup__content')
    };


    this.node.css({zIndex: zIndex});
    this.body.css({overflow: 'hidden'});
    jQuery(this.options.parent).append(this.node);


    this.dom_.background.fadeTo(App.blocks.bPopup.DURATION, 1, function () {
        self.dom_.content.show();
        self.bind_();

        if( App.is_function(callback) ){
            callback();
        }
    });

    return this.dom_.content;
};


/**
 * Скрыть виджет
 */
App.blocks.bPopup.prototype.hide = function () {
    if( this.is_show() ){
        this.node.remove();

        this.node = null;
        this.dom_ = null;
        this.body.css({ overflow: '' });
    }
};


/**
 * Проверка на видемость виджета
 * @returns {boolean}
 */
App.blocks.bPopup.prototype.is_show = function () {
    return !!this.node;
};


/**
 * Биндинг событий внутри виджета
 * @private
 */
App.blocks.bPopup.prototype.bind_ = function () {
    this.dom_.background.on('mouseup', jQuery.proxy(this.hide, this));
};


/**
 * Событие при нажатии ESC
 */
jQuery(document).on('keyup', function (event) {
    if( !event.keyCode === 27 ){
        return;
    }
    var widgets = App.blocks.iAppWidget.getInstance(),
        i = 0,
        list = widgets.list('App.blocks.bPopup'),
        widget = [];

    for (; i < list.length; i++){
        if(list[i].is_show()){
            widget.push(list[i]);
        }
    }

    if( widget.length ){
        widget.pop().hide();
    }
});