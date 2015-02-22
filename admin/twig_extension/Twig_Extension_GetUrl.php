<?
class Twig_Extension_GetUrl extends Twig_Extension{

    public function getFunctions()
    {
        return array(
            new Twig_SimpleFunction(
                'get_url',
                'Twig_Extension_GetUrl::get_url'),
        );
    }
    public function getName()
    {
        return 'get_url';
    }
    public static function get_url($index = null)
    {
        if($index !== null){
            $path = Request::path_to_array();
            return isset($path[$index]) ? $path[$index] : false;
        }else{
            return Request::path();
        }
    }
}
