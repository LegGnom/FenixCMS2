<?

Route::group('get', array(
	'/admin/' => 'HomeAdminController',
	'/admin/structure/' => 'StructureAdminController',
	'/admin/structure/{instance}/' => 'StructureInstanceAdminController',
	'/admin/structure/{instance}/{object}/' => 'StructureObjectAdminController',

	'/admin/settings/' => 'SettingsAdminController',
));


Route::group('get', array(
	'/admin/action/connect-db/' => 'ConnectDBActionAdminController'
));