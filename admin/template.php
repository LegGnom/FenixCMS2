<?

require_once dirname(__FILE__) . '/Twig/Autoloader.php';
Twig_Autoloader::register();

$loader = new Twig_Loader_Filesystem(View::get_path());
$twig_render_string = new Twig_Environment(new Twig_Loader_String());
$twig = new Twig_Environment($loader, array(
	//'cache' => '',
));


require_once dirname(__FILE__) . '/twig_extension/Twig_Extension_TemplateLoader.php';
$twig->addExtension(new Twig_Extension_TemplateLoader);

require_once dirname(__FILE__) . '/twig_extension/Twig_Extension_GetUrl.php';
$twig->addExtension(new Twig_Extension_GetUrl);

require_once dirname(__FILE__) . '/twig_extension/Twig_Extension_LoadScripts.php';
$twig->addExtension(new Twig_Extension_LoadScripts);


View::call_string(function($template, $data = array()) use($twig_render_string) {
	echo $twig_render_string->render($template, $data);
});

View::call_file(function ($template, $data = array()) use ($twig) {
	echo $twig->render($template, $data);
});
