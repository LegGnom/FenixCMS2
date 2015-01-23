Twig.extendFunction("uniqid", function() {
	return App.unique();
});

Twig.extendFunction("source", function(path) {
	return App.get_templates(path);
});

Twig.extendFunction("template_from_string", function(template) {
	return App.compile_string(template);
});

Twig.extendFunction("include", function ( string ) {
	if(App.get_templates(string)){
		return App.render(string);
	}else{
		return string;
	}
});

