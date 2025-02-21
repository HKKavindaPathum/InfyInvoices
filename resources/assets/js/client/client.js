listenClick(".client-delete-btn", function (event) {
    let recordId = $(event.currentTarget).attr("data-id");

    var callFunction =
        arguments.length > 3 && arguments3 !== undefined ? arguments3 : null;
    header = Lang.get("js.client");
    swal({
        title: Lang.get("js.delete") + " !",
        text: Lang.get("js.are_you_sure_delete") + ' "' + header + '" ?',
        buttons: [Lang.get("js.no_cancel"), Lang.get("js.yes_delete")],
        icon: sweetAlertIcon,
    }).then(function (willDelete) {
        if (willDelete) {
            $.ajax({
                url: route("clients.destroy", recordId),
                type: "DELETE",
                dataType: "json",
                data: { clientWithInvoices: true },
                success: function (obj) {
                    if (obj.success) {
                        Livewire.dispatch("refreshDatatable");
                        Livewire.dispatch("resetPageTable");
                    }
                    swal({
                        icon: "success",
                        title: Lang.get("js.deleted"),
                        text: header + " " + Lang.get("js.has_been_deleted"),
                        timer: 2000,
                        button: Lang.get("js.ok"),
                    });
                    if (callFunction) {
                        eval(callFunction);
                    }
                },
                error: function (data) {
                    swal({
                        title: Lang.get("js.delete") + " !",
                        text: Lang.get(
                            "js.are_sure_want_to_delete_this_client_related_all_invoices"
                        ),
                        buttons: [
                            Lang.get("js.no_cancel"),
                            Lang.get("js.yes_delete"),
                        ],
                        icon: sweetAlertIcon,
                    }).then(function (willDelete) {
                        if (willDelete) {
                            $.ajax({
                                url: route("clients.destroy", recordId),
                                type: "DELETE",
                                dataType: "json",
                                success: function (obj) {
                                    if (obj.success) {
                                        Livewire.dispatch("refreshDatatable");
                                        Livewire.dispatch("resetPageTable");
                                    }
                                    swal({
                                        icon: "success",
                                        title: Lang.get("js.deleted"),
                                        text:
                                            header +
                                            " " +
                                            Lang.get("js.has_been_deleted"),
                                        timer: 2000,
                                        button: Lang.get("js.ok"),
                                    });
                                    if (callFunction) {
                                        eval(callFunction);
                                    }
                                },
                                error: function (data) { },
                            });
                        }
                    });
                },
            });
        }
    });
});

listenClick("#addCityBtn", function () {
    $(".city-text-input").removeClass("d-none");
    $(".city-select-input").addClass("d-none");
});

$(document).on("click", function (event) {
    if (!$(event.target).closest('.city-text-input, .city-select-input, #addCityBtn, .image-picker').length &&
        !$(event.target).is('input, textarea, select, input[type="file"], label, .picker-edit')) {
        $(".city-text-input").addClass("d-none");
        $(".city-select-input").removeClass("d-none");
    }
});
