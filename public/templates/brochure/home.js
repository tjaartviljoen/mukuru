var template_home = function (static)
{
	$.extend(this, App.Template.emptyTemplate);
	this.static = static;
	this.init = function () {};
	this.construct = function () {};
	this.destruct = function () {};
};
