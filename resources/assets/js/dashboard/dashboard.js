let start_date;
let end_date;
let isPickerApply = false;
let timeRange;

Livewire.hook("element.init", ({ component }) => {
    if (component.name == "dashboard") {
        initDashboardDatePicker();
    }
});

function initDashboardDatePicker() {
    timeRange = $("#time_range");

    if (!timeRange.length) {
        return;
    }

    start_date = moment().startOf("month");
    end_date = moment().endOf("month");
    setDbDatepickerValue(start_date, end_date);
    const last_month = moment().startOf("month").subtract(1, "days");

    timeRange.daterangepicker(
        {
            startDate: start_date,
            endDate: end_date,
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
                [Lang.get("js.today")]: [moment(), moment()],
                [Lang.get("js.this_week")]: [
                    moment().startOf("week"),
                    moment().endOf("week"),
                ],
                [Lang.get("js.last_week")]: [
                    moment().startOf("week").subtract(7, "days"),
                    moment().startOf("week").subtract(1, "days"),
                ],
                [Lang.get("js.this_month")]: [start_date, end_date],
                [Lang.get("js.last_month")]: [
                    last_month.clone().startOf("month"),
                    last_month.clone().endOf("month"),
                ],
            },
        },
        setDbDatepickerValue
    );

    if (currentRouteName == "admin.dashboard") {
        loadPaymentViewStatus();
        loadYearlyIncomeChat(
            start_date.format("YYYY-MM-D"),
            end_date.format("YYYY-MM-D")
        );
        loadInvoiceViewStatus();
    }

    timeRange.on("apply.daterangepicker", function (ev, picker) {
        isPickerApply = true;
        start_date = picker.startDate.format("YYYY-MM-D");
        end_date = picker.endDate.format("YYYY-MM-D");
        loadYearlyIncomeChat(start_date, end_date);
    });
}

function setDbDatepickerValue(start_date, end_date) {
    timeRange.val(
        start_date.format("DD/MM/YYYY") + " - " + end_date.format("DD/MM/YYYY")
    );
}

function loadPaymentViewStatus() {
    $.ajax({
        type: "GET",
        url: route("payment-overview"),
        cache: false,
    }).done(preparePaymentViewStatusChart);
}

function loadYearlyIncomeChat(startDate, endDate) {
    $.ajax({
        type: "GET",
        url: route("yearly-income-chart"),
        dataType: "json",
        data: {
            start_date: startDate,
            end_date: endDate,
        },
        cache: false,
    }).done(prepareYearlyIncomeViewChart);
}

function loadInvoiceViewStatus() {
    $.ajax({
        type: "GET",
        url: route("invoices-overview"),
        cache: false,
    }).done(prepareInvoiceViewStatusChart);
}

function preparePaymentViewStatusChart(result) {
    $("#payment-overview-container").html("");
    let data = result.data;
    if (data.total_records === 0) {
        $("#payment-overview-container").empty();
        $("#payment-overview-container").append(
            '<div align="center" class="no-record">' +
                Lang.get("js.no_record_found") +
                "</div>"
        );
        return true;
    } else {
        $("#payment-overview-container").html("");
        $("#payment-overview-container").append(
            '<canvas id="payment_overview"></canvas>'
        );
    }
    let ctx = document.getElementById("payment_overview").getContext("2d");
    let pieChartData = {
        labels: data.labels,
        datasets: [
            {
                data: data.dataPoints,
                backgroundColor: ["#47c363", "#fc544b"],
            },
        ],
    };

    window.myBar = new Chart(ctx, {
        type: "doughnut",
        data: pieChartData,
        options: {
            legend: {
                display: true,
                position: "bottom",
                boxWidth: 9,
            },
            plugins: {
                tooltip: {
                    callbacks: {
                        label: function (context) {
                            return currencyAmount(context.formattedValue);
                        },
                    },
                },
            },
        },
    });
}

function prepareInvoiceViewStatusChart(result) {
    $("#invoice-overview-container").html("");
    let data = result.data;
    if (data.total_paid_invoices === 0 && data.total_unpaid_invoices === 0) {
        $("#invoice-overview-container").empty();
        $("#invoice-overview-container").append(
            '<div align="center" class="no-record">' +
                Lang.get("js.no_record_found") +
                "</div>"
        );
        return true;
    } else {
        $("#invoice-overview-container").html("");
        $("#invoice-overview-container").append(
            '<canvas id="invoice_overview"></canvas>'
        );
    }
    let ctx = document.getElementById("invoice_overview").getContext("2d");
    let pieChartData = {
        labels: data.labels,
        datasets: [
            {
                data: data.dataPoints,
                backgroundColor: ["#1100ff", "#ff0000"],
            },
        ],
    };

    window.myBar = new Chart(ctx, {
        type: "doughnut",
        data: pieChartData,
        options: {
            legend: {
                display: true,
                position: "bottom",
                boxWidth: 9,
            },
            plugins: {
                tooltip: {
                    callbacks: {
                        label: function (context) {
                            return " " + context.formattedValue;
                        },
                    },
                },
            },
        },
    });
}

function prepareYearlyIncomeViewChart(result) {
    $("#yearly_income_overview-container").html("");
    let data = result.data;
    if (data.total_records === 0) {
        $("#yearly_income_overview-container").empty();
        $("#yearly_income_overview-container").append(
            '<div align="center" class="no-record">' +
                Lang.get("js.no_record_found") +
                "</div>"
        );
        return true;
    } else {
        $("#yearly_income_overview-container").html("");
        $("#yearly_income_overview-container").append(
            '<canvas id="yearly_income_chart_canvas" height="200"></canvas>'
        );
    }
    let ctx = document
        .getElementById("yearly_income_chart_canvas")
        .getContext("2d");
    ctx.canvas.style.height = "500px";

    let myChart = new Chart(ctx, {
        type: "line",
        data: {
            labels: data.labels,
            datasets: [
                {
                    label: data.month, // Name the series
                    data: data.yearly_income, // Specify the data values array
                    fill: false,
                    borderColor: "#2196f3", // Add custom color border (Line)
                    backgroundColor: "#2196f3", // Add custom color background (Points and Fill)
                    borderWidth: 2, // Specify bar border width
                },
            ],
        },
        options: {
            elements: {
                line: {
                    tension: 0.5,
                },
            },
            interaction: {
                mode: "index",
                intersect: false,
            },
            plugins: {
                legend: {
                    display: false,
                    position: "top",
                },
                tooltip: {
                    callbacks: {
                        label: function (context) {
                            return currencyAmount(context.formattedValue);
                        },
                    },
                },
            },
            scales: {
                y: {
                    beginAtZero: true,
                    grid: {
                        display: false,
                    },
                    ticks: {
                        min: 0,
                        // stepSize: 500,
                        callback: function (label) {
                            return currencyAmount(label);
                        },
                    },
                },
                x: {
                    beginAtZero: true,
                    grid: {
                        display: false,
                    },
                },
            },
        },
    });
}
