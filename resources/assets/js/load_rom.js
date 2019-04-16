app.controller("romIndexCtrl", function ($scope, $sce) {

    const statuses = {RN: 'Returned - NOT', RR: 'Returned - RE'};

    $scope.orders = orders;

    filter();

    $('#received, #not-received').change(function () {
        filter();
        $scope.$apply();
    });
    $(function () {
        $('#keyWord').keyup(function () {
            filter();
            $scope.$apply();
        });
    });

    function filter() {
        $scope.filteredOrders = [];

        var keyWord = $('#keyWord').val().toLowerCase();

        //validate
        var filterArray = [];
        if ($('#not-received').is(':checked')) {
            filterArray.push(false);
        }
        if ($('#received').is(':checked')) {
            filterArray.push(true);

        }

        if (!keyWord.match(/^[a-zA-Z0-9_.-]*$/)) {
            keyWord = keyWord.substring(0, keyWord.length - 1);
            $('#keyWord').val(keyWord);
        }

        for (var i = 0; i < $scope.orders.length; i++) {
            if (filterArray.indexOf($scope.orders[i].returned) != -1 && (!keyWord || $scope.orders[i].code.toLowerCase().match(keyWord))) {
                $scope.filteredOrders.push($scope.orders[i]);
            }
        }
    }

    $scope.changeReturnStatus = function (x) {
        var status = x.returned ? 1 : 0;
        var url = window.location.origin + '/rom/change-return-status/' + x.id + '?status=' + status;
        $.ajax({
            url: url,
            type: 'GET',
            success: function (res) {
                if (res.success) {
                    x.status = res.data.status;
                    x.statusText = statuses[x.status];
                    filter();
                    $scope.$apply();
                    $.alert({
                        backgroundDismiss: true,
                        title: 'Success',
                        content: 'Update successfully ' + '(' + x.status + ')',
                    });
                } else {
                    x.returned = !x.returned;
                    $scope.$apply();
                    $.alert({
                        backgroundDismiss: true,
                        title: 'Fail',
                        content: res.message,
                    });
                }
            }, error: function (xhr, status, error) {
                x.returned = !x.returned;
                $scope.$apply();
                let errorMessage = xhr.status + ': ' + xhr.statusText
                $.alert({
                    backgroundDismiss: true,
                    title: 'Fail',
                    content: 'Error - ' + errorMessage,
                });
            }
        })
    }

    $scope.trustAsHtml = function (html) {
        return $sce.trustAsHtml(html);
    }

});