;
(function ()
{

	$(document).ready(function ()
	{
		window._c = {}; // Constructor workspace
		window._t = {}; // Template workspace
		window._r = {}; // Registry
		window.App = new _App();
        var token =  App.Util.getCookie('token', '');
		var hashLoc = window.location.hash.split("#");
		hashLoc = hashLoc[1]
			? hashLoc[1]
			: '/';
		if ('/' != hashLoc && null != hashLoc
		    && '/login' != hashLoc
		    && '/forgot-password' != hashLoc
		    && '/change-password' != hashLoc)
		{
			App.redirect = hashLoc;
		}

        $.ajax(
            {
                type: 'POST',
                url: '/api/users/v1/get-user-data',
                data: JSON.stringify({token:token}),
                success: $.proxy(function (response)
                {
                    if(response.status == "Success")
                    {
                        _w.onActiveAccount(response);
                    }
                    else
                    {
                        window.location.hash = "/";
                    }

                }, this),
                error: $.proxy(function (response) {
                    window.location.hash = "/";
                }, this)
            });
		_w.onLoad();
	});

})();