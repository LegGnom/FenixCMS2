<?

define('__fenix__', true);


require_once dirname(__FILE__) . '/db/db.php';
require_once dirname(__FILE__) . '/app/app.php';
require_once dirname(__FILE__) . '/model/model.php';
require_once dirname(__FILE__) . '/cookie/cookie.php';
require_once dirname(__FILE__) . '/view/view.php';
require_once dirname(__FILE__) . '/controller/controller.php';
require_once dirname(__FILE__) . '/xtemplate/xtemplate.php';
require_once dirname(__FILE__) . '/input/input.php';
require_once dirname(__FILE__) . '/route/route.php';
require_once dirname(__FILE__) . '/redirect/redirect.php';
require_once dirname(__FILE__) . '/request/request.php';
require_once dirname(__FILE__) . '/response/response.php';
require_once dirname(__FILE__) . '/url/url.php';


View::call_string(function($string, $data = array())
{
	echo $string;
});


View::call_file(function($path, $data = array())
{
	extract($data);
	ob_start();
		require_once View::get_path() . $path;
	ob_end_flush();
});