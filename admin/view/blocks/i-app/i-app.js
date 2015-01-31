var App = (function () {
	var context = {};
	function _App (){}


	/**
	 * @param string
	 */
	_App.prototype.require = function( string ){

	};


	/**
	 * Перебор массивов
	 * @param array
	 * @param callback
	 */
	_App.prototype.each = function( array, callback ){
		var i = 0, len = array.length;
		for(; i < len; i++){
			if(callback){
				callback(array[i], i);
			}
		}
	};


	/**
	 * @param string
	 */
	_App.prototype.provide = function( string ){
		var string = string.split('.'),
			i = 0, len = string.length, cursor = window;

		for(; i < len; i++){
			if(!cursor[string[i]]){
				cursor[string[i]] = {};
			}
			cursor = cursor[string[i]];
		}
	};


	/**
	 * @param {array} array
	 * @param {string} value
	 * @returns {boolean}
	 */
	_App.prototype.inArray = function( array, value ){
		return array.join('||').indexOf(value) > -1;
	};


	/**
	 * @param mixed_var
	 * @returns {boolean}
	 */
	_App.prototype.is_object = function( mixed_var ){
		if(mixed_var instanceof Array) {
			return false;
		} else {
			return (mixed_var !== null) && (typeof( mixed_var ) == 'object');
		}
	};


	/**
	 * @param mixed_var
	 * @returns {*|boolean}
	 */
	_App.prototype.is_array = function( mixed_var ){
		return mixed_var && !(mixed_var.propertyIsEnumerable('length')) && typeof mixed_var === 'object' && typeof mixed_var.length === 'number';
	};


	/**
	 * @param mixed_var
	 * @returns {boolean}
	 */
	_App.prototype.is_function = function( mixed_var ){
		return typeof mixed_var == 'function';
	};


	/**
	 * @returns {File|*|FileReader|FileList|Blob}
	 */
	_App.prototype.is_file_api = function(){
		return (window.File && window.FileReader && window.FileList && window.Blob);
	};


	/**
	 * Наследование
	 * @param child
	 * @param parent
	 */
	_App.prototype.extend = function(child, parent){
		child.prototype = Object.create(parent.prototype);
		child.prototype.constructor = child;
		child.parent = parent.prototype;
	};


	/**
	 * Создания метода синглтона
	 * @param object
	 */
	_App.prototype.singleton = function(object){
		if(App.is_function(object)){
			var obj = null;
			object.prototype.constructor.getInstance = function(){
				if(!obj){
					obj = new object;
				}
				return obj
			}

		}else{
			throw new Error('Not Object');
		}
	};


	/**
	 * Генератор уникального ключа
	 * @returns {string}
	 */
	_App.prototype.unique = function () {
		return Math.random().toString(36).substr(2, 9);
	};


	/**
	 * Список шаблонов
	 * @type {null}
	 */
	var templates = {};


	/**
	 * Получение шаблона по ключу
	 */
	_App.prototype.get_templates = function (path) {
		return path ? templates[path] : templates;
	};


	/**
	 * Поиск и добавление шаблонов
	 */
	_App.prototype.find_templates = function () {
		var that = this;
		$('.twig-template').each(function () {
			var self = $(this),
				template = $.trim(self.html()),
				path = self.data('path');

			that.compile_string(template, path);

			$(this).remove();
		});
	};


	/**
	 * Рендер файла
	 * @param template
	 * @param context
	 * @returns {*}
	 */
	_App.prototype.render = function ( template, context ) {
		this.find_templates();

		if( templates[template] ){
			return twig({ ref: template }).render( context );
		}

		return '';
	};

	_App.prototype.compile_string = function (template, path) {
		var id = path ? path : App.unique();

		if( templates[id] ){
			return id;
		}

		twig({
			id: id,
			data: template,
			allowInlineIncludes: true,
			strict_variables: false
		});

		templates[id] = template;
		return id;
	};

	/**
	 * Рендер строки
	 * @param template
	 * @param context
	 * @returns {*}
	 */
	_App.prototype.render_string = function ( template, context ) {
		App.find_templates();
		return this.render(this.compile_string(template), context);
	};


	/**
	 * Установка контекста
	 * @param key
	 * @param value
	 * @returns {*}
	 */
	_App.prototype.set_context = function(key, value){
		return context[key] = value;
	};


	/**
	 * Получение контекста
	 * @param key
	 * @returns {*}
	 */
	_App.prototype.get_context = function(key){
		return key ? context[key] : context;
	};


	return new _App;
}());