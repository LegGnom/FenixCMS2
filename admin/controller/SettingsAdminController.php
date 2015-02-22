<?

class SettingsAdminController extends BaseAdminController {

    function __construct()
    {
        $this->add('crumb', array(
            array(
                'name' => 'Настройки',
                'link' => '/admin/settings/'
            )
        ));

        $this->render('blocks/l-settings/l-settings.twig');
    }

}