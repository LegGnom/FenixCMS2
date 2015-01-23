<?

class Cookie {

	/**
	 * Получить cookie
	 * @param $name
	 * @return null
	 */
	public static function get($name){
		return isset($_COOKIE[$name]) ? $_COOKIE[$name] : null;
	}


	/**
	 * Установить cookie
	 * @param $name
	 * @param $value
	 * @param int $time
	 * @param string $path
	 */
	public static function set($name, $value, $time = 0, $path = '/'){
		setcookie($name, $value, $time, $path);
	}


	/**
	 * Удаление cookie
	 * @param $name
	 */
	public static function remove($name){
		if(self::has($name)){
			unset($_COOKIE[$name]);
			setcookie($name, null, -1, '/');
		}
	}


	/**
	 * Получить все cookie
	 * @return mixed
	 */
	public static function all(){
		return $_COOKIE;
	}


	/**
	 * Проверить на наличие cookie
	 * @param $name
	 * @return bool
	 */
	public static function has($name){
		return isset($_COOKIE[$name]);
	}

}