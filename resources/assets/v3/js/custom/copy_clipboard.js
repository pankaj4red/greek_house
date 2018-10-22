var copyToClipboard = function (element) {
    var $temp = $("<input>");
    $("body").append($temp);
    $temp.val($(element).text()).select();
    document.execCommand("copy");
    $temp.remove();
};

$('body').on('click', '.copy-text', function () {
    copyToClipboard($(this).attr('data-copy-text'));
});

window.copyToClipboard = copyToClipboard;
