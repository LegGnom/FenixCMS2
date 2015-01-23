<?

/**
 * Class URL
 * работа с url
 */
class URL {

	public static function parse($url)
	{
		return explode('/', trim($url, '/'));
	}

}