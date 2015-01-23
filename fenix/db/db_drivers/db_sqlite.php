<?

class DB_SQLite extends DB_Cover implements DB_Interface {

	private $options = array();
	private $db = null;

	function __construct($options){
		$this->db = new SQLite3($options['location'] . $options['name'] . '.db');
	}

	public function is_connect(){}

	public function close(){}

	public function last_id(){}

	public function query( $query ){}

	public function extract( $query, $callback = null ){}

	public function find( $options, $callback = null ){}

	public function find_one( $options ){}

	public function insert( $options ){}

	public function update( $options ){}

	public function remove( $options ){}

	public function use_db( $name ){}

	public function create_db( $name ){}

	public function remove_db( $name ){}

	public function create_collection( $name, $cols ){}

	public function remove_collection( $name ){}

	public function add_column($collection_name, $options){}

	public function edit_column($collection_name, $options){}

	public function remove_column($collection_name, $column_name){}

	public function show_db(){}

	public function show_collection( $db_name ){}

}