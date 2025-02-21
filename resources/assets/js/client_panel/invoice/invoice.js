document.addEventListener("DOMContentLoaded", loadCPInvoice);

function loadCPInvoice() {
    initializeSelect2Payment();

    $(".amount").hide();
    let paymentMode = 1;
    let uri = window.location.toString();
    if (uri.indexOf("?") > 0) {
        let clean_uri = uri.substring(0, uri.indexOf("?"));
        window.history.replaceState({}, document.title, clean_uri);
    }

    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
    });
}

listenChange("#client_payment_mode", function () {
    if ($(this).val() == 1) {
        $(".payment-attachment").removeClass("d-none");
    } else {
        $(".payment-attachment").addClass("d-none");
    }
});

function initializeSelect2Payment() {
    $("#client_payment_type").select2({
        placeholder: "Select Payment Type",
    });
    $("#client_payment_mode").select2({
        placeholder: "Select Payment Method",
    });
}

listenChange("#client_payment_mode", function () {
    let value = $(this).val();
    if (value == 1) {
        $("#transaction").show();
    } else {
        $("#transaction").hide();
    }
});

listenChange("#client_payment_type", function () {
    let value = $(this).val();
    let full_payment = $("#payable_amount").val();

    if (value == "2") {
        $(".amount").hide();
        $("#amount").val(full_payment);
        $("#amount").prop("readonly", true);
    } else if (value == "3") {
        $(".amount").show();
        $("#amount").val("");
        $("#amount").prop("readonly", false);
    } else {
        $(".amount").hide();
        $("#amount").prop("readonly", false);
    }
});

listenKeyup("#amount", function () {
    let payable_amount = parseFloat($("#payable_amount").val());
    let amount = parseFloat($("#amount").val());
    let paymentType = parseInt($("#client_payment_type").val());
    if (paymentType === 3 && payable_amount < amount) {
        $("#error-msg").text(
            Lang.get("js.amount_should_be_less_than_payable_amount")
        );
        $("#btnPay").addClass("disabled");
    } else if (paymentType === 2 && payable_amount < amount) {
        $("#error-msg").text(
            Lang.get("js.amount_should_be_less_than_payable_amount")
        );
        $("#btnPay").addClass("disabled");
    } else {
        $("#error-msg").text("");
        $("#btnPay").removeClass("disabled");
    }
});

listenChange("#client_payment_mode", function () {
    paymentMode = $(this).val();
    parseInt(paymentMode);
});

listenSubmit("#clientPaymentForm", function (e) {
    e.preventDefault();
    // if ($('#error-msg').text() !== '') {
    //     return false
    // }
    if ($("#amount").val() == 0) {
        displayErrorMessage("Amount should not be equal to zero");
        return false;
    }

    if ($("#payment_note").val().trim().length == 0) {
        displayErrorMessage("Note field is Required");
        return false;
    }

    let btnSubmitEle = $(this).find("#btnPay");
    setAdminBtnLoader(btnSubmitEle);
    let payloadData = {
        amount: parseFloat($("#amount").val()),
        invoiceId: parseInt($("#client_invoice_id").val()),
        transactionNotes: $("#payment_note").val(),
    };

    if (paymentMode == 1) {
        $.ajax({
            url: route("clients.payments.store"),
            type: "POST",
            data: new FormData(this),
            processData: false,
            contentType: false,
            success: function (result) {
                if (result.success) {
                    // displaySuccessMessage(result.message);
                    Livewire.dispatch("refreshDatatable");
                    Livewire.dispatch("resetPageTable");
                    window.location.href = result.data.redirectUrl;
                }
            },
            error: function (result) {
                displayErrorMessage(result.responseJSON.message);
            },
            complete: function () {
                setAdminBtnLoader(btnSubmitEle);
            },
        });
    } else if (paymentMode == 2) {
        $.post(invoiceStripePaymentUrl, payloadData)
            .done((result) => {
                let sessionId = result.data.sessionId;
                stripe
                    .redirectToCheckout({
                        sessionId: sessionId,
                    })
                    .then(function (result) {
                        $(this).html("Make Payment").removeClass("disabled");
                        manageAjaxErrors(result);
                    });
            })
            .catch((error) => {
                $(this).html("Make Payment").removeClass("disabled");
                manageAjaxErrors(error);
            });
    } else if (paymentMode == 3) {
        $.ajax({
            type: "GET",
            url: route("paypal.init"),
            data: {
                amount: payloadData.amount,
                invoiceId: payloadData.invoiceId,
                transactionNotes: payloadData.transactionNotes,
            },
            success: function (result) {
                if (result.status == "CREATED") {
                    let redirectTo = "";

                    $.each(result.links, function (key, val) {
                        if (val.rel == "approve") {
                            redirectTo = val.href;
                        }
                    });
                    location.href = redirectTo;
                } else {
                    location.href = result.url;
                }
            },
            error: function (result) {
                displayErrorMessage(result.responseJSON.message);
            },
            complete: function () {
                setAdminBtnLoader(btnSubmitEle);
            },
        });
    } else if (paymentMode == 5) {
        $.ajax({
            type: "GET",
            url: route("razorpay.init"),
            data: $(this).serialize(),
            success: function (result) {
                if (result.success) {
                    $("#clientPaymentModal").modal("hide");
                    let {
                        id,
                        amount,
                        name,
                        email,
                        invoiceId,
                        invoice_id,
                        description,
                    } = result.data;
                    options.description = description;
                    options.order_id = id;
                    options.amount = amount;
                    options.prefill.name = name;
                    options.prefill.email = email;
                    options.prefill.invoiceId = invoiceId;
                    let razorPay = new Razorpay(options);
                    razorPay.open();
                    razorPay.on("payment.failed");
                }
            },
            error: function (result) {
                displayErrorMessage(result.responseJSON.message);
            },
            complete: function () {
                setAdminBtnLoader(btnSubmitEle);
            },
        });
    } else if (paymentMode == 6) {
        window.location.replace(
            route("client.paystack.init", {
                invoiceId: payloadData.invoiceId,
                amount: payloadData.amount,
                note: payloadData.transactionNotes,
            })
        );
    }
});
