<?

class DB_Mongo extends DB_Cover implements DB_Interface {

	private $last_insert_id = null;
	private $options = array();
	private $instance = null;
	private $db = null;


	function __construct($options)
	{
		$this->options = $options = array_merge(array(), $options);

		$query = array('mongodb://');
		if($options['user'] && $options['pass']){
			$query[] = $options['user'];
			$query[] = ':' .$options['pass'];
		}

		if($options['host']){
			if(count($query) > 1){
				$query[] = '@';
			}

			$query[] = $options['host'];
		}

		if($options['port']){
			$query[] = ':'.$options['port'];
		}

		$query = count($query) > 1 ? implode('',$query) : false;

		try {
			$this->instance = new MongoClient($query);
			$this->db = $this->instance->selectDB($options['name']);
		} catch (Exception $exc) {
			$this->db = false;
			return false;
		}
	}

	public function is_connect()
	{
		return !!$this->db;
	}

	public function close()
	{
		$this->db->close();
	}

	public function last_id()
	{
		return $this->last_insert_id;
	}

	public function query( $options ){}

	public function extract( $query, $callback = null )
	{
		$result = array();
		$i = 0;
		foreach($query as $item){
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

		$collection = $this->db->{$options['from']};
		$find = $collection->find($options['where']);

		if(is_array($options['sort'])){
			$find->sort($options['sort']);
		}
		if(is_numeric($options['limit'])){
			$find->limit($options['limit']);
		}
		if(is_numeric($options['skip'])){
			$find->skip($options['skip']);
		}
		return $this->extract($find, $callback);
	}

	public function find_one( $options )
	{
		$options = $this->options_merge($options);
		$options['limit'] = 1;
		$find = $this->find($options);
		return array_pop($find);
	}

	public function insert( $options )
	{
		$options = $this->options_merge($options);
		$collection = $this->db->{$options['from']};
		$collection->insert($options['cols']);
		$this->last_insert_id = $options['cols']['_id'];
	}

	public function update( $options )
	{
		$options = $this->options_merge($options);
		$collection = $this->db->{$options['from']};
		$collection->update(
			$options['where'],
			array('$set' => $options['cols']),
			array('multiple' => true)
		);
	}

	public function remove( $options )
	{
		$options = $this->options_merge($options);
		$collection = $this->db->{$options['from']};
		$collection->remove($options['where']);
	}

	public function use_db( $name )
	{
		$this->db = $this->instance->{$name};
	}

	public function create_db( $name )
	{
		$this->db = $this->instance->{$name};
	}

	public function remove_db( $name )
	{
		$this->instance->{$name}->drop();
	}

	public function create_collection( $name, $cols = null )
	{
		$this->db->createCollection($name);
	}

	public function add_column($collection_name, $options)
	{
		$column_name = is_string($options) ? $options : $options['type'];

		$this->db->{$collection_name}->update(
			array(),
			array('$unset' => array( $column_name => '')),
			array('multiple' => true)
		);
	}

	public function edit_column($collection_name, $options)
	{
		// TODO додумать как переименовывать колонки
	}

	public function remove_column($collection_name, $column_name)
	{
		$this->db->{$collection_name}->update(
			array(),
			array('$unset' => array( $column_name => '')),
			array('multiple' => true)
		);
	}

	public function remove_collection( $name )
	{
		$this->db->{$name}->drop();
	}

	public function show_db()
	{
		$list = $this->db->listDBs();
		$result = array();
		foreach ($list['databases'] as $item) {
			$result[] = $item['name'];
		}
		return $result;
	}

	public function show_collection( $db_name )
	{
		return $this->db->getCollectionNames();
	}

}