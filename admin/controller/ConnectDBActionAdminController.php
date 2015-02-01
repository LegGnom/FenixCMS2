<?

class ConnectDBActionAdminController extends BaseAdminController{

	function __construct(){
		$db = DB::init(Input::get('instance_name'), Input::all());


		if($db->is_connect()){
			Response::make(array(
				'error' => 0,
				'name' => Input::get('instance_name'),
				'push_message' => 'Вы подключиль к базе данных <b>'.Input::get('instance_name').'</b>',
				'collections' => $db->show_collection(Input::get('name'))
			));
		}else{
			Response::make(array(
				'error' => 1,
				'push_message' => 'Во время подключения к базе данных произошла какаято ошибка, проверьте параметры подключения или попробуйте позже',
			));
		}

		//Objects::create();
	}

}