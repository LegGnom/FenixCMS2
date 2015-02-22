<?

class StructureAdminController extends BaseAdminController{

	function __construct()
	{
		$this->add('crumb', array(
			array(
				'name' => 'Структура',
				'link' => '/admin/structure/'
			)
		));

		$this->add('objects', Objects::get());
		$this->add('structure_url', Request::segment(2));


		$this->render('blocks/l-structure/l-structure.twig');
	}

}