<?

class App {


	private static $controller_path = '';


	/**
	 * Вывод переменных с прирыванием
	 */
	public static function dump()
	{
		echo '<pre>';
		foreach(func_get_args() as $arg){
			var_dump($arg);
		}
		die;
	}


	/**
	 * Вызов ошибки в роуте
	 */
	public static function abort()
	{
		Route::trigger_error();
	}


	/**
	 * Выполнение функции или контроллера
	 * @param $callback
	 * @param $arguments
	 * @return mixed
	 */
	public static function execute($callback, $arguments = array())
	{
		if(is_string($callback)){
			$path = $callback;
			$class = $callback;

			if(strpos($path, '.')){
				$path = str_replace('.', '/', $path);
				$class = array_pop(explode('.', $path));
			}

			$path = self::$controller_path . $path . '.php';

			if(file_exists($path)){
				require_once $path;
				if(class_exists($class)){
					return new $class ($arguments);
				}else{
					self::abort();
				}
			}else{
				self::abort();
			}

		}elseif(is_callable($callback)){
			return call_user_func_array($callback, $arguments);
		}else{
			trigger_error('not callback');
		}
	}


	/**
	 * Установка пути к контроллеру
	 * @param $path
	 */
	public static function set_controller_path($path)
	{
		self::$controller_path = $path;
	}

}