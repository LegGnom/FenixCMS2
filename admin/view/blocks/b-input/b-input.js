App.provide('App.blocks.bInput');


App.blocks.bInput = function (node) {
    App.blocks.iAppWidget.getInstance().set(this, node, 'App.blocks.bInput');

    var widget = $(node);

    this.dom_ = {
        widget: widget,
        title: widget.find('.b-input__title'),
        input: widget.find('.b-input__tag'),
        desc: widget.find('.b-input__desc')
    }
};


App.blocks.bInput.prototype.val = function (value) {
    if(value){
        this.dom_.input.val(value)
    }else{
        return this.dom_.input.val()
    }
};



App.blocks.bInput.init = function (node) {
    $('.b-input', node).each(function () {
        new App.blocks.bInput(this);
    });
};


$(function () {
    App.blocks.bSelect.init(document.body);
});