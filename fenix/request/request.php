<?

/**
 * Class Request
 * работа с ответом сервера
 */
class Request {


	/**
	 * Текущий урл в виде массива
	 * @var null
	 */
	private static $array = null;


	/**
	 * Конвертирование урла в массив
	 * @return array|null
	 */
	public static function path_to_array()
	{
		if( self::$array == null ){
			self::$array = URL::parse(self::path());
		}
		return self::$array;
	}


	/**
	 * Текущий урл
	 * @return mixed
	 */
	public static function path()
	{
		return $_SERVER['REQUEST_URI'];
	}


	/**
	 * Метод
	 * @param $name
	 * @return bool
	 */
	public static function is_method($name)
	{
		return strtolower($name) === self::method();
	}


	/**
	 * Проверка метода
	 * @return string
	 */
	public static function method()
	{
		return strtolower($_SERVER['REQUEST_METHOD']);
	}


	/**
	 * Получение части урл
	 * @param $num
	 * @return string
	 */
	public static function segment($num)
	{
		return '/' . implode('/', array_slice(self::path_to_array(), 0, $num));
	}
}