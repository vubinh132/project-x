/**
 * Initial when document ready
 */
$(document).ready(function () {
    // $.datepicker.regional["vi-VN"] ={
    //         closeText: "Đóng",
    //         prevText: "Trước",
    //         nextText: "Sau",
    //         currentText: "Hôm nay",
    //         monthNames: ["Tháng một", "Tháng hai", "Tháng ba", "Tháng tư", "Tháng năm", "Tháng sáu", "Tháng bảy", "Tháng tám", "Tháng chín", "Tháng mười", "Tháng mười một", "Tháng mười hai"],
    //         monthNamesShort: ["Một", "Hai", "Ba", "Bốn", "Năm", "Sáu", "Bảy", "Tám", "Chín", "Mười", "Mười một", "Mười hai"],
    //         dayNames: ["Chủ nhật", "Thứ hai", "Thứ ba", "Thứ tư", "Thứ năm", "Thứ sáu", "Thứ bảy"],
    //         dayNamesShort: ["CN", "Hai", "Ba", "Tư", "Năm", "Sáu", "Bảy"],
    //         dayNamesMin: ["CN", "T2", "T3", "T4", "T5", "T6", "T7"],
    //         weekHeader: "Tuần",
    //         dateFormat: "dd/mm/yy",
    //         firstDay: 1,
    //         isRTL: false,
    //         showMonthAfterYear: false,
    //         yearSuffix: ""
    //     };
    // $.datepicker.setDefaults($.datepicker.regional["vi-VN"]);

    $('.datepicker').datepicker({
        autoclose: true,
        format: 'yyyy-mm-dd',
        maxViewMode: 2
    });

    $('.birthday-datepicker').datepicker({
        autoclose: true,
        endDate: '0d',
        format: 'yyyy-mm-dd',
        maxViewMode: 2
    });

    $('.datetimepicker').datetimepicker({
        useCurrent: false,
        format: 'YYYY-MM-DD HH:mm:ss',
        icons: {
            time: 'fa fa-clock-o',
            date: 'fa fa-calendar',
            up: 'fa fa-chevron-up',
            down: 'fa fa-chevron-down',
            previous: 'fa fa-chevron-left',
            next: 'fa fa-chevron-right',
            today: 'fa fa-screenshot',
            clear: 'fa fa-trash',
            close: 'fa fa-remove'
        }
    });

    $('input.check-related-field-on-change').change(function () {
        correctStatusOfrelatedField(this);
    });
    correctAllStatusOfRelatedField($('input.check-related-field-on-change:checked'));

    $('.summernote').summernote({
        height: 350,
        minHeight: null,
        maxHeight: null,
        focus: false
    });

    $('.summernote-short').summernote({
        height: 200,
        minHeight: null,
        maxHeight: null,
        focus: false
    });

    $('.simple-dropdown').multiselect({
        buttonClass: 'btn btn-default',
        buttonWidth: 'auto',
        buttonContainer: '<div class="btn-group" />',
        maxHeight: false
    });

    $('.form-control').unbind('keyup change input paste').bind('keyup change input paste', function (e) {
        var $this = $(this);
        var val = $this.val();
        var valLength = val.length;
        var maxCount = $this.attr('maxlength');
        if (valLength > maxCount) {
            $this.val($this.val().substring(0, maxCount));
        }
    });
});

/**
 * Logout function
 */
function logout(event) {
    event.preventDefault();
    $('#logout-form').submit();
}

/**
 * Confirm form submit action
 */
function confirmSubmit(event, element, title, message) {
    event.preventDefault();
    bootbox.confirm({
        title: title,
        message: message,
        closeButton: false,
        buttons: {
            confirm: {
                label: 'Yes',
                className: 'btn-danger'
            },
            cancel: {
                label: 'No',
                className: 'btn-default'
            }
        },
        callback: function (result) {
            if (result) {
                $(element).parent('form').submit();
            }
        }
    })
}

/**
 * Correct status of related field
 * 1   : Remove required, add disables and set value = ''
 * != 1: Remove disabled, add required
 */
function correctStatusOfrelatedField(element) {
    var $related_field = $(element).closest('form').find('input[name="' + $(element).data('related-field') + '"]').first();
    if (!$related_field) return;
    $related_field.prop('disabled', element.value == '1');
    $related_field.prop('required', element.value != '1');
    if (element.value == '1') $related_field.val('');
}

function correctAllStatusOfRelatedField(element) {
    var nodes = $(element).get();
    for (var i in nodes) {
        correctStatusOfrelatedField(nodes[i]);
    }
}

/**
 * Common Multiselect
 */
function addMultiselect(element, objectText) {
    $(element).multiselect({
        buttonClass: 'btn btn-default',
        buttonWidth: 'auto',
        buttonContainer: '<div class="btn-group" />',
        maxHeight: false,
        buttonText: function (options, select) {
            if (options.length === 0) {
                return 'Select ' + objectText + ' ...';
            }
            else if (options.length > 1) {
                return 'Selected (' + options.length + ') ' + objectText;
            }
            else {
                var labels = [];
                options.each(function () {
                    if ($(this).attr('label') !== undefined) {
                        labels.push($(this).attr('label'));
                    }
                    else {
                        labels.push($(this).html());
                    }
                });
                return labels.join(', ') + '';
            }
        }
    });
}

/**
 * Check file size limit
 */
function uploadFileWithLimit(element, totalSize) {
    if (element) {
        if (totalSize) {
            var files = element.files;
            if (files && files.length > 0) {
                var fileSize = files[0].size / 1024 / 1024;
                if (fileSize > totalSize) {
                    bootbox.alert('Dung lượng tập tin bạn chọn quá lớn! Dung lượng không được vướt quá ' + totalSize + 'MB.');
                    var form = element.form;
                    if (form) {
                        form.reset();
                    } else {
                        element.value = '';
                    }
                    return;
                }
            }
        }
    }

    var form = element.form;
    if (form) {
        form.submit();
    }
}

function uploadFile(element) {
    //$('#image').click();
    element.click();
}

function loadImageToImgTag(event) {
    var output = document.getElementById('output');
    output.src = URL.createObjectURL(event.target.files[0]);
}

function isNumberKey(evt) {
    var charCode = (evt.which) ? evt.which : event.keyCode;
    return !(charCode > 31 && (charCode < 48 || charCode > 57));
}


/**
 * ANGULAR JS
 */

var app = angular.module('myApp', ['oc.lazyLoad'], function ($interpolateProvider) {
    $interpolateProvider.startSymbol('{%');
    $interpolateProvider.endSymbol('%}');
});

app.controller("productIndexCtrl", function ($scope, $sce) {

    $scope.products = products;

    filter();

    $('#in, #out, #research').change(function () {
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
        $scope.filteredProducts = [];

        var keyWord = $('#keyWord').val().toLowerCase();

        //validate

        if (!keyWord.match(/^[a-zA-Z0-9_.-]*$/)) {
            keyWord = keyWord.substring(0, keyWord.length - 1);
            $('#keyWord').val(keyWord);
        }

        var filterArray = [];

        if ($('#in').is(':checked')) {
            filterArray.push(2);
        }
        if ($('#out').is(':checked')) {
            filterArray.push(3);
        }
        if ($('#research').is(':checked')) {
            filterArray.push(1);
        }

        for (var i = 0; i < $scope.products.length; i++) {
            if (filterArray.indexOf($scope.products[i].status) != -1 && (!keyWord || $scope.products[i].sku.toLowerCase().match(keyWord))) {
                $scope.filteredProducts.push($scope.products[i]);
            }
        }

    }

    $scope.trustAsHtml = function (html) {
        return $sce.trustAsHtml(html);
    }

});

app.controller("orderIndexCtrl", function ($scope, $sce) {

    $scope.orders = orders;

    filter();

    $('#processing, #done, #canceled').change(function () {
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

        if (!keyWord.match(/^[a-zA-Z0-9_.-]*$/)) {
            keyWord = keyWord.substring(0, keyWord.length - 1);
            $('#keyWord').val(keyWord);
        }

        var filterArray = [];

        if ($('#processing').is(':checked')) {
            filterArray.push(1);
        }
        if ($('#done').is(':checked')) {
            filterArray.push(2);
            filterArray.push(3);
        }
        if ($('#canceled').is(':checked')) {
            filterArray.push(4);
            filterArray.push(5);
        }

        for (var i = 0; i < $scope.orders.length; i++) {
            if (filterArray.indexOf($scope.orders[i].status) != -1 && (!keyWord || $scope.orders[i].code.toLowerCase().match(keyWord))) {
                $scope.filteredOrders.push($scope.orders[i]);
            }
        }

    }

    $scope.trustAsHtml = function (html) {
        return $sce.trustAsHtml(html);
    }

});

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
        var url = window.location.origin + '/admin/rom/change-return-status/' + id + '?status=' + status;
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
        var url = window.location.origin + '/admin/list/logs?category=' + id;
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

app.directive('onFinishRender', function ($timeout) {
    return {
        restrict: 'A',
        link: function (scope, element, attr) {
            if (scope.$last === true) {
                $timeout(function () {
                    scope.$emit('ngRepeatFinished');
                });
            }
        }
    }
});

app.directive('bsTooltip', function () {
    return {
        restrict: 'A',
        link: function (scope, element, attrs) {
            $(element).hover(function () {
                // on mouseenter
                $(element).tooltip('show');
            }, function () {
                // on mouseleave
                $(element).tooltip('hide');
            });
        }
    };
});