
$('body').on('change', '.gh-file-input', function() {
    var fileName = $(this).val().replace(/^.*\\/, '');
    $(this).next('.gh-file-label').html(fileName);
});