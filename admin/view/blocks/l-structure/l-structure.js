App.provide('App.blocks.lStructure');


App.blocks.lStructure = function () {
	this.connectdb = new App.blocks.bConnectDB();
	this.bind();
};


App.blocks.lStructure.prototype.bind = function () {
	jQuery('.l-structure__connect-db').on('mousedown', jQuery.proxy(this.load_connect_db, this));
};


App.blocks.lStructure.prototype.load_connect_db = function () {
	this.connectdb.show();
};


$(function () {
	new App.blocks.lStructure();
});