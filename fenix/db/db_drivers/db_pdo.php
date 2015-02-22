<?

require_once dirname(__FILE__) . '/db_mysql.php';

class DB_PDO extends DB_MySQL implements DB_Interface {

	function __construct($options)
	{
		$this->options = $options;
		try {
			$this->db = new PDO('mysql:host=' . $options['host'] . ';dbname=' . $options['name'], $options['user'], $options['pass'], array(
				PDO::ATTR_PERSISTENT => true,
				PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES UTF8'
			));
		} catch (Exception $exc) {
			$this->db = false;
			return false;
		}
	}

	public function close()
	{
		$this->db = null;
	}

	public function last_id()
	{
		return $this->db->lastInsertId();
	}

	public function query( $query )
	{
		if($this->is_connect()){
			return $this->db->query($query, PDO::FETCH_ASSOC);
		}
	}

	public function extract( $query, $callback = null )
	{
		if($query == false) return array();

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

}