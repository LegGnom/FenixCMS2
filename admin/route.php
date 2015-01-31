<?

Route::group('get', array(
	'/admin/' => 'HomeAdminController',
	'/admin/structure/' => 'StructureAdminController'
));


Route::group('get', array(
	'/admin/action/connect-db/' => 'ConnectDBActionAdminController'
));