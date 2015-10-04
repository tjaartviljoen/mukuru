var template_purchase = function (static)
{
	$.extend(this, App.Template.emptyTemplate);
	this.static = static;
	this.defaultForm = 'frmPurchase';
	this.haveData = true;
	this.forms =
	{
		frmPurchase: {
			namespace: 'Order',
			buttons: [],
			defaults: {
				labelSpan: '',
				inputSpan: ''
			},
			workspace: 'Order',
			choose: function ()
			{
				if (this.actionContext)
				{
					return this.actionContext;
				}
				return 'calculate';
			},
			actions: {
				calculate: {
					enable: function ()
					{
						return true;
					},
					taskAlias: $.proxy(function ()
					{
						return 'Authenticate';
					}, this),
					task: 'Calculate',
					dataHandler: false,
					dataTransform: $.proxy(function (data)
					{
						var packet = {
							currency: this.currencyId,
							amountForeign: data.Order.foreignAmount,
							amountOwedZar: data.Order.localAmount
						};
						if ('localAmount' == this.field)
						{
							packet.amountForeign = 0.0;
						}
						else
						{
							packet.amountOwedZar = 0.0;
						}
						return packet;
					}, this),
					successHandler: $.proxy(function (response) {
						//-- Display order data
						var data = response.Data;
						$('#localAmount').val(
							Math.floor(parseFloat(data.amountOwedZar) * 100) / 100
						);
						$('#foreignAmount').val(
							Math.floor(parseFloat(data.amountForeign) * 100) / 100
						);

						$('#btnPlaceOrder').prop('disabled', false);
					}, this),
					errorHandler: $.proxy(function (response) {
						_w.notify('Error', response.Message);
					}, this),
					button: $.extend(true, {}, App.DataElement.Button, {
						id: 'btnCalculate',
						noSubmit: true,
						label: 'Calculate',
						btnType: 'button',
						btnStyle: 'btn-primary btn-lg',
						onClick: $.proxy(function()
						{
							if (this.currencyId
							    && ((!isNaN($('#localAmount').val()) && 0.0 < parseFloat($('#localAmount').val()))
							        || (!isNaN($('#foreignAmount').val()) && 0.0 < parseFloat($('#foreignAmount').val()))))
							{
								//-- All good
								$('#frmPurchase').submit();
							}
							else
							{
								_w.notify('Notice', 'Please specify Local amount or Foreign amount.');
								return false;
							}
						}, this)
					})
				}
			},
			fields: {
				localAmount: $.extend(true, {}, App.DataElement.Amount, {
					label: 'Local amount',
					placeholder: 'Enter amount you wish to pay',
					labelStyle: 'input-lg',
					inputStyle: 'input-lg',
					themeElement: 'InputWithPrepend',
					inputPrepend: 'ZAR',
					value: '0.0',
					rules: {required: true}
				}),
				foreignAmount: $.extend(true, {}, App.DataElement.Amount, {
					label: 'Foreign amount',
					disabled: true,
					placeholder: 'Enter amount you wish to acquire',
					labelStyle: 'input-lg',
					inputStyle: 'input-lg',
					themeElement: 'InputWithPrepend',
					inputPrepend: '?',
					value: '0.0',
					rules: {required: true}
				})
			}
		}
	};
	this.meta = {
		General: {},
		Login: {}
	};
	this.init = function () {};
	this.construct = $.proxy(function ()
	{
		//-- Retrieve rates.
        $.ajax(
            {
                type: 'GET',
                url: '/api/currencies/v1',
                data: {token:App.Util.getCookie('token', '')},
                success: $.proxy(function (data)
                {
                    console.log('response', data)
                    for (var i in data)
                    {
                        var html = '<div class="col-md-3">';
                        html += '<div class="currency-block" data-id="' + data[i].id + '" data-code="' + data[i].code + '">';
                        html += '<br/><h2>' + data[i].code + '</h2>';
                        html += '<p><i>' + data[i].name + '</i></p><br/>';
                        html += '</div>';
                        html += '</div>';
                        $('#currencyContainer').append(html);
                    }
                    $('.currency-block').click($.proxy(function(evt)
                    {
                        $('.currency-block').removeClass('selected');
                        var id = $(evt.currentTarget).attr('data-id');
                        this.currencyId = id;
                        var code = $(evt.currentTarget).attr('data-code');
                        $(evt.currentTarget).addClass('selected');
                        $('#' + this.ti.tid + '_foreignAmount .input-group-addon').html(code);
                        $('#foreignAmount').prop('disabled', false);
                    }, this));

                }, this),
                error: $.proxy(function (response) {
                    _w.notify('Error', response.Message);
                }, this)
            });

		//-- Interface logic.
		$('#localAmount').focus($.proxy(function()
		{
			this.field = 'localAmount';
			$('#localAmount').val('');
			$('#foreignAmount').val('0.0');
		}, this));
		$('#localAmount').blur($.proxy(function()
		{
			if ('' == $('#localAmount').val())
			{
				$('#localAmount').val('0.0');
			}
		}, this));
		$('#foreignAmount').focus($.proxy(function()
		{
			this.field = 'foreignAmount';
			$('#foreignAmount').val('');
			$('#localAmount').val('0.0');
		}, this));
		$('#foreignAmount').blur($.proxy(function()
		{
			if ('' == $('#foreignAmount').val())
			{
				$('#foreignAmount').val('0.0');
			}
		}, this));
	}, this);
	this.destruct = function () {};
};
