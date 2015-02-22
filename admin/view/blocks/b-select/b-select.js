App.require('App.blocks.iAppWidget');
App.require('App.blocks.iEvent');

App.provide('App.blocks.bSelect');


App.blocks.bSelect = function (node) {
	var widget = $(node);

	App.blocks.bSelect.parent.constructor.call(this);
	App.blocks.iAppWidget.getInstance().set(this, node, 'App.blocks.bSelect');

	this.dom_ = {
		widget: widget,
		select: widget.find('.b-select__select'),
		name: widget.find('.b-select__name'),
		list: widget.find('.b-select__list'),
		items: [],
		options: [],
		button: widget.find('.b-select__button')
	};

	this.init_();
	this.bind_();
};
App.extend(App.blocks.bSelect, App.blocks.iEvent);


App.blocks.bSelect.EVENTS = {
	CHANGE: 'App.blocks.bSelect.CHANGE'
};


App.blocks.bSelect.prototype.init_ = function () {
	var list = this.dom_.list;
	this.dom_.select.find('option').each(function () {
		var item = document.createElement('DIV'),
			text = document.createTextNode(this.innerHTML);
		item.appendChild(text);
		item.className = 'b-select__list-item';
		list.append(item);
	});

	this.dom_.items = list.find('.b-select__list-item');
	this.dom_.options = this.dom_.select.find('option');
};


App.blocks.bSelect.prototype.bind_ = function () {
	this.dom_.button.on('mouseup', jQuery.proxy(this.show, this));
	this.dom_.items.on('mouseup', jQuery.proxy(this.check_, this))
	$(document).on('mouseup', jQuery.proxy(this.dom_click_, this));
};


App.blocks.bSelect.prototype.check_ = function (event) {
	this.check(this.dom_.items.index($(event.currentTarget)));
};


App.blocks.bSelect.prototype.check = function (index) {
	this.dom_.options.removeAttr('selected');
	this.dom_.options.eq(index).attr('selected', 'selected');
	this.dom_.name.html(this.dom_.items.eq(index).html());
	this.dispatchEvent(App.blocks.bSelect.EVENTS.CHANGE, index);
	this.hide();
};


App.blocks.bSelect.prototype.show = function () {
	this.dom_.list.slideToggle(150);
};


App.blocks.bSelect.prototype.hide = function () {
	this.dom_.list.slideUp(150);
};


App.blocks.bSelect.prototype.dom_click_ = function (event) {
	if(!$(event.target).closest(this.dom_.widget).length){
		this.hide();
	}
};


App.blocks.bSelect.init = function (node) {
	$('.b-select', node).each(function () {
		new App.blocks.bSelect(this);
	});
};


$(function () {
	App.blocks.bSelect.init(document.body);
});