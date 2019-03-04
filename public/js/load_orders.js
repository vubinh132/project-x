app.controller("orderIndexCtrl", function ($scope, $sce) {

    $scope.orders = [];

    let callingThreads = 0;

    getOrdersFromServer();


    $('#processing, #done, #canceled').change(function () {
        getOrdersFromServer();
    });
    $(function () {
        $('#keyWord').keyup(function () {
            getOrdersFromServer();
        });
    });

    function getOrdersFromServer() {

        callingThreads++;
        if (callingThreads == 1) {
            $('#table').hide();
            $('#is-loading-text').show();
            $('#numOfOrders').html('...');
        }

        var keyWord = $('#keyWord').val().toLowerCase();

        //validate
        if (!keyWord.match(/^[a-zA-Z0-9_.-]*$/)) {
            keyWord = keyWord.substring(0, keyWord.length - 1);
            $('#keyWord').val(keyWord);
        }

        var filterArray = [];

        if ($('#processing').is(':checked')) {
            filterArray.push('N');
        }
        if ($('#done').is(':checked')) {
            filterArray.push('P');
            filterArray.push('I');
        }
        if ($('#canceled').is(':checked')) {
            filterArray.push('C');
            filterArray.push('RN');
            filterArray.push('L');
        }

        $.post(getOrdersUrl,
            {
                "_token": csrfToken,
                orderCode: keyWord,
                conditions: filterArray
            },
            (data, status) => {
                $scope.orders = data.data;
                callingThreads--;
                if (callingThreads == 0) {
                    $('#numOfOrders').html($scope.orders.length);
                    $scope.$apply();
                    $('#table').show();
                    $('#is-loading-text').hide();
                }
            });
    }

    $scope.trustAsHtml = function (html) {
        return $sce.trustAsHtml(html);
    }

});