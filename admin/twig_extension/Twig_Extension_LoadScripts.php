<?
class Twig_Extension_LoadScripts extends Twig_Extension{

    public function getFunctions()
    {
        return array(
            new Twig_SimpleFunction(
                'load_scripts',
                'Twig_Extension_LoadScripts::load_scripts'),
        );
    }
    public function getName()
    {
        return 'load_scripts';
    }
    public static function load_scripts($name)
    {
        $name = mb_strtolower($name);
        $path = dirname(dirname(__FILE__)) . '/view';
        $file_path = $path . '/blocks/scripts.json';
        $compress_path = $path . '/compress';

        if(file_exists($file_path)){
            $config = (array) json_decode(file_get_contents($file_path));
            $compress_file = $compress_path . $name . '.js';
            $compress_last_modif = file_exists($compress_file) ? filemtime($compress_file) : 0;

            $result = array();
            $is_compress = true;

            if( isset($config[$name]) ){
                foreach($config[$name] as $item){
                    if( $compress_last_modif && filemtime($_SERVER['DOCUMENT_ROOT'] . $item) > $compress_last_modif){
                        $is_compress = false;
                    }else{
                        $result[] = '<script src="'. $item .'"></script>';
                    }
                }

                if($is_compress && $compress_last_modif){
                    $result = array(
                        '<script src="  /admin/compress/' . $name . '.js"></script>'
                    );
                }
            }

            echo implode('', $result);
        }
    }
}
