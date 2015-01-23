<?

date_default_timezone_set("UTC");
ini_set('display_errors',1);
error_reporting(E_ALL);


require_once dirname(__FILE__) . '/fenix/index.php';
require_once dirname(__FILE__) . '/admin/index.php';


App::set_controller_path(dirname(__FILE__) . '/controller/');
View::set_path(dirname(__FILE__) . '/view/');


