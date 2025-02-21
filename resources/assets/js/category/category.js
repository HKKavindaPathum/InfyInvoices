listenClick(".addCategory", function (event) {
    event.preventDefault();
    $("#addCategoryModal").appendTo("body").modal("show");
});

listenClick(".category-edit-btn", function (event) {
    let categoryId = $(event.currentTarget).attr("data-id");
    renderData(categoryId);
});

listenSubmit("#addNewCategoryForm", function (event) {
    event.preventDefault();
    $.ajax({
        url: route("category.store"),
        type: "POST",
        data: $(this).serialize(),
        beforeSend: function () {
            startLoader();
        },
        success: function (result) {
            if (result.success) {
                $("#addCategoryModal").modal("hide");
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

listenHiddenBsModal("#addCategoryModal", function () {
    resetModalForm("#addNewCategoryForm", "#validationErrorsBox");
});

listenSubmit("#editCategoryForm", function (event) {
    event.preventDefault();
    const id = $("#editModalCategoryId").val();
    $.ajax({
        url: route("category.update", { category: id }),
        type: "put",
        data: $(this).serialize(),
        beforeSend: function () {
            startLoader();
        },
        success: function (result) {
            if (result.success) {
                displaySuccessMessage(result.message);
                $("#editCategoryModal").modal("hide");
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

listenClick(".category-delete-btn", function (event) {
    let categoryId = $(event.currentTarget).attr("data-id");
    deleteItem(
        route("category.destroy", categoryId),
        Lang.get("js.category")
    );
});

function renderData(id) {
    $.ajax({
        url: route("category.edit", id),
        type: "GET",
        beforeSend: function () {
            startLoader();
        },
        success: function (result) {
            if (result.success) {
                $("#editCategoryName").val(result.data.name);
                $("#editModalCategoryId").val(result.data.id);
                $("#editCategoryModal").appendTo("body").modal("show");
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
