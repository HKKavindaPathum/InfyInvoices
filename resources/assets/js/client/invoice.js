let dateRange = null;

Livewire.hook("element.init", ({ component }) => {
    if (
        component.name == "client-invoice-table" &&
        component.canonical.dateRange.length == 0
    ) {
        loadDateRangePicker("#dateRangePickerForClient");
        loadClientSelect2();
        if (!$("#invoices-tab").length) {
            return false;
        }
        let tabParameter = $("#clientActiveTab").val();
        $('.nav-item button[data-bs-target="#' + tabParameter + '"]').click();
    }
});

function loadDateRangePicker(selector) {
    if (!$(selector).length) {
        return false;
    }

    dateRange = $(selector);
    startDate = moment().subtract(100, "years");
    endDate = moment();
    setDatepickerValue(startDate, endDate);
    let lastMonth = moment().startOf("month").subtract(1, "days");

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

function loadClientSelect2() {
    if (!$("#clientInvoiceStatus").length) {
        return false;
    }
    $("#clientInvoiceStatus").select2();
}

listenClick("#resetClientInvoiceFilter", function () {
    $("#clientInvoiceStatus").val(7).trigger("change");
    hideDropdownManually($("#clientInvoiceFilterBtn"), $(".dropdown-menu"));
    loadDateRangePicker("#dateRangePickerForClient");
    let startDate = moment().subtract(100, "years");
    let endDate = moment();
    Livewire.dispatch("changeDateRangeFilter", [startDate, endDate]);
});
