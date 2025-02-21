let dateRange = null;

Livewire.hook("element.init", ({ component }) => {
    if (
        component.name == "transaction-table" ||
        component.name == "client-transaction-table"
    ) {
        initializeSelect2Transaction();
        loadDateRangePicker("#transactionDateRangePicker");
    }
});

function initializeSelect2Transaction() {
    if (!$(".payment-mode-filter").length) {
        return false;
    }
    $(".payment-mode-filter").select2();
    if (!$(".payment-status-filter").length) {
        return false;
    }
    $(".payment-status-filter").select2();
}

function loadDateRangePicker(selector) {
    if (!$(selector).length) {
        return false;
    }

    dateRange = $(selector);
    startDate = moment().subtract(100, "years");
    endDate = moment();
    setDatepickerValue(startDate, endDate);
    const lastMonth = moment().startOf("month").subtract(1, "days");

    dateRange.daterangepicker(
        {
            startDate: startDate,
            endDate: endDate,
            opens: "left",
            showDropdowns: true,
            autoUpdateInput: false,
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
                [Lang.get("js.all")]: [
                    moment().subtract(100, "years"),
                    moment(),
                ],
                [Lang.get("js.today")]: [moment(), moment()],
                [Lang.get("js.this_week")]: [
                    moment().startOf("week"),
                    moment().endOf("week"),
                ],
                [Lang.get("js.last_week")]: [
                    moment().startOf("week").subtract(7, "days"),
                    moment().startOf("week").subtract(1, "days"),
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
                    lastMonth.clone().startOf("month"),
                    lastMonth.clone().endOf("month"),
                ],
            },
        },
        setDatepickerValue
    );

    function setDatepickerValue(start, end) {
        dateRange.val(
            start.format("DD/MM/YYYY") + " - " + end.format("DD/MM/YYYY")
        );
    }

    dateRange.on("apply.daterangepicker", function (ev, picker) {
        startDate = picker.startDate.format("YYYY-MM-D");
        endDate = picker.endDate.format("YYYY-MM-D");
        Livewire.dispatch("changeDateRangeFilter", [startDate, endDate]);
    });
}

listenClick("#resetFilter", function () {
    $("#paymentModeFilter").select2({
        placeholder: "Select Payment Method",
        allowClear: false,
    });
    $("#paymentModeFilter").val(0).trigger("change");

    let startDate = moment().subtract(100, "years");
    let endDate = moment();
    Livewire.dispatch("changeDateRangeFilter", [startDate, endDate]);
    loadDateRangePicker("#transactionDateRangePicker");
});

listenClick(".show-payment-notes", function () {
    let paymentId = $(this).attr("data-id");
    paymentData(paymentId);
});

function paymentData(paymentId) {
    $.ajax({
        url: route("payment-notes.show", paymentId),
        type: "GET",
        success: function (result) {
            if (result.success) {
                let notes = isEmpty(result.data) ? "N/A" : result.data;
                $("#showClientNotesId").text(notes);
                $("#paymentNotesModal").appendTo("body").modal("show");
            }
        },
        error: function (result) {
            displayErrorMessage(result.responseJSON.message);
        },
    });
}

window.hideDropdownManually = function (dropdownBtnEle, dropdownEle) {
    dropdownBtnEle.removeClass("show");
    dropdownEle.removeClass("show");
};

listenChange(".payment-mode-filter", function () {
    Livewire.dispatch("changePaymentModeFilter", {
        paymentMode: $(this).val(),
    });
    Livewire.dispatch("changePaymentStatusFilter", {
        status: $(".payment-status-filter").val(),
    });
});

listenChange(".payment-status-filter", function () {
    Livewire.dispatch("changePaymentStatusFilter", { status: $(this).val() });
    Livewire.dispatch("changePaymentModeFilter", {
        paymentMode: $(".payment-mode-filter").val(),
    });
});

listen("click", "#transactionResetFilter", function () {
    $(".payment-mode-filter").val(0).trigger("change");
    $(".payment-status-filter").val(3).trigger("change");
    hideDropdownManually($("#transactionFilterBtn"), $(".dropdown-menu"));
});
