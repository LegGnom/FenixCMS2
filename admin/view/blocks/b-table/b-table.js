App.provide('App.blocks.bTable');


App.blocks.bTable = function (node) {
    var widget = $(node);

    this.dom_ = {
        widget: widget,
        container: widget.find('.b-table__container')
    };


    this.widget = null;

    this.data = widget.data('init');


    this.init_();
};


App.blocks.bTable.prototype.init_ = function () {
    var keys = Object.keys(this.data);
    var cols_keys = Object.keys(this.data[keys.shift()]);
    var cols_options = [];

    for(var i = 0; i < cols_keys.length; i++){
        cols_options.push({
            data: cols_keys[i],
            renderer: 'html'
        });
    }

    this.widget = new Handsontable(this.dom_.container.get(0), {
        data: this.data,
        colHeaders: cols_keys,
        columns: cols_options,
        rowHeaders: true,
        contextMenu: true,
        multiSelect: false,
        wordWrap: false,
        autoWrapRow: true
    });
};


App.blocks.bTable.prototype.render_ = function (instance, td, row, col, prop, value, cellProperties) {
    var arg = arguments,
        value = arg[5];

    if(value.length > 50){
        var div = document.createElement('DIV');
        div.innerHTML = value
        value = div.innerText.slice(0,50) + '...';
    }

    td.innerHTML = value;
};


$(function () {
    $('.b-table').each(function () {
        new App.blocks.bTable(this);
    });
});