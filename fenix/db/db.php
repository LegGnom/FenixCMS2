<?

require_once dirname(__FILE__) . '/db_interface.php';
require_once dirname(__FILE__) . '/db_cover.php';
require_once dirname(__FILE__) . '/db_query.php';


/**
 * Class DB
 */
class DB {

	const int = 'int';


	/**
	 * Список инстанцированных бд
	 * @var array
	 */
	private static $instance = array();


	/**
	 * Список доступных драйверов
	 * @var array
	 */
	private static $drivers = array(
		'pdo' => 'PDO',
		'mysql' => 'MySQL',
		'mysqli' => 'MySQLi',
		'sqlite' => 'SQLite',
		'mongo' => 'Mongo'
	);


	/**
	 * Возвращяет инстанц бд
	 * @param $instance_name
	 * @param $options
	 * @return null
	 */
	public static function init($instance_name, $options)
	{
		$options = array_merge(array(
			'location' => '',
			'driver' => 'mysqli',
			'host' => 'localhost',
			'port' => '',
			'name' => '',
			'user' => '',
			'pass' => ''
		), $options);

		$driver = $options['driver'] = strtolower($options['driver']);

		if(isset(self::$drivers[$driver])){
			$class_name = 'DB_' . self::$drivers[$driver];

			if(!class_exists($class_name)){
				$file_name = dirname(__FILE__) . '/db_drivers/db_'.$driver.'.php';
				if(file_exists($file_name)){
					require_once $file_name;
				}
			}

			if(class_exists($class_name)){
				$options['instance_name'] = $instance_name;
				self::$instance[$instance_name] = new $class_name($options);
				return self::$instance[$instance_name];
			}else{
				trigger_error('driver not found, try to upgrade');
			}
		}else{
			trigger_error('not driver ' . $options['drive']);
		}

		return null;
	}


	/**
	 * Закрывает соединение с бд
	 * @param $instance_name
	 */
	public static function close($instance_name)
	{
		$instance = self::go($instance_name);
		$instance->close();
		unset(self::$instance[$instance_name]);
	}


	/**
	 * Подключение к уже инстанцированной бд
	 * @param $instance_name
	 * @return bool
	 */
	public static function go($instance_name)
	{
		if(isset(self::$instance[$instance_name])){
			return self::$instance[$instance_name];
		}else{
			trigger_error('instance ' . $instance_name . ' not found');
		}

		return false;
	}


	/**
	 * Экранирование строки
	 * @param $string
	 * @return string
	 */
	public static function escape($string)
	{
		return addslashes($string);
	}


	/**
	 * @param $string
	 * @return string
	 */
	public static function unescape($string)
	{
		return stripslashes($string);
	}

}

