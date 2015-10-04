var template_orderplaced = function (static)
{
	$.extend(this, App.Template.emptyTemplate);
	this.static = static;
	this.haveData = true;
	this.meta = {
		General: {
			btnPurchase: $.extend(true, {}, App.DataElement.Button, {
				id: 'btnPurchase',
				label: 'Make another purchase',
				btnStyle: 'btn-lg btn-success',
				onClick: function()
				{
					window.location.hash = '/purchase';
				}
			})
		}
	};
	this.init = function () {};
	this.construct = $.proxy(function ()
	{
		//-- Populate order details.
		var order = _w.orderDetails;
        console.log('order', $.extend(true, {}, order));
        console.log('order', order);



		$('#orderDetails').append(
			'<tr><td><b>Amount owed:</b></td>'
			+ '<td>ZAR ' + (Math.floor(parseFloat(order.totalBilledAmount) * 100) / 100) + '</td></tr>'
		);
		$('#orderDetails').append(
			'<tr><td><b>Foreign amount purchased:</b></td>'
			+ '<td>' + order.currencyCode + ' ' + (Math.floor(parseFloat(order.foreignCurrencyAmount) * 100) / 100) + '</td></tr>'
		);

        if((Math.floor(parseFloat(order.totalDiscountPercentage) * 100) / 100) > 0.0)
        {
            $('#orderDetails').append(
                '<tr class="successText"><td ><b>You saved:</b></td>'
                + '<td>' + (Math.floor(parseFloat(order.totalDiscountPercentage) * 100) / 100) + '%</td></tr>'
            );
        }

	}, this);
	this.destruct = function () {};
};
