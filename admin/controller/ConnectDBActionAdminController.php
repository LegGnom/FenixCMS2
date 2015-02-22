<?

class ConnectDBActionAdminController extends BaseAdminController{

	function __construct()
	{
		if($this->_isset(Input::all())){
			Response::make(array(
				'error' => 1,
				'push_message' => 'Подключение с такими настройками уже сществует',
			));
			return;
		}

		$db = DB::init(Input::get('instance_name'), Input::all());

		if($db->is_connect()){
			$objects = Objects::create(Input::all());
			foreach ($objects as $key => $object) {
				unset($object['pass']);
				$objects[$key] = $object;
			}

			Response::make(array(
				'error' => 0,
				'name' => Input::get('instance_name'),
				'push_message' => 'Вы подключиль к базе данных <b>'.Input::get('instance_name').'</b>',
				'objects' => $objects
			));
		}else{
			Response::make(array(
				'error' => 1,
				'push_message' => 'Во время подключения к базе данных произошла ошибка, проверьте параметры подключения или попробуйте позже',
			));
		}
	}


	public function _isset($options)
	{
		foreach(Objects::get() as $object){
			if( $object['driver'] === $options['driver'] &&
				$object['name'] === $options['name'] &&
				$object['user'] === $options['user'] ) {
				return true;
			}
		}
		return false;
	}

}