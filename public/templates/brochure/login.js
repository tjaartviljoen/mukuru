var template_login = function (static) {
    $.extend(this, App.Template.emptyTemplate);
    this.static = static;
    this.defaultForm = 'frmLogin';
    this.haveData = true;
    this.forms =
    {
        frmLogin: {
            namespace: 'Login',
            buttons: ['btnDoLogin'],
            defaults: {
                labelSpan: '',
                inputSpan: ''
            },
            workspace: 'Profile',
            choose: function () {
                return 'login';
            },
            actions: {
                login: {
                    enable: function () {
                        return true;
                    },
                    dataHandler: false,
                    customAction: function (data) {
                        $.ajax(
                            {
                                type: 'POST',
                                url: '/api/users/v1/authenticate',
                                data: JSON.stringify(data.Login),
                                success: $.proxy(function (response)
                                {
                                    if(response.status == "Success")
                                    {
                                        var username = $('#username').val();
                                        _w.onActiveAccount(response);
                                        App.Util.setCookie('UserName', username, 30);
                                        App.Util.setCookie('token', response.userData.token, 30);
                                        App.Controller.closeForm('frmHeader');
                                        _w.alert('Success', 'You have been logged into the system.', 'success', false);
                                    }
                                    else
                                    {
                                        _w.notify('Error', response.message);
                                        $('#btnDoLogin').prop('disabled', false);
                                    }

                                }, this),
                                error: $.proxy(function (response) {
                                    _w.notify('Error', response.Message);
                                    $('#btnDoLogin').prop('disabled', false);
                                }, this)
                            });
                    },
                    button: $.extend(true, {}, App.DataElement.Button, {
                        id: 'btnDoLogin',
                        label: 'Login',
                        btnType: 'submit',
                        btnStyle: 'btn-edit'
                    })
                }
            },
            fields: {
                username: $.extend(true, {}, App.DataElement.String, {
                    label: 'Username',
                    placeholder: 'Username',
                    inputType: 'username',
                    inputWrapperStyle: 'form-group',
                    themeElement: 'InputWithPrepend',
                    prepend: '<span class="glyphicon glyphicon-user"></span>',
                    value: App.Util.getCookie('UserName', ''),
                    rules: {required: true, maxlength: 250}
                }),
                password: $.extend(true, {}, App.DataElement.Password, {
                    label: 'Password',
                    placeholder: 'Password',
                    inputWrapperStyle: 'form-group',
                    themeElement: 'InputWithPrepend',
                    prepend: '<span class="glyphicon glyphicon-lock"></span>',
                    strength: false,
                    rules: {required: true, minlength: 3}
                })
            }
        }
    };
    this.meta = {
        General: {},
        Login: {}
    };
    this.init = function () {
    };
    this.construct = function () {
        if ('' == $('#username').val()) {
            $('#username').focus();
        }
        else {
            $('#password').focus();
        }
    };
    this.destruct = function () {
    };
};
