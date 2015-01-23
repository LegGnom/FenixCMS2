<?


abstract class DB_Cover {


	/**
	 * Список доступных опций
	 * @var array
	 */
	protected $query_options = array (
		'from' => '', // Имя таблици
		'type' => '', // Тип find/insert/update/remove
		'cols' => '', // В зависимости от типа запроса набор полей
		'where' => array(), // Условие
		'sort' => '', // Сортировака array('user' => 1, 'user' => -1)
		'limit' => '', // Максимальное количество в выдаче
		'skip' => '' // Шаг
	);


	/**
	 * @param $options
	 * @return array
	 */
	protected function options_merge( $options ){
		return array_merge($this->query_options, $options);
	}
}