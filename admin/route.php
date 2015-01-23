<?

Route::group('get', array(
	'/admin/' => 'HomeAdminController',
	'/admin/structure/' => 'StructureAdminController'
));