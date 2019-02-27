app.controller("logIndexCtrl", function ($scope, $http, $sce) {
    $scope.data = [];
    loadData();

    $(document).ready(function () {
        $('#category').on('change', function () {
            loadData();
            $scope.$apply();
        });
    });

    function loadData() {
        var id = $("#category").val();
        var url = window.location.origin + '/list/logs?category=' + id;
        $http({
            method: "GET",
            url: url
        }).then(function (response) {
            $scope.data = response.data.data;
        });
    }

    $scope.getTime = function (time) {
        var now = new Date();
        var time = new Date(time);
        var timePeriod = now - time;
        var seconds = Math.floor(timePeriod / 1000);
        var minute = 60;
        var hour = minute * 60;
        var day = hour * 24;

        if (seconds < minute) {
            return '<b>' + seconds + ' seconds ago</b>';
        }
        else if (seconds >= minute && seconds < hour) {
            var minutes = Math.floor(seconds / minute);
            return '<b>' + minutes + ' minutes ago</b>';
        } else if (seconds >= hour && seconds < day) {
            var hours = Math.floor(seconds / hour);
            return '<b>' + hours + ' hours ago</b>';
        } else {
            var days = Math.floor(seconds / day);
            return '<b>' + days + ' days ago</b>';
        }
    }
    $scope.trustAsHtml = function (html) {
        return $sce.trustAsHtml(html);
    }
});