<?

interface DB_Interface {

	/**
	 * В опциях передаются данные для подключения
	 * @param $options
	 */
	function __construct($options);


	/**
	 * Проверка, подключена ли бд
	 * @return mixed
	 */
	public function is_connect();


	/**
	 * Закрытие соединения
	 * @return mixed
	 */
	public function close();


	/**
	 * Получение последнего добавленного id через insert
	 * @return mixed
	 */
	public function last_id();


	/**
	 * Отправка запроса
	 * @param $query
	 * @return mixed
	 */
	public function query( $query );


	/**
	 * Обработка забпроса
	 * @param $query
	 * @param $callback
	 * @return mixed
	 */
	public function extract( $query, $callback = null );


	/**
	 * Поиск по колекции
	 * @param $options
	 * @param $callback
	 * @return mixed
	 */
	public function find( $options, $callback = null );


	/**
	 * Возвращяет 1 результат запроса
	 * @param $options
	 * @return mixed
	 */
	public function find_one( $options );


	/**
	 * Вставка в записи
	 * @param $options
	 * @return mixed
	 */
	public function insert( $options );


	/**
	 * Обнавление записи
	 * @param $options
	 * @return mixed
	 */
	public function update( $options );


	/**
	 * Удаление записи
	 * @param $options
	 * @return mixed
	 */
	public function remove( $options );


	/**
	 * Переключение между бд
	 * @param $name
	 * @return mixed
	 */
	public function use_db( $name );


	/**
	 * Создани бд
	 * @param $name
	 * @return mixed
	 */
	public function create_db( $name );


	/**
	 * Удаление коллекции
	 * @param $name
	 * @return mixed
	 */
	public function remove_db( $name );


	/**
	 * Создание коллекции
	 * @param $name
	 * @param $cols
	 * @return mixed
	 */
	public function create_collection( $name, $cols );


	/**
	 * Удаление коллекции
	 * @param $name
	 * @return mixed
	 */
	public function remove_collection( $name );


	/**
	 * Добавить колонку
	 * @return mixed
	 */
	public function add_column($collection_name, $options);


	/**
	 * Изменить колонку
	 * @return mixed
	 */
	public function edit_column($collection_name, $options);


	/**
	 * Удалить колонку
	 * @return mixed
	 */
	public function remove_column($collection_name, $column_name);


	/**
	 * Показать списком доступные бд
	 * @return mixed
	 */
	public function show_db();


	/**
	 * Показать списком доступные коллекции коллекции
	 * @param $db_name
	 * @return mixed
	 */
	public function show_collection( $db_name );

}
