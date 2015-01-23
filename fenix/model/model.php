<?

abstract class Model implements Model_Interface {


	/**
	 * Ссылка на инстанс DB
	 * @var null
	 */
	private static $instance = null;


	/**
	 * Список доступных коллекций
	 * @var null
	 */
	private static $collection_list = null;


	/**
	 * Подключение к бд
	 */
	public static function init(){
		if(self::$instance === null){
			self::$instance = DB::go(static::get_db());
			$options = static::get_options();

			if( self::$collection_list == null ) {
				self::$collection_list = self::show_collection(static::get_db());
			}

			if ( !in_array($options['name'], self::$collection_list) ){
				self::create_collection($options['name'], $options['cols']);
			}
		}
	}


	/**
	 * Вызов из инстанса функций
	 * @param $name
	 * @param $arguments
	 * @return mixed
	 */
	private static function __call__ ($name, $arguments){
		self::init();
		return call_user_func_array(array(self::$instance, $name), $arguments);
	}


	public static function is_connect(){ return self::__call__(__FUNCTION__, func_get_args()); }
	public static function close(){ return self::__call__(__FUNCTION__, func_get_args()); }
	public static function last_id(){ return self::__call__(__FUNCTION__, func_get_args()); }
	public static function query( $query ){ return self::__call__(__FUNCTION__, func_get_args()); }
	public static function extract( $query, $callback = null ){ return self::__call__(__FUNCTION__, func_get_args()); }
	public static function find( $options, $callback = null ){ return self::__call__(__FUNCTION__, func_get_args()); }
	public static function find_one( $options ){ return self::__call__(__FUNCTION__, func_get_args()); }
	public static function insert( $options ){ return self::__call__(__FUNCTION__, func_get_args()); }
	public static function update( $options ){ return self::__call__(__FUNCTION__, func_get_args()); }
	public static function remove( $options ){ return self::__call__(__FUNCTION__, func_get_args()); }
	public static function use_db( $name ){ return self::__call__(__FUNCTION__, func_get_args()); }
	public static function create_db( $name ){ return self::__call__(__FUNCTION__, func_get_args()); }
	public static function remove_db( $name ){ return self::__call__(__FUNCTION__, func_get_args()); }
	public static function create_collection( $name, $cols ){ return self::__call__(__FUNCTION__, func_get_args()); }
	public static function remove_collection( $name ){ return self::__call__(__FUNCTION__, func_get_args()); }
	public static function add_column($collection_name, $options){ return self::__call__(__FUNCTION__, func_get_args()); }
	public static function edit_column($collection_name, $options){ return self::__call__(__FUNCTION__, func_get_args()); }
	public static function remove_column($collection_name, $column_name){ return self::__call__(__FUNCTION__, func_get_args()); }
	public static function show_db(){ return self::__call__(__FUNCTION__, func_get_args()); }
	public static function show_collection( $db_name ){ return self::__call__(__FUNCTION__, func_get_args()); }

}

interface Model_Interface {
	public static function get_db();
	public static function get_options();
}
