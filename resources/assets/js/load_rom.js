app.controller("romIndexCtrl", function ($scope, $sce) {

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

    $scope.changeReturnStatus = function (id, value) {

        var status = value ? 1 : 0;
        var url = window.location.origin + '/rom/change-return-status/' + id + '?status=' + status;
        $.ajax({
            url: url,
            type: 'GET',
            success: function (res) {
                filter();
                $scope.$apply();

                if (res.success) {
                    $.alert({
                        backgroundDismiss: true,
                        title: 'Success',
                        content: 'Update successfully',
                    });
                } else {
                    $.alert({
                        backgroundDismiss: true,
                        title: 'Fail',
                        content: 'Fail...',
                    });
                }
                $("#ui-button-text-lazada").text('UPDATE');
                $("#lazada").attr('disabled', false);
            }
        })
    }

    $scope.trustAsHtml = function (html) {
        return $sce.trustAsHtml(html);
    }

});