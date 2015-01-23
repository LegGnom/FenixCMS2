<?

class View {

	/**
	 * Обработчик файла
	 * @var null
	 */
	private static $call_file = null;


	/**
	 * Обработчик строки
	 * @var null
	 */
	private static $call_string = null;


	/**
	 * Путь к вьюхам
	 * @var string
	 */
	private static $path = '';


	/**
	 * Рендер файла
	 * @param $template
	 * @param array $data
	 */
	public static function render($template, $data = array())
	{
		if( is_callable(self::$call_file) ){
			call_user_func_array(self::$call_file, array($template, $data));
		}else{
			trigger_error('render not callable');
		}
	}


	/**
	 * Рендер строки
	 * @param $template
	 * @param array $data
	 */
	public static function render_string($template, $data = array())
	{
		if( is_callable(self::$call_string) ){
			call_user_func_array(self::$call_string, array($template, $data));
		}else{
			trigger_error('render not callable');
		}
	}


	/**
	 * Установка обработчика для файла
	 * @param $function
	 */
	public static function call_file($function)
	{
		if( is_callable($function) ){
			self::$call_file = $function;
		}else{
			trigger_error('is not a function');
		}
	}


	/**
	 * Установка обработчика для строки
	 * @param $function
	 */
	public static function call_string($function)
	{
		if( is_callable($function) ){
			self::$call_string = $function;
		}else{
			trigger_error('is not a function');
		}
	}


	/**
	 * Установка опций
	 * @param $path
	 */
	public static function set_path($path)
	{
		self::$path = $path;
	}


	/**
	 * Получение опций
	 * @return string
	 */
	public static function get_path()
	{
		return self::$path;
	}
}