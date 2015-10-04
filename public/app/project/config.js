;
(function ()
{

	_App.Config = function ()
	{

		this.initialize();

	};

	_App.Config.prototype =
	{

		dataManglerCs: false,

		appKey: 'MUKURU',

		sectionLandingPage: {
			Brochure: '/',
			Portal: '/purchase',
			Admin: '/orders'
		},

		isDevEnvironment: (window.location.hostname == 'exchange.local'
		                   || window.location.hostname == 'exchange.local'),

		initialize: function () {}

	};

})();