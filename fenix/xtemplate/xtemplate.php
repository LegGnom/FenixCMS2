<?

class XTemplate {

	private static $xsl = null;
	private static $xml = null;
	private static $root = null;
	private static $proc = null;


	/**
	 * Инициализация
	 */
	private static function init()
	{
		if(self::$xml === null || self::$xsl === null){
			self::$xml = new DOMDocument('1.0', 'UTF-8');
			self::$xsl = new DOMDocument();
			self::$proc = new XSLTProcessor();

			self::$root = self::$xml;
			self::$root = self::append(false, 'root');
		}
	}


	/**
	 * Добавить ноду
	 * @param $to
	 * @param $name
	 * @param bool $text
	 * @param bool $fragment
	 * @return mixed
	 */
	public static function append($to, $name, $text = false, $fragment = false)
	{
		self::init();
		$to = ($to !== false) ? $to : self::$root;
		if($text !== false){
			if($fragment || self::is_html($text)){
				$st = self::$xml->createDocumentFragment();
				$st->appendXML($text);
				$el = self::$xml->createElement($name);
				$el->appendChild($st);
				$to->appendChild($el);
				return $el;
			}else{
				$el = self::$xml->createElement($name, $text);
				$to->appendChild($el);
				return $el;
			}
		}else{
			$el = self::$xml->createElement($name);
			$to->appendChild($el);
			return $el;
		}
	}


	/**
	 * Добавить атрибут
	 * @param $to
	 * @param $name
	 * @param $text
	 * @return null
	 */
	public static function addAttr($to, $name, $text)
	{
		if($name == ''){
			trigger_error('name not exist');
		}

		self::init();

		$to = ($to !== false) ? $to : self::$root;

		$el = self::$xml->createAttribute($name);
		$to->appendChild($el);
		$st = self::$xml->createTextNode($text);
		$el->appendChild($st);
		return $to;
	}


	/**
	 * Массив в xml
	 * @param $to
	 * @param $arr
	 */
	public static function arrayToXML($to, $arr)
	{
		foreach($arr as $k => $v){
			if(is_array($v)){
				if(is_string($k)){
					self::arrayToXML(self::append($to, $k), $v);
				}else{
					self::arrayToXML($to, $v);
				}
			}else{
				self::append($to, $k, $v, true);
			}
		}
	}


	/**
	 * Вывод xml как строки
	 * @return mixed
	 */
	public static function showXML()
	{
		self::init();
		header( "content-type: application/xml; charset=utf-8" );
		self::$xml->formatOutput = true;
		return self::$xml->saveXML();
	}


	/**
	 * Трансформация xslt в html
	 * @param $string
	 * @return string
	 */
	public static function transform($string)
	{
		self::init();
		self::$xsl->loadXML($string);

		self::$proc->importStylesheet(self::$xsl);
		return self::$proc->transformToXML(self::$xml);
	}


	/**
	 * Установка переменной в препроцессоре
	 * @param $name
	 * @param $value
	 * @param string $namespace
	 */
	public static function set_variable($name, $value, $namespace = '')
	{
		self::init();
		self::$proc->setParameter($namespace, $name, $value);
	}


	/**
	 * Получение переменной из препроцессора
	 * @param $name
	 * @param string $namespace
	 * @return mixed
	 */
	public static function get_variable($name, $namespace = '')
	{
		self::init();
		return self::$proc->getParameter($namespace, $name);
	}


	/**
	 * Удаление переменной из препроцессора
	 * @param $name
	 * @param string $namespace
	 * @return mixed
	 */
	public static function remove_variable($name, $namespace = '')
	{
		self::init();
		return self::$proc->removeParameter($namespace, $name);
	}


	/**
	 * Определение наличия html тегов в строке
	 * @param $str
	 * @param bool $count
	 * @return array|bool
	 */
	public static function is_html($str,$count = false)
	{
		$html = array(
			'A','ABBR','ACRONYM','ADDRESS','APPLET','AREA','B','BASE','BASEFONT','BDO',
			'BIG','BLOCKQUOTE','BODY','BR','BUTTON','CAPTION','CENTER','CITE','CODE','COL',
			'COLGROUP','DD','DEL','DFN','DIR','DIV','DL','DT','EM','FIELDSET','FONT','FORM',
			'FRAME','FRAMESET','H1','H2','H3','H4','H5','H6','HEAD','HR','HTML','I','IFRAME',
			'IMG','INPUT','INS','ISINDEX','KBD','LABEL','LEGEND','LI','LINK','MAP','MENU','META',
			'NOFRAMES','NOSCRIPT','OBJECT','OL','OPTGROUP','OPTION','P','PARAM','PRE','Q',
			'S','SAMP','SCRIPT','SELECT','SMALL','SPAN','STRIKE','STRONG','STYLE','SUB',
			'SUP','TABLE','TBODY','TD','TEXTAREA','TFOOT','TH','THEAD','TITLE','TR','TT','U','UL','VAR');

		if(preg_match_all("~(<\/?)\b(".implode('|',$html).")\b([^>]*>)~i",$str,$c)){
			if($count)
				return array(true, count($c[0]));
			else
				return true;
		}else{
			return false;
		}
	}

}