$(document).ready(function () {

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


});


    /**
     * Logout function
     */
    function logout(event) {
        event.preventDefault();
        $('#logout-form').submit();
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