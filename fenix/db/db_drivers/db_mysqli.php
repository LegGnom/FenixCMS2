<?

require_once dirname(__FILE__) . '/db_mysql.php';

class DB_MySQLi extends DB_MySQL implements DB_Interface{

	function __construct($options)
	{
		try {
			$this->options = $options;
			$this->db = mysqli_connect($options['host'], $options['user'], $options['pass'], $options['name']);
		} catch (Exception $exc) {
			$this->db = false;
			return false;
		}

		if($this->db) {

			mysqli_select_db($this->db, $options['name']);
			$this->query("SET NAMES utf8");
			$this->query("set character_set_client='utf8'");
			$this->query("set character_set_results='utf8'");
			$this->query("set collation_connection='utf8_general_ci'");

			return true;
		}

		return false;
	}


	public function close()
	{
		if($this->is_connect()){
			return mysqli_close($this->db);
		}
		return false;
	}


	public function last_id()
	{
		return mysqli_insert_id($this->db);
	}


	public function query( $query )
	{
		return $this->db->query($query);
	}


	public function extract( $query, $callback = null )
	{
		if($query === false) return array();

		$result = array();
		$i = 0;
		while($item = mysqli_fetch_assoc($query)){
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