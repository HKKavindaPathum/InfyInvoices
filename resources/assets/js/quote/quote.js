let dateRange = null;

Livewire.hook("element.init", ({ component }) => {
    if (
        (component.name == "quote-table" ||
            component.name == "client-quote-table") &&
        component.canonical.dateRange.length == 0
    ) {
        initializeSelect2Quote();
        loadDateRangePicker("#quoteDateRangePicker");
    }
});

function initializeSelect2Quote() {
    if (!$("#quoteStatus").length) {
        return false;
    }

    $("#quoteStatus").select2();
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

// delete quote record
listenClick(".quote-delete-btn", function (event) {
    event.preventDefault();
    let quoteId = $(this).attr("data-id");
    deleteItem(route("quotes.destroy", quoteId), Lang.get("js.quote"));
});

listenClick("#resetQuoteStatusFilter", function () {
    $("#quoteStatus").val(2).trigger("change");
    hideDropdownManually($("#quoteFilterBtn"), $(".dropdown-menu"));
    let startDate = moment().subtract(100, "years");
    let endDate = moment();
    Livewire.dispatch("changeDateRangeFilter", [startDate, endDate]);
    loadDateRangePicker("#quoteDateRangePicker");
});

listenClick(".convert-to-invoice", function (e) {
    e.preventDefault();
    let quoteId = $(this).data("id");
    $.ajax({
        url: route("quotes.convert-to-invoice"),
        type: "GET",
        data: { quoteId: quoteId },
        success: function (result) {
            if (result.success) {
                displaySuccessMessage(result.message);
                Livewire.dispatch("refreshDatatable");
                Livewire.dispatch("resetPageTable");
            }
        },
        error: function (result) {
            displayErrorMessage(result.responseJSON.message);
        },
    });
});

listenChange("#quoteStatus", function () {
    Livewire.dispatch("changeQuoteStatusFilter", { status: $(this).val() });
});
