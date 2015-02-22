<?

class Objects {

	public static function create($options)
	{
		$file_path = self::get_path();
		$config = self::get();

		$config[] = $options;

		$string_config = '<? return $config = ' . var_export($config, true) . ';';
		file_put_contents($file_path, $string_config);

		return $config;
	}


	public static function get($name = false)
	{
		$file_path = self::get_path();
		$config = array();

		if( file_exists($file_path) ){
			$config = include $file_path;
		}

		if( $name ){
			$name = strtolower($name);
			foreach($config as $object){
				if(strtolower($object['instance_name']) === $name){
					return $object;
				}
			}
			return array();
		}


		return $config;
	}


	public static function get_path()
	{
		$save_path = $_SERVER['DOCUMENT_ROOT'];
		$file_name = '/config.php';
		return $save_path . $file_name;
	}

}