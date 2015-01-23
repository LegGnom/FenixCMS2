<?

/**
 * Class Route
 *
 */
class Route {

	/**
	 * Переменные запроса
	 * @var array
	 */
	private static $query = array();


	/**
	 * Индикатор ошибки
	 * @var bool
	 */
	private static $error = true;


	/**
	 * Индекатор обработки урлов
	 * @var bool
	 */
	private static $stopped = false;


	/**
	 * Группировка роутов
	 * @param $type
	 * @param $list
	 */
	public static function group($type, $list)
	{
		$type = strtolower($type);
		foreach($list as $uri => $callback){
			if($type == 'get'){
				self::get($uri, $callback);
			}elseif($type == 'post'){
				self::post($uri, $callback);
			}
		}
	}


	/**
	 * Get запрос
	 * @param $uri
	 * @param $callback
	 */
	public static function get($uri, $callback)
	{
		if(self::$stopped){ return; }

		if(Request::is_method('get') && self::is_equal($uri)){
			App::execute($callback, self::$query);
		}
	}


	/**
	 * Post запрос
	 * @param $uri
	 * @param $callback
	 */
	public static function post($uri, $callback)
	{
		if(self::$stopped){ return; }

		if(Request::is_method('post') && self::is_equal($uri)){
			App::execute($callback, self::$query);
		}
	}


	/**
	 * Post/Get запрос
	 * @param $uri
	 * @param $callback
	 */
	public static function all($uri, $callback){
		if(self::$stopped){ return; }

		if(Request::is_method('post') || Request::is_method('get') && self::is_equal($uri)){
			App::execute($callback, self::$query);
		}
	}


	/**
	 * Обработка ошибки, когда небыло вызвано ни одного контроллера
	 * @param $code
	 * @param $callback
	 */
	public static function error($code, $callback)
	{
		if(self::$stopped){ return; }

		if(self::$error){
			App::execute($callback, array($code));
		}
	}


	/**
	 * Возбудить ошибку
	 */
	public static function trigger_error()
	{
		self::$error = true;
	}


	/**
	 * Проверка, если текущий урл равен передаваемому
	 * @param $url
	 * @return bool
	 */
	private static function is_equal($url)
	{
		$url = is_array($url) ? $url : array($url);
		$is = false;
		foreach($url as $item){
			if(self::is_equal_test($item)){
				self::$error = false;
				$is = true;
			}
		}

		return $is;
	}


	private static function is_equal_test($url){
		$that = Request::path_to_array();
		$url = URL::parse($url);

		if(count($that) === count($url) || in_array('*', $url)){
			$is = true;
			$all = false;
			foreach($that as $key => $item){
				if(!isset($url[$key])){ break; }
				if($url[$key] === '*'){
					$all = true;
					$is = true;
				}

				if($url[$key] !== $item && !self::is_query($url[$key], $that[$key])){
					if(!$all){
						$is = false;
					}
				}
			}
			return $is;
		}

		return false;
	}


	/**
	 * Проверка на существование переменной и запись ее в массив
	 * @param $url
	 * @param $that
	 * @return bool
	 */
	private static function is_query($url, $that)
	{
		if(substr($url, 0, 1) === '{' && substr($url, -1) === '}'){
			$url = trim($url, '{');
			$url = trim($url, '}');

			self::$query[$url] = $that;
			return true;
		}

		return false;
	}


	/**
	 * Остановить обработку урлов
	 */
	public static function stop()
	{
		self::$stopped = true;
	}


	/**
	 * Возобнавить обработку урлов
	 */
	public static function start()
	{
		self::$stopped = false;
	}

}