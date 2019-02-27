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