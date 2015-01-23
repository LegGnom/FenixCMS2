<?

require_once dirname(__FILE__) . '/Twig/Autoloader.php';
Twig_Autoloader::register();

$loader = new Twig_Loader_Filesystem(View::get_path());
$twig_render_string = new Twig_Environment(new Twig_Loader_String());
$twig = new Twig_Environment($loader, array(
	//'cache' => '',
));

View::call_string(function($template, $data = array()) use($twig_render_string) {
	echo $twig_render_string->render($template, $data);
});

View::call_file(function ($template, $data = array()) use ($twig) {
	echo $twig->render($template, $data);
});