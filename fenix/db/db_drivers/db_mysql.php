<?

class DB_MySQL extends DB_Cover implements DB_Interface {

	protected $options = array();
	protected $db = null;

	function __construct($options)
	{
		try {
			$this->options = $options;
			$this->db = mysql_connect($options['host'], $options['user'], $options['pass'], $options['name']);
		} catch (Exception $exc) {
			$this->db = false;
			return false;
		}

		mysql_select_db($options['name']);
		mysql_query ("SET NAMES utf8");
		mysql_query ("set character_set_client='utf8'");
		mysql_query ("set character_set_results='utf8'");
		mysql_query ("set collation_connection='utf8_general_ci'");

		return true;
	}

	public function is_connect()
	{
		return !!$this->db;
	}

	public function close()
	{
		if($this->is_connect()){
			return mysql_close($this->db);
		}
		return false;
	}

	public function last_id()
	{
		return mysql_insert_id();
	}

	public function query( $query )
	{
		return $query;
		return mysql_query($query, $this->db);
	}

	public function extract( $query, $callback = null )
	{
		return $query;
		if($query === false) return array();

		$result = array();
		$i = 0;
		while($item = mysql_fetch_assoc($query)){
			if(is_callable($callback)){
				$result[$i] = $callback($item, $this);
			}else{
				foreach($item as $k => $v){
					$item[$k] = DB::unescape($v);
				}
				$result[$i] = $item;
			}
			$i++;
		}
		return $result;
	}

	public function find( $options, $callback = null )
	{
		$options = $this->options_merge($options);
		$options['type'] = 'find';
		return $this->extract(
			$this->query(DB_Query::crud_to_mysql($options)),
			$callback
		);
	}

	public function find_one( $options )
	{
		$options = $this->options_merge($options);
		$options['limit'] = 1;
		return $this->find($options);
	}

	public function insert( $options )
	{
		$options = $this->options_merge($options);
		$options['type'] = 'insert';
		return $this->query(DB_Query::crud_to_mysql($options));
	}

	public function update( $options )
	{
		$options = $this->options_merge($options);
		$options['type'] = 'update';
		return $this->query(DB_Query::crud_to_mysql($options));
	}

	public function remove( $options )
	{
		$options = $this->options_merge($options);
		$options['type'] = 'remove';
		return $this->query(DB_Query::crud_to_mysql($options));
	}

	public function use_db( $name )
	{
		return $this->query( 'USE `'. $name .'`' );
	}

	public function create_db( $name )
	{
		return $this->query( 'CREATE DATABASE `'.$name.'`' );
	}

	public function remove_db( $name )
	{
		return $this->query( 'DROP DATABASE `'.$name.'`' );
	}

	public function create_collection( $name, $cols )
	{
		$query = array(
			'CREATE TABLE `',
			$name,
			"`(\n",
			implode(",\n", DB_Query::cols_to_mysql($cols)),
			"\n) DEFAULT CHARACTER SET utf8 DEFAULT COLLATE utf8_general_ci"
		);

		return $this->query( implode('', $query) );
	}

	public function remove_collection( $name )
	{
		return $this->query( 'DROP TABLE ' . $name );
	}

	public function add_column($collection_name, $options)
	{

		$this->query('ALTER TABLE `'.$collection_name.'` ADD ' . DB_Query::cols_to_mysql($options));
	}

	public function edit_column($collection_name, $options)
	{
		// TODO додумать как переименовывать колонки
	}

	public function remove_column($collection_name, $column_name)
	{
		return $this->query('ALTER TABLE `' .$column_name. '` DROP COLUMN `'.$column_name.'`');
	}


	public function show_db()
	{
		return $this->extract($this->query( 'SHOW DATABASES' ), function($item){
			return array_shift($item);
		});
	}

	public function show_collection( $db_name )
	{
		return $this->extract($this->query( 'SHOW TABLES' ), function($item){
			return array_shift($item);
		});
	}

}