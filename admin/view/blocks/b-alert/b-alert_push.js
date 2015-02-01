App.provide('App.blocks.bAlertPush');


App.blocks.bAlertPush = function () {
	this.widget = false;
	this.instance = false;
};


App.blocks.bAlertPush.TEMPLATE = '/blocks/b-alert/b-alert.twig';


App.blocks.bAlertPush.prototype.show = function (message, status) {
	if(!message){
		return;
	}

	var template = App.render(App.blocks.bAlertPush.TEMPLATE, {
		message: message,
		type: status
	});
	this.widget = $(template);

	$('body').append(this.widget);
	this.instance = new App.blocks.bAlert(this.widget.get(0));
};


App.blocks.bAlertPush.prototype.hide = function () {
	if(this.instance){
		var self = this;
		this.instance.hide(function () {
			this.instance = false;
		});
	}
};