<?

class StructureInstanceAdminController extends BaseAdminController{

    function __construct($query)
    {
        $self_instance = Objects::get($query['instance']);

        $this->add('crumb', array(
            array(
                'name' => 'Структура',
                'link' => '/admin/structure/'
            ),
            array(
                'name' => $self_instance['instance_name'],
                'link' => '/admin/structure/'.$query['instance'].'/'
            ),
        ));


        $db = DB::init($self_instance['instance_name'], $self_instance);
        $self_instance['collections'] = $db->show_collection($self_instance['name']);


        $this->add('objects', Objects::get());
        $this->add('structure_url', Request::segment(2));
        $this->add('object_url', Request::segment(3));
        $this->add('self_instance', $self_instance);

        $this->render('blocks/l-structure/l-structure.twig');
    }

}