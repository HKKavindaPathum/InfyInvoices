document.addEventListener('DOMContentLoaded', createEditProduct);

function createEditProduct() {
    loadSelect2Dropdown()
}

function loadSelect2Dropdown() {
    let categorySelect2 = $('#categoryId');
    if (!categorySelect2.length) {
        return false;
    }

    if ($('#categoryId').hasClass("select2-hidden-accessible")) {
        $('.select2-container').remove();
    }

    $('#categoryId').select2({
        width: '100%',
    });
}

listenClick('.remove-image', function () {
    defaultAvatarImagePreview('#previewImage', 1);
});

listenKeyup('#code', function () {
    return $('#code').val(this.value.toUpperCase());
});
listenClick('#autoCode', function () {
    let code = Math.random().toString(36).toUpperCase().substr(2, 6);
    $('#code').val(code);
});
