
let dateRange = null;

Livewire.hook("element.init", ({ component }) => {
    if (component.name == "admin-payment-table") {
        initializeSelect2Payment();
        loadPaymentDateFilter("#paymentDateFilter");
    }
});

function initializeSelect2Payment() {
    if (!select2NotExists("#invoice_id")) {
        return false;
    }
    if ($("#invoice_id").hasClass("select2-hidden-accessible")) {
        $("#invoice_id .select2-container").remove();
    }

    $("#invoice_id").select2({
        dropdownParent: $("#paymentModal"),
    });
}

listenClick(".payment-delete-btn", function (event) {
    let id = $(event.currentTarget).attr("data-id");
    deleteItem(route("payments.destroy", id), Lang.get("js.payment"));
});

listenClick(".addPayment", function () {
    let currentDtFormat = currentDateFormat;
    $.ajax({
        url: route("get-current-date-format"),
        type: "get",
        success: function (data) {
            currentDtFormat = data;
            $("#payment_date").flatpickr({
                defaultDate: new Date(),
                dateFormat: data,
                maxDate: new Date(),
                locale: getUserLanguages,
            });
            $("#paymentModal").appendTo("body").modal("show");
        },
        error: function (result) {
            displayErrorMessage(result.responseJSON.message);
        },
    });

    setTimeout(function () {
        $("#invoice_id").select2({
            dropdownParent: $("#paymentModal"),
        });
    }, 200);
});

listenHiddenBsModal("#paymentModal", function () {
    $("#adminPaymentInvoiceId").val(null).trigger("change");
    resetModalForm("#paymentForm");
});

listenSubmit("#paymentForm", function (e) {
    e.preventDefault();

    if ($("#payment_note").val().trim().length == 0) {
        displayErrorMessage("Note field is Required");
        return false;
    }

    let btnSubmitEle = $(this).find("#btnPay");
    setAdminBtnLoader(btnSubmitEle);
    $.ajax({
        url: route("payments.store"),
        type: "POST",
        data: $(this).serialize(),
        success: function (result) {
            if (result.success) {
                $("#paymentModal").modal("hide");
                displaySuccessMessage(result.message);
                Livewire.dispatch("refreshDatatable");
                Livewire.dispatch("resetPageTable");
            }
        },
        error: function (result) {
            displayErrorMessage(result.responseJSON.message);
        },
        complete: function () {
            setAdminBtnLoader(btnSubmitEle);
        },
    });
});

listenChange(".invoice", function () {
    let invoiceId = $(this).val();
    if (isEmpty(invoiceId)) {
        $("#due_amount").val(0);
        $("#paid_amount").val(0);
        return false;
    }
    $.ajax({
        url: route("payments.get-invoiceAmount", invoiceId),
        type: "get",
        dataType: "json",
        success: function (result) {
            if (result.success) {
                $(".invoice-currency-code").text(result.data.currencyCode);
                $("#due_amount").val(number_format(result.data.totalDueAmount));
                $("#paid_amount").val(
                    number_format(result.data.totalPaidAmount)
                );
            }
        },
        error: function (result) {
            displayErrorMessage(result.responseJSON.message);
        },
    });
});

listenClick(".payment-edit-btn", function (event) {
    let paymentId = $(event.currentTarget).attr("data-id");
    paymentRenderData(paymentId);
});

function paymentRenderData(paymentId) {
    $.ajax({
        url: route("payments.edit", paymentId),
        type: "GET",
        beforeSend: function () {
            startLoader();
        },
        success: function (result) {
            if (result.success) {
                $("#edit_invoice_id").val(result.data.invoice.invoice_id);
                $("#edit_amount").val(result.data.amount);
                $("#edit_payment_date").flatpickr({
                    defaultDate: result.data.payment_date,
                    dateFormat: currentDateFormat,
                    maxDate: new Date(),
                    locale: getUserLanguages,
                });
                $(".edit-invoice-currency-code").text(result.data.currencyCode);
                $("#edit_payment_note").val(result.data.notes);
                $("#paymentId").val(result.data.id);
                $("#transactionId").val(result.data.payment_id);
                $("#invoice").val(result.data.invoice_id);
                $("#totalDue_amount").val(
                    number_format(
                        result.data.DueAmount.original.data.totalDueAmount
                    )
                );
                $("#totalPaid_amount").val(
                    number_format(
                        result.data.DueAmount.original.data.totalPaidAmount
                    )
                );
                $("#editPaymentModal").appendTo("body").modal("show");
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

listenSubmit("#editPaymentForm", function (event) {
    event.preventDefault();

    if ($("#edit_payment_note").val().trim().length == 0) {
        displayErrorMessage("Note field is Required");
        return false;
    }

    const paymentId = $("#paymentId").val();
    $.ajax({
        url: route("payments.update", { payment: paymentId }),
        type: "put",
        data: $(this).serialize(),
        beforeSend: function () {
            startLoader();
        },
        success: function (result) {
            if (result.success) {
                displaySuccessMessage(result.message);
                Livewire.dispatch("refreshDatatable");
                Livewire.dispatch("resetPageTable");
                $("#editPaymentModal").modal("hide");
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

listenChange(".transaction-approve", function () {
    let id = $(this).attr("data-id");
    let status = $(this).val();

    $.ajax({
        url: route("change-transaction-status", id),
        type: "GET",
        data: { id: id, status: status },
        success: function (result) {
            displaySuccessMessage(result.message);
            setTimeout(function () {
                window.location.href = route("transactions.index");
            }, 1500);
        },
        error: function (result) {
            displayErrorMessage(result.responseJSON.message);
        },
    });
});

function loadPaymentDateFilter(selector) {
    var start = moment().startOf("month");
    var end = moment().endOf("month");

    if (!$(selector).length) {
        return false;
    }

    dateRange = $(selector);

    function cb(start, end) {
        dateRange.val(
            start.format("MM/DD/YYYY") + " - " + end.format("MM/DD/YYYY")
        );
    }

    dateRange.daterangepicker(
        {
            startDate: start,
            endDate: end,
            showDropdowns: true,
            locale: {
                customRangeLabel: Lang.get("js.custom"),
                applyLabel: Lang.get("js.apply"),
                cancelLabel: Lang.get("js.cancel"),
                fromLabel: Lang.get("js.from"),
                toLabel: Lang.get("js.to"),
                monthNames: [
                    Lang.get("js.jan"),
                    Lang.get("js.feb"),
                    Lang.get("js.mar"),
                    Lang.get("js.apr"),
                    Lang.get("js.may"),
                    Lang.get("js.jun"),
                    Lang.get("js.jul"),
                    Lang.get("js.aug"),
                    Lang.get("js.sep"),
                    Lang.get("js.oct"),
                    Lang.get("js.nov"),
                    Lang.get("js.dec"),
                ],
                daysOfWeek: [
                    Lang.get("js.sun"),
                    Lang.get("js.mon"),
                    Lang.get("js.tue"),
                    Lang.get("js.wed"),
                    Lang.get("js.thu"),
                    Lang.get("js.fri"),
                    Lang.get("js.sat"),
                ],
            },
            ranges: {
                [Lang.get("js.today")]: [moment(), moment()],
                [Lang.get("js.yesterday")]: [
                    moment().subtract(1, "days"),
                    moment().subtract(1, "days"),
                ],
                [Lang.get("js.last_7_days")]: [
                    moment().subtract(6, "days"),
                    moment(),
                ],
                [Lang.get("js.last_30_days")]: [
                    moment().subtract(29, "days"),
                    moment(),
                ],
                [Lang.get("js.this_month")]: [
                    moment().startOf("month"),
                    moment().endOf("month"),
                ],
                [Lang.get("js.last_month")]: [
                    moment().subtract(1, "month").startOf("month"),
                    moment().subtract(1, "month").endOf("month"),
                ],
            },
        },
        cb
    );

    cb(start, end);

    dateRange.on("apply.daterangepicker", function (ev, picker) {
        isPickerApply = true;
        startDate = picker.startDate.format("YYYY-MM-DD");
        endDate = picker.endDate.format("YYYY-MM-DD");
        Livewire.dispatch("dateFilter", [startDate, endDate]);
    });
}


listenClick("#adminPaymentExcelExport", function (e) {
    e.preventDefault();

    $.ajax({
        url: route("admin.paymentsExcel"),
        type: "GET",
        data: { date: $("#paymentDateFilter").val() },
        xhrFields: {
            responseType: "blob",
        },
        success: function (response) {
            let blob = new Blob([response]);
            let link = document.createElement("a");
            link.href = window.URL.createObjectURL(blob);
            link.download = "Payment-Excel" + ".xlsx";
            link.click();
        },
        error: function (blob) {
            console.log(blob);
        },
    });
});

listenClick("#adminPaymentPdfExport", function (e) {
    e.preventDefault();

    $.ajax({
        url: route("admin.payments.pdf"),
        type: "GET",
        data: { date: $("#paymentDateFilter").val() },
        xhrFields: {
            responseType: "blob",
        },
        success: function (response) {
            let blob = new Blob([response]);
            let link = document.createElement("a");
            link.href = window.URL.createObjectURL(blob);
            link.download = "payments" + ".pdf";
            link.click();
        },
        error: function (blob) {
            console.log(blob);
        },
    });
});
