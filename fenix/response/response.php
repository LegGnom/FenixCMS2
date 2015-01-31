<?

class Response {

	public static function make($content, $status = 200)
	{
		return new Response_object($content, $status);
	}


	public static function header_json()
	{
		header("Content-type: application/json; charset=utf-8");
	}

	public static function header_status($status)
	{
		header("HTTP/1.0 " . $status);
	}

}

class Response_object {

	private $status = 200;
	private $content = '';


	function __construct($content, $status)
	{
		$this->content = $content;
		$this->status = $status;
	}


	function __destruct(){
		$this->go();
	}


	public function go(){
		$content = is_array($this->content) ? json_encode($this->content) : $this->content;

		Response::header_status($this->status);

		if(is_array($this->content)){
			Response::header_json();
		}

		echo $content;
	}

}