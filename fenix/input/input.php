<?

/**
 * Class Input
 * Работа с запросами post/get
 */
class Input {

	/**
	 * Получить переменную из окружения
	 * @param $name
	 * @return null
	 */
	public static function get($name)
	{
		return isset( $_REQUEST[$name] ) ? $_REQUEST[$name] : null;
	}


	/**
	 * Проверить наличие переменной в окружении
	 * @param $name
	 * @return bool
	 */
	public static function has($name)
	{
		return isset($_REQUEST[$name]);
	}


	/**
	 * Получить все переменные окружения
	 * @return mixed
	 */
	public static function all()
	{
		return $_REQUEST;
	}


	/**
	 * Получить все кроме перечисленного
	 * @return array
	 */
	public static function except()
	{
		$result = array();
		$exept = func_get_args();

		foreach($_REQUEST as $key => $item){
			if(!in_array($key, $exept)){
				$result[$key] = $item;
			}
		}

		return $result;
	}


	/**
	 * Получить только из списка
	 * @return array
	 */
	public static function only()
	{
		$result = array();
		foreach(func_get_args() as $name){
			$result[] = self::get($name);
		}
		return $result;
	}

}