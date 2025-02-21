$(document).ready(function () {
    //Invoice Payments
    $("#payment_type").select2();
    $("#payment_mode").select2();
    $("#payment_type").select2({
        placeholder: "Select Payment Type",
        dropdownParent: $("#publicPaymentModal"),
    });
    $("#payment_mode").select2({
        placeholder: "Select Payment Method",
        dropdownParent: $("#publicPaymentModal"),
    });
    $(document).on("hidden.bs.modal", "#publicPaymentModal", function () {
        $(".amount").hide();
        $("#transaction").show();
        resetModalForm("#paymentForm", "#error");
        $("#payment_type").select2({
            placeholder: "Select Payment Type",
            dropdownParent: $("#publicPaymentModal"),
        });
        $("#payment_mode").select2({
            placeholder: "Select Payment Method",
            dropdownParent: $("#publicPaymentModal"),
        });
        $("#btnPay").removeClass("disabled");
    });
    $(document).on("change", "#payment_mode", function () {
        let value = $(this).val();
        if (value == 1) {
            $("#transaction").show();
        } else {
            $("#transaction").hide();
        }
    });

    $(document).on("click", ".payment", function () {
        let invoiceId = $(this).data("id");
        clientRenderData(invoiceId);
    });
    window.clientRenderData = function (id) {
        $.ajax({
            url: route("clients.payments.show", id),
            type: "GET",
            success: function (result) {
                if (result.success) {
                    $("#payable_amount").val(
                        result.data.total_amount.toFixed(2)
                    );
                    $("#public_invoice_id").val(result.data.id);
                    $("#publicPaymentModal").appendTo("body").modal("show");
                }
            },
            error: function (result) {
                displayErrorMessage(result.responseJSON.message);
            },
        });
    };

    $(".amount").hide();
    $(document).on("change", "#payment_type", function () {
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

    $(document).on("keyup", "#amount", function () {
        let payable_amount = parseFloat($("#payable_amount").val());
        let amount = parseFloat($("#amount").val());
        let paymentType = parseInt($("#payment_type").val());
        if (paymentType === 3 && payable_amount < amount) {
            $("#error-msg").text(
                Lang.get(
                    "js.amount_should_be_less_than_payable_amount"
                )
            );
            $("#btnPay").addClass("disabled");
        } else if (paymentType === 2 && payable_amount < amount) {
            $("#error-msg").text(
                Lang.get(
                    "js.amount_should_be_less_than_payable_amount"
                )
            );
            $("#btnPay").addClass("disabled");
        } else {
            $("#error-msg").text("");
            $("#btnPay").removeClass("disabled");
        }
    });

    $(document).submit("#paymentForm", function () {
        if ($("#error-msg").text() !== "") {
            return false;
        }
    });

    let paymentMode = 1;
    $(document).on("change", "#payment_mode", function () {
        paymentMode = $(this).val();
        parseInt(paymentMode);
    });

    $(document).on("submit", "#publicPaymentForm", function (e) {
        e.preventDefault();
        let btnSubmitEle = $(this).find("#btnPay");
        setAdminBtnLoader(btnSubmitEle);
        let payloadData = {
            amount: parseFloat($("#amount").val()),
            invoiceId: parseInt($("#public_invoice_id").val()),
        };
        if (paymentMode == 1) {
            $.ajax({
                url: route("clients.payments.store"),
                type: "POST",
                data: $(this).serialize(),
                success: function (result) {
                    if (result.success) {
                        $("#publicPaymentModal").modal("hide");
                        displaySuccessMessage(result.message);
                        location.reload();
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
                            $(this)
                                .html("Make Payment")
                                .removeClass("disabled");
                            manageAjaxErrors(result);
                        });
                })
                .catch((error) => {
                    displayErrorMessage(error.responseJSON.message);
                    setAdminBtnLoader(btnSubmitEle);
                    // $(this).html('Make Payment').removeClass('disabled');
                    // manageAjaxErrors(error.responseJSON.message);
                });
        } else if (paymentMode == 3) {
            $.ajax({
                type: "GET",
                url: route("paypal.init"),
                data: {
                    amount: payloadData.amount,
                    invoiceId: payloadData.invoiceId,
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
                        $("#publicPaymentModal").modal("hide");
                        let { id, amount, name, email, invoiceId, invoice_id } =
                            result.data;
                        options.description = invoice_id;
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
        }
    });

    let uri = window.location.toString();
    if (uri.indexOf("?") > 0) {
        let clean_uri = uri.substring(0, uri.indexOf("?"));
        window.history.replaceState({}, document.title, clean_uri);
    }
});
