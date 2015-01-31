<?

require_once dirname(__FILE__) . '/objects.php';

if(!defined('__fenix__')){
	require_once '../index.php';
}


if( !defined('__fenix_admin__') ){
	define('__fenix_admin__', true);

	App::set_controller_path(dirname(__FILE__) . '/controller/');
	View::set_path(dirname(__FILE__) . '/view/');

	require_once dirname(__FILE__) . '/controller/BaseAdminController.php';
	require_once dirname(__FILE__) . '/template.php';
	require_once dirname(__FILE__) . '/route.php';
}