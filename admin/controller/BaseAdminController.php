<?

class BaseAdminController extends Controller {

	function render($template, $data = array()){
		return parent::render($template, array_merge($this->ctx(), $data));
	}


	private function ctx(){
		return array(
			'admin_url' => '/admin/',
			'self_url' => $_SERVER['REQUEST_URI'],
			'header_menu' => array(
				array(
					'name' => 'Проект',
					'link' => 'project'
				),
				array(
					'name' => 'Структура',
					'link' => 'structure'
				),
				array(
					'name' => 'Настройки',
					'link' => 'settings'
				),
			),
			'header_dropdown_menu' => array(
				array(
					'name' => 'Публичные страници',
					'link' => 'publick_page'
				)
			),
			'db_drivers' =>  DB::$drivers,
		);
	}

}