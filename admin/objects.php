<?

class Objects {

	public static function create($options)
	{
		$db = DB::init($options['instance_name'], $options);

		if($db->is_connect()){
			Response::make(array(
				'error' => 0,
				'name' => $options['instance_name'],
				'collections' => $db->show_collection($options['name'])
			));
		}else{
			Response::make(array(
				'error' => 1,
				'message' => ''
			));
		}
	}

}