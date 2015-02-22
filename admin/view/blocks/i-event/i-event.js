App.provide('App.blocks.iEvent');

/**
 * @param opt_dispatcher
 */
App.blocks.iEvent = function (opt_dispatcher) {
    this.dispatcher_ = opt_dispatcher || jQuery({});
};


/**
 * Добавить событие
 * @param eventType
 * @param handler
 * @param opt_handlerContext
 */
App.blocks.iEvent.prototype.addEventListener = function(eventType, handler, opt_handlerContext) {
    this.dispatcher_.on(
        eventType,
        jQuery.proxy(handler, opt_handlerContext || this.dispatcher_));
};


/**
 * Удаление события
 * @param eventType
 * @param handler
 */
App.blocks.iEvent.prototype.removeEventListener = function(eventType, handler) {
    this.dispatcher_.off(eventType, handler);
};


/**
 * Подписка на событие
 * @param eventType
 * @param opt_data
 */
App.blocks.iEvent.prototype.dispatchEvent = function(eventType, opt_data) {
    this.dispatcher_.trigger(eventType, opt_data);
};