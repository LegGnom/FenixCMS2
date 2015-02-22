App.require('App.blocks.bAlertPush');

App.provide('App.blocks.bConnectDB');


App.blocks.bConnectDB = function () {
	this.body = $('body');
	this.widget = null;
	this.id = App.unique();
	this.is_visible = false;
	this.alert = new App.blocks.bAlertPush();
};


App.blocks.bConnectDB.TEMPLATE_PATH = '/blocks/b-connect-db/b-connect-db.twig';


App.blocks.bConnectDB.prototype.show = function () {
	if(this.is_visible){
		this.hide();
		return;
	}
	var self = this,
		template = App.render(App.blocks.bConnectDB.TEMPLATE_PATH, {
			db_drivers: App.context.db_drivers
		});

	this.widget = $(template);

	this.widget.find('.b-select').each(function () {
		new App.blocks.bSelect(this);
	});

	this.body.append(this.widget);
	this.bind();

	this.widget.stop().animate({
		top: 0
	}, 300, function(){
		self.is_visible = true;
	});
};


App.blocks.bConnectDB.prototype.hide = function (){
	if(this.is_visible){
		var self = this;

		this.widget.stop().animate({
			top: '-100%'
		}, 300, function () {
			self.unbind();
			self.widget.remove();
			self.widget = false;
			self.is_visible = false;
		});
	}
};

App.blocks.bConnectDB.prototype.toogle_options = function () {
	this.widget.find('.b-connect-db__toggle').slideToggle();
};


App.blocks.bConnectDB.prototype.key_close_ = function (event) {
	if(event.keyCode == 27) {
		this.hide();
	}
};


App.blocks.bConnectDB.prototype.mouse_close_ = function (event) {
	if( this.is_visible && !$(event.target).closest(this.widget).length ){
		this.hide();
	}
};


App.blocks.bConnectDB.prototype.submit_ = function (event) {
	var self = this,
		form = $(event.currentTarget),
		data = form.serialize();

	$.get('/admin/action/connect-db/', data, function (result) {
		var status = 'error',
			message = '';

		try{
			message = result.push_message;

			if( !result.error ){
				self.hide();
				status = 'good';
			}
		} catch (e) {
			message = e;
		}


		self.alert.show(message, status);
	});

	event.preventDefault();
};


App.blocks.bConnectDB.prototype.bind = function () {
	$(document).on('keyup.bConnectDB'+ this.id, jQuery.proxy(this.key_close_, this));
	$(document).on('mouseup.bConnectDB'+ this.id, jQuery.proxy(this.mouse_close_, this));

	this.widget.find('.b-connect-db__close').on('mouseup.bConnectDB'+ this.id, jQuery.proxy(this.hide, this));
	this.widget.find('.b-connect-db__form').on('submit.bConnectDB'+ this.id, jQuery.proxy(this.submit_, this));
	this.widget.find('.b-connect-db__toggle-button').on('mouseup.bConnectDB'+ this.id, jQuery.proxy(this.toogle_options, this));
};


App.blocks.bConnectDB.prototype.unbind = function () {
	$(document).off('keyup.bConnectDB'+ this.id);
	$(document).off('mouseup.bConnectDB'+ this.id);
};