App.require('App.blocks.bCreateObject');
App.require('App.blocks.bConnectDB');


App.provide('App.blocks.lStructure');


App.blocks.lStructure = function () {
	this.bind();
};


App.blocks.lStructure.prototype.bind = function () {
	jQuery('.l-structure__connect-db').on('mouseup', jQuery.proxy(this.load_connect_db, this));
	jQuery('.l-structure__create-object').on('mouseup', jQuery.proxy(this.create_object, this));
};


App.blocks.lStructure.prototype.load_connect_db = function () {
	var object = new App.blocks.bConnectDB();
	object.show();
};


App.blocks.lStructure.prototype.create_object = function (event) {
	var object = new App.blocks.bCreateObject();
	object.show($(event.currentTarget).data('init'));
};


$(function () {
	new App.blocks.lStructure();
});