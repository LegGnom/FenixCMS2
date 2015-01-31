<?

class ConnectDBActionAdminController extends BaseAdminController{

	function __construct(){
		Objects::create(Input::all());
	}

}