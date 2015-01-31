<?

class StructureAdminController extends BaseAdminController{

	function __construct(){
		$this->add('crumb', array(
			array(
				'name' => 'Структура',
				'link' => '/admin/structure/'
			)
		));


		$this->render('blocks/l-structure/l-structure.twig');
	}

}