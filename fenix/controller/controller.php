<?

abstract class Controller {

	protected $ctx = array();

	/**
	 * Рендер шаблона через View
	 */
	protected function render($template, $context = array()){
		View::render($template, array_merge(
			$this->ctx,
			$context
		));
	}


	/**
	 * Наполнение контекта
	 * @param $context
	 */
	protected function add($context)
	{
		$argv = func_get_args();
		if(count($argv) == 2){
			$this->ctx[$argv[0]] = $argv[1];
		}else{
			$this->ctx = array_merge(
				$this->ctx,
				$context
			);
		}
	}

}