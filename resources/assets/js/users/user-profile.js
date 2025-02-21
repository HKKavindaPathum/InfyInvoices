document.addEventListener("DOMContentLoaded", loadLanguageData);

function loadLanguageData() {
    if ($("#selectLanguage").length) {
        $("#selectLanguage").select2({
            width: "100%",
            dropdownParent: $("#changeLanguageModal"),
        });
    }
}

listenClick("#changePassword", function () {
    $(".pass-check-meter div.flex-grow-1").removeClass("active");
    $("#changePasswordModal").modal("show").appendTo("body");
});

listenClick("#passwordChangeBtn", function () {
    $.ajax({
        url: changePasswordUrl,
        type: "PUT",
        data: $("#changePasswordForm").serialize(),
        success: function (result) {
            $("#changePasswordModal").modal("hide");
            displaySuccessMessage(result.message);
        },
        error: function error(result) {
            displayErrorMessage(result.responseJSON.message);
        },
    });
});

listenHiddenBsModal(
    ["#changeLanguageModal", "#changePasswordModal"],
    function (e) {
        e.preventDefault();
        if ($("#changeLanguageForm").length) {
            $("#changeLanguageForm")[0].reset();
        }
        if ($("#changePasswordForm").length) {
            $("#changePasswordForm")[0].reset();
        }

        $("select.select2Selector").each(function (index, element) {
            var drpSelector = "#" + $(this).attr("id");
            $(drpSelector).val(getLoggedInUserLang);
            $(drpSelector).trigger("change");
        });
    }
);

listenClick("#languageChangeBtn", function () {
    $.ajax({
        url: route("change-language"),
        type: "POST",
        data: $("#changeLanguageForm").serialize(),
        success: function (result) {
            if (result.success) {
                $("#changeLanguageModal").modal("hide");
                displaySuccessMessage(
                    Lang.get("js.language_updated_successfully")
                );
                setTimeout(function () {
                    location.reload(true);
                    window.location.href = window.location.href;
                }, 2000);
            }
        },
        error: function error(result) {
            displayErrorMessage(result.responseJSON.message);
        },
    });
});

listenClick("#changeLanguage", function () {
    $("#changeLanguageModal").modal("show");
});

window.printErrorMessage = function (selector, errorResult) {
    $(selector).show().html("");
    $(selector).text(errorResult.responseJSON.message);
};

listenHiddenBsModal("#changePasswordModal", function () {
    resetModalForm("#changePasswordForm", "#validationErrorsBox");
});
