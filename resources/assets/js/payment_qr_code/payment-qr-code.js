listenClick(".addQrCode", function () {
    $("#addPaymentQrCodeForm")[0].reset();
    $("#paymentQrCodeInputImage").css(
        "background-image",
        'url("/assets/images/avatar.png")'
    );
    $("#addPaymentQrCodeModal").appendTo("body").modal("show");
});

listenSubmit("#addPaymentQrCodeForm", function (e) {
    e.preventDefault();
    if (isDoubleClicked($(this))) return;

    $.ajax({
        url: route("payment-qr-codes.store"),
        type: "POST",
        data: new FormData(this),
        contentType: false,
        processData: false,
        beforeSend: function () {
            startLoader();
        },
        success: function (result) {
            if (result.success) {
                $("#addPaymentQrCodeModal").modal("hide");
                displaySuccessMessage(result.message);
                Livewire.dispatch("refreshDatatable");
                Livewire.dispatch("resetPageTable");
            }
        },
        error: function (result) {
            displayErrorMessage(result.responseJSON.message);
        },
        complete: function () {
            stopLoader();
        },
    });
});

listenClick(".qrcode-edit-btn", function (event) {
    let paymentQrCodeId = $(event.currentTarget).attr("data-id");
    taxRenderData(paymentQrCodeId);
});

function taxRenderData(paymentQrCodeId) {
    $.ajax({
        url: route("payment-qr-codes.edit", paymentQrCodeId),
        type: "GET",
        beforeSend: function () {
            startLoader();
        },
        success: function (result) {
            if (result.success) {
                $("#editQrCodeTitle").val(result.data.title);
                $(".qr_code_image").css(
                    "background-image",
                    "url('" + result.data.qr_image + "')"
                );
                $("#paymentQrCodeId").val(result.data.id);
                $("#editPaymentQrCodeModal").appendTo("body").modal("show");
            }
        },
        error: function (result) {
            displayErrorMessage(result.responseJSON.message);
        },
        complete: function () {
            stopLoader();
        },
    });
}

listenSubmit("#editPaymentQrCodeForm", function (event) {
    event.preventDefault();
    let paymentQrCodeId = $("#paymentQrCodeId").val();
    $.ajax({
        url: route("payment-update", paymentQrCodeId),
        type: "post",
        data: new FormData(this),
        contentType: false,
        processData: false,
        beforeSend: function () {
            startLoader();
        },

        success: function (result) {
            if (result.success) {
                displaySuccessMessage(result.message);
                $("#editPaymentQrCodeModal").modal("hide");
                Livewire.dispatch("refreshDatatable");
                Livewire.dispatch("resetPageTable");
            }
        },
        error: function (result) {
            displayErrorMessage(result.responseJSON.message);
        },
        complete: function () {
            stopLoader();
        },
    });
});

listenClick(".qrcode-delete-btn", function (event) {
    let paymentQrCode = $(event.currentTarget).attr("data-id");
    deleteItem(
        route("payment-qr-codes.destroy", paymentQrCode),
        Lang.get("js.payment_qr_code")
    );
});

listenChange(".qr-status", function (event) {
    let paymentQrCodeId = $(event.currentTarget).attr("data-id");
    updateStatus(paymentQrCodeId, this);
});

function updateStatus(paymentQrCodeId, currentCheckbox) {
    $.ajax({
        url: route("payment-qr-codes.default-status", paymentQrCodeId),
        method: "post",
        cache: false,
        success: function (result) {
            if (result.success) {
                displaySuccessMessage(result.message);
                Livewire.dispatch("refreshDatatable");
                Livewire.dispatch("resetPageTable");

                if ($(currentCheckbox).is(":checked")) {
                    $(".qr-status").prop("checked", false);
                    $(currentCheckbox).prop("checked", true);
                }
            }
        },
    });
}
