<?


/**
 * Работа с запросом, и преобразование его в sql
 * Class DB_Transport
 */
class DB_Query extends DB_Cover{

	private static $col_option = array(
		'type' => '',
		'size' => '',
		'index' => '',
		//'default' => ''
	);


	private static $col_types = array(
		// Числа
		'bigint', 'numeric', 'bit', 'smallint',
		'decimal', 'smallmoney', 'int', 'tinyint',
		'money',

		'text', 'ntext',

		// Приблизительные числа
		'float', 'real',

		// Дата и время
		'Date', 'datetimeoffset', 'datetime2', 'smalldatetime',
		'datetime', 'time',

		// Символьные строки
		'char', 'varchar', 'text',

		// Символьные строки в Юникоде
		'nchar', 'nvarchar', 'ntext',

		// Двоичные данные
		'binary', 'varbinary', 'image',

		// Прочие типы данных
		'timestamp', 'hierarchyid', 'uniqueidentifier', 'sql_variant',
		'xml', 'cursor', 'table'
	);


	/**
	 * Преобразование объекта crud в sql запрос
	 * @param $options
	 * @return string
	 */
	public static function crud_to_mysql( $options )
	{
		// TODO Доделать crud оперции для sql
		$result = array();
		$patterns = array(
			'find' => 'SELECT {cols} FROM {from} {where} {order} {limit} {skip}',
			'insert' => 'INSERT INTO {from} ({cols_name}) VALUES ({cols_value})',
			'update' => 'UPDATE {from} SET {cols} {where}',
			'remove' => 'DELETE FROM {from} {where}'
		);

		$cols = $options['type'] === 'find' ? '*' : '';
		$order = '';
		$limit = '';
		$skip = '';
		$cols_name = '';
		$cols_value = '';

		if($options['sort'] && is_array($options['sort'])){
			$order = array();
			foreach($options['sort'] as $key => $value){
				$order[] = '`' . $key . '` ' . ($value === 1 ? 'ASC' : 'DESC');
			}
			$order = 'ORDER BY ' . implode(', ', $order);
		}

		if($options['limit'] && is_numeric($options['limit'])){
			$limit = 'LIMI ' . (int) $options['limit'];
		}

		if($options['skip'] && is_numeric($options['skip'])){
			$skip = 'SKIP ' . (int) $options['skip'];
		}

		if($options['type'] === 'update' && is_array($options['cols'])){
			$cols = array();
			foreach($options['cols'] as $key => $item){
				$cols[] = '`' . $key . '`=\''.$item.'\'';
			}
			$cols = implode(', ', $cols);
		}

		if($options['type'] === 'insert' && is_array($options['cols']) && count($options['cols'])){
			$cols_name = implode(', ', array_keys($options['cols']));
			$cols_value = '\'' . implode('\', \'', $options['cols']) . '\'';
		}


		$replace = array(
			'{cols}' => $cols,
			'{from}' => $options['from'],
			'{order}' => $order,
			'{limit}' => $limit,
			'{skip}' => $skip,
			'{where}' => self::where_to_mysql($options['where']),
			'{cols_name}' => $cols_name,
			'{cols_value}' => $cols_value
		);

		$result = trim(str_replace(array_keys($replace), $replace, $patterns[$options['type']]));

		return $result;
	}


	/**
	 * Трансформация WHERE в SQL
	 * @param $where
	 * @param string $name
	 * @param string $glue
	 * @param string $put
	 * @return mixed
	 */
	public static function where_to_mysql( $where, $name = '', $glue = 'AND', $put = '{pattern}' )
	{
		$pattern = '`{key}` = {value}';
		$operators = array(
			'$lt' => '{key} < {value}',
			'$gt' => '{key} > {value}',
			'$lte' => '{key} <= {value}',
			'$gte' => '{key} >= {value}',
			'$ne' => '{key} != {value}',
			'$in' => '{key} IN ({value})',
			'$nin' => '{key} NOT IN ({value})',
			'$search' => '{key} LIKE %{value}%',
			'$left_search' => '{key} LIKE %{value}',
			'$right_search' => '{key} LIKE {value}%',
		);

		$logic = array(
			'$not', '$and', '$or', '$nor',
		);

		$result = array();

		foreach($where as $key => $item){
			if(isset($operators[$key])){
				$pattern = $operators[$key];
			}elseif(in_array($key, $logic)){
				if($key == '$not'){
					$result[] = self::where_to_mysql($item, $name, $glue, 'NOT ({pattern})');
				}elseif($key == '$and'){
					$result[] = self::where_to_mysql($item, $name, 'AND', '({pattern})');
				}elseif($key == '$or'){
					$result[] = self::where_to_mysql($item, $name, 'OR', '({pattern})');
				}elseif($key == '$nor'){
					$result[] = self::where_to_mysql($item, $name, 'OR', 'NOT ({pattern})');
				}
				continue;
			}else{
				$name = $key;
			}

			$value = '';
			if(is_numeric($item)){
				$value = $item;
			}elseif(is_string($item)){
				$value = '\'' . $item . '\'';
			}elseif(is_array($item)){
				$result[] = self::where_to_mysql($item, $name);
				continue;
			}

			$result[] = str_replace(array('{key}', '{value}'), array($name, $value), $pattern);
		}

		return str_replace('{pattern}', implode(' '.$glue.' ', $result), $put);
	}


	public static function cols_to_mysql( $options )
	{
		$default_size = array(
			'bigint' => 2, 'numeric' => 2, 'bit' => 2, 'smallint' => 2,
			'decimal' => 2, 'smallmoney' => 2, 'int' => 2, 'tinyint' => 2,
			'money' => 2,'float' => 2, 'real' => 2,
			'char' => 128, 'varchar' => 128, 'nchar' => 128, 'nvarchar' => 128
		);

		$result = array();
		foreach($options as $name => $item){
			if(is_string($item)){
				$item = array( 'type' => $item );
			}

			$item = array_merge(self::$col_option, $item);
			$string = array();

			if(!in_array($item['type'], self::$col_types)){
				trigger_error('undefined type');
				continue;
			}

			if(!$item['size']){
				if(in_array($item['type'], array('text', 'ntext'))){
					$item['size'] = '';
				}else{
					$item['size'] = $default_size[$item['type']];
				}
			}

			$string[] = '`'.$name.'`';
			$string[] = strtoupper($item['type']);

			if($item['size']){
				$string[] = '(' . (int) $item['size'] .')';
			}

			$string[] = 'NOT NULL';


			if($item['index']){
				$index = str_split(strtolower($item['index']));
				if(in_array('a', $index))
				{
					$string[] = 'AUTO_INCREMENT';
				}
				if(in_array('p', $index))
				{
					$string[] = 'PRIMARY KEY';
				}
				if(in_array('u', $index))
				{
					$string[] = 'UNIQUE';
				}
				if(in_array('i', $index))
				{
					$string[] = 'INDEX';
				}

			}

			$result[] = implode(' ', $string);
		}

		return $result;
	}


}