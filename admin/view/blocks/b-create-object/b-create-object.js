App.require('App.blocks.bCreateObjectView');
App.require('App.blocks.bPopup');
App.provide('App.blocks.bCreateObject');


App.blocks.bCreateObject = function (parent) {

    this.dom_ = null;
    this.list = null;

    this.widget = App.blocks.iAppWidget.getInstance();

    this.popup = new App.blocks.bPopup({
        head: 'Создание объекта'
    });

};


App.blocks.bCreateObject.TEMPLATE = '/blocks/b-create-object/b-create-object.twig'


App.blocks.bCreateObject.prototype.show = function (list) {
    var self = this,
        widget = this.popup.show({
            body: App.render(App.blocks.bCreateObject.TEMPLATE, {list: list})
        }, function () {
            self.list = list;

            self.dom_ = {
                widget: widget,
                table_input_alias: widget.find('.b-create-object__table-input-alias'),
                table_select: widget.find('.b-create-object__table-select'),
                additional_options_button: widget.find('.b-create-object__additional-options-button'),
                additional_options_box: widget.find('.b-create-object__additional-options-box')
            };

            self.bind_();
        });
};


App.blocks.bCreateObject.prototype.bind_ = function () {
    this.dom_.additional_options_button.on('mouseup', jQuery.proxy(this.toggle_additional_options, this));

    /**
     * Событие при выборе таблици
     */
    this.widget.get_widget(this.dom_.table_select.get(0))
        .addEventListener(App.blocks.bSelect.EVENTS.CHANGE, jQuery.proxy(this.change_table, this));
};


App.blocks.bCreateObject.prototype.change_table = function (event, index) {
    if(this.list[index]){
        var alias_widget = this.widget.get_widget(this.dom_.table_input_alias.get(0));

        alias_widget.val(this.list[index]);
    }
};


App.blocks.bCreateObject.prototype.toggle_additional_options = function () {
    this.dom_.additional_options_box.toggle();
};


App.blocks.bCreateObject.prototype.show_additional_options = function () {
    this.dom_.additional_options_box.show();
};


App.blocks.bCreateObject.prototype.hide_additional_options = function () {
    this.dom_.additional_options_box.hide();
};