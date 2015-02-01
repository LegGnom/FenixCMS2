App.provide('App.blocks.bAlert');


App.blocks.bAlert = function (node) {
	var widget = $(node);

	this.dom_ = {
		widget: widget
	};

	this.timeout = 0;


	this.bind_();
	this.init_();
};


App.blocks.bAlert.DURATION = 300;


App.blocks.bAlert.prototype.init_ = function () {
	var self = this;
	this.dom_.widget.fadeTo(App.blocks.bAlert.DURATION, 1, jQuery.proxy(this.start_timer, this));
};


App.blocks.bAlert.prototype.bind_ = function () {
	var self = this;
	this.dom_.widget.hover(function () {
		clearTimeout(self.timeout);
	}, function () {
		self.start_timer();
	});
};


App.blocks.bAlert.prototype.start_timer = function () {
	var self  = this;
	self.timeout = setTimeout(function(){
		self.hide();
	}, 3000);
};


App.blocks.bAlert.prototype.hide = function (callback) {
	var self = this;
	self.dom_.widget.fadeTo(App.blocks.bAlert.DURATION, 0, function () {
		self.dom_.widget.remove();
		if(App.is_function(callback)){
			callback();
		}
	});
};


$(function () {
	$('.b-alert').each(function () {
		new App.blocks.bAlert(this);
	});
});