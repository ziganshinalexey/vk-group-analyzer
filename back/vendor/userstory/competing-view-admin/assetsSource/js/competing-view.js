(function($) {
    var _users = [],
        _currentUsersIds = [],
        _viewDelay = null,
        _viewUrl = '/v1/competingView/';

    var _CompentingView = {
        $container: null,
        once: false,
        urls: [],
        sendTimeout: null,
        sendInterval: null,
        notty: null,
        $nottyElement: null,
        promise: $.when(),
        needUpdate: false,
        nottyUpdateOpts: function() {
            return {
                type: 'warning',
                closable: false,
                fadeOut: {
                    enabled: false
                },
                message: {
                    html: this.html()
                }
            };
        },
        prepareData: function(user) {
            return {
                fullName: user.firstName + ' ' + user.secondName + ' ' + user.lastName
            };
        },
        addToData: function(key, user) {
            _users.push(this.prepareData(user));
            _currentUsersIds.push(parseInt(key, 10));
        },
        onThen: function(data) {
            if ($.isArray(data)) {
                return false;
            }

            var newUsersIds = [];

            $.each(data, function(key, user) {
                newUsersIds.push(parseInt(user.profileId, 10));
            });

            $.each(data, function(key, user) {
                if(-1 === $.inArray(parseInt(user.profileId, 10), _currentUsersIds)) {
                    this.addToData(user.profileId, user);
                    this.needUpdate = true;
                }
            }.bind(this));

            var isSomeCurrentIds = 0 === $(newUsersIds).not(_currentUsersIds).length,
                isSomeNewIds = 0 === $(_currentUsersIds).not(newUsersIds).length,
                isEqualLength = _currentUsersIds.length === newUsersIds.length;

            if (!(isSomeCurrentIds && isSomeNewIds && isEqualLength)) {
                this.needUpdate = true;
                _currentUsersIds = newUsersIds;
                _users = [];
                $.each(data, function(key, user) {
                    _users.push(this.prepareData(user));
                }.bind(this));
            }
        },
        html: function() {
            var htmlArr = [
                '<span class="glyphicon glyphicon-eye-open"></span>',
                '<div class="notty-body">'
            ];
            $.each(_users, function(key, user) {
                htmlArr.push(user.fullName + '<br>');
            });
            htmlArr.push('</div>');

            return htmlArr.join('');
        },
        reBuildData: function() {
            $.each(_users, function(key, user) {
                if(user.hasOwnProperty('last')) {
                    delete user.last;
                }
                if (1 + key === _users.length) {
                    user['last'] = true;
                }
            }.bind(this));
        },
        update: function() {
            this.$nottyElement = this.$container.find('.bottom-right');
            this.notty = this.$nottyElement.notify(this.nottyUpdateOpts());
            this.notty.show();
            if(1 < this.notty.$element.children().length) {
                this.notty.$element.children().eq(0).remove();
            }
        },
        generateContainer: function() {
            if (!this.once) {
                $('body').append([
                    '<div class="competing-view-widget">',
                    '<div class="notifications bottom-right"></div>',
                    '</div>'
                ].join(''));
                this.once = true;
                this.$container = $('.competing-view-widget');
            }
        },
        send: function() {
            $.each(this.urls, function(index, url) {
                this.promise = this.promise.then(function() {
                    return $.ajax(url, {
                        'X-HTTP-Method-Override': 'GET',
                        method: 'POST'
                    });
                }).then(this.onThen.bind(this));
            }.bind(this));
            this.promise.then(function() {
                if(this.needUpdate) {
                    this.reBuildData();
                    this.update();
                    this.needUpdate = false;
                }
            }.bind(this));
        },
        FIRST_REQUIEST_DELAY: 150,
        init: function() {
            this.generateContainer();
            clearInterval(this.sendInterval);
            clearTimeout(this.sendTimeout);
            this.sendTimeout = setTimeout(this.send.bind(this), this.FIRST_REQUIEST_DELAY);
            this.sendInterval = setInterval(this.send.bind(this), _viewDelay);
        }
    };

    return {
        addView: function(view) {
            $.ajax(_viewUrl + view.entity, {
                headers: {
                    'X-HTTP-Method-Override': 'CREATE',
                    method: 'POST'
                }
            }).done(function(data) {
                _viewDelay = parseInt(data.data.viewDelay, 10);
            });
            var url = _viewUrl + view.entity + '/' + view.id;
            _CompentingView.urls.push(url);
            _CompentingView.init();
        },
        setParams: function(params) {
            _viewUrl = params.viewUrl;
        }
    };
})(jQuery);
