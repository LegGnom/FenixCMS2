<?

class Twig_Extension_TemplateLoader extends Twig_Extension{
	private static $template_list = array();
	public function getFunctions()
	{
		return array(
			new Twig_SimpleFunction(
				'template_loader',
				'Twig_Extension_TemplateLoader::template_loader',
				array(
					'needs_context' => true,
					'needs_environment' => true
				)),
		);
	}
	public function getName()
	{
		return 'template_loader';
	}
	public static function template_loader($env, $context, $path)
	{
		try{
			$list = self::parse_string($env, $path);
			foreach($list as $key => $value){
				echo '<script class="twig-template" data-path="'. $key .'" type="text/html">'. $value .'</script>';
			}
			self::$template_list = array_merge(self::$template_list, $list);
		}catch (Exception $e){
			echo $e;
		}
	}
	public static function parse_string($env, $path)
	{
		$result_list = array();
		$find_list = array($path);
		while(count($find_list))
		{
			$item = array_shift($find_list);
			$item = trim($item, '"');
			$item = trim($item, "'");
			if(isset(self::$template_list[$item]) || isset($result_list[$item])){
				continue;
			}
			$template = $env->getLoader()->getSource($item);
			$result_list[$item] = $template;
			$find = array();
			$regexp = '~[\'|\"]{1}[^\']+.twig[\"\']{1}~';
			preg_match_all($regexp, $template, $find);
			$find = array_shift($find);
			$find_list = array_merge($find_list, $find);
		}
		return $result_list;
	}
}