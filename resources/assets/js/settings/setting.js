document.addEventListener("DOMContentLoaded", loadSettings);

function loadSettings() {
    initializeSelect2Dropdown();
    initializeDefaultCountryCode();
}

function initializeDefaultCountryCode() {
    let countryCode = $("#countryPhone");
    if (!countryCode.length) {
        return false;
    }

    let input = document.querySelector("#countryPhone");
    let errorMsg = document.querySelector("#error-msg");

    let errorMap = [
        Lang.get("js.invalid_number"),
        Lang.get("js.invalid_country_number"),
        Lang.get("js.too_short"),
        Lang.get("js.too_long"),
        Lang.get("js.invalid_number"),
    ];

    // initialise plugin
    let intl = window.intlTelInput(input, {
        initialCountry: "IN",
        separateDialCode: true,
        geoIpLookup: function (success, failure) {
            $.get("https://ipinfo.io", function () {}, "jsonp").always(
                function (resp) {
                    let countryCode = resp && resp.country ? resp.country : "";
                    success(countryCode);
                }
            );
        },
        utilsScript: "../../public/assets/js/inttel/js/utils.min.js",
    });

    let reset = function () {
        input.classList.remove("error");
        errorMsg.innerHTML = "";
    };

    input.addEventListener("blur", function () {
        reset();
        if (input.value.trim()) {
            if (intl.isValidNumber()) {
                validMsg.classList.remove("d-none");
            } else {
                input.classList.add("error");
                let errorCode = intl.getValidationError();
                errorMsg.innerHTML = errorMap[errorCode];
                errorMsg.classList.remove("d-none");
            }
        }
    });

    // on keyup / change flag: reset
    input.addEventListener("change", reset);
    input.addEventListener("keyup", reset);

    $(document).on(
        "blur keyup change countrychange",
        "#countryPhone",
        function () {
            let getCode = intl.selectedCountryData["dialCode"];
            $("#countryCode").val(getCode);
        }
    );

    let defaultCountryCode = $("#defaultCountryCode").val();

    intl.setNumber(defaultCountryCode);
    $("#countryCode").val(defaultCountryCode).trigger("change");
}

function initializeSelect2Dropdown() {
    let currencyType = $("#currencyType");
    if (!currencyType.length) {
        return false;
    }

    ["#currencyType", "#timeZone", "#dateFormat"].forEach(function (value) {
        if ($(value).hasClass("select2-hidden-accessible")) {
            $(".select2-container").remove();
        }
    });

    $("#currencyType, #timeZone, #dateFormat").select2({
        width: "100%",
    });
}

listenChange("input[type=radio][name=decimal_separator]", function () {
    if (this.value === ",") {
        $('input[type=radio][name=thousand_separator][value="."]').prop(
            "checked",
            true
        );
    } else {
        $('input[type=radio][name=thousand_separator][value=","]').prop(
            "checked",
            true
        );
    }
});

listenChange("input[type=radio][name=thousand_separator]", function () {
    if (this.value === ",") {
        $('input[type=radio][name=decimal_separator][value="."]').prop(
            "checked",
            true
        );
    } else {
        $('input[type=radio][name=decimal_separator][value=","]').prop(
            "checked",
            true
        );
    }
});

listenChange("#appLogo", function () {
    $("#validationErrorsBox").addClass("d-none");
    if (isValidLogo($(this), "#validationErrorsBox")) {
        displaySettingImage(this, "#previewImage");
    }
});

listenChange("#companyLogo", function () {
    $("#validationErrorsBox").addClass("d-none");
    if (isValidLogo($(this), "#validationErrorsBox")) {
        displaySettingImage(this, "#previewImage1");
    }
});

function isValidLogo(inputSelector, validationMessageSelector) {
    let ext = $(inputSelector).val().split(".").pop().toLowerCase();
    if ($.inArray(ext, ["jpg", "png", "jpeg"]) == -1) {
        $(inputSelector).val("");
        $(validationMessageSelector).removeClass("d-none");
        $(validationMessageSelector)
            .html("The image must be a file of type: jpg, jpeg, png.")
            .show();
        return false;
    }
    $(validationMessageSelector).hide();
    return true;
}

function displaySettingImage(input, selector) {
    let displayPreview = true;
    if (input.files && input.files[0]) {
        let reader = new FileReader();
        reader.onload = function (e) {
            let image = new Image();
            image.src = e.target.result;
            image.onload = function () {
                $(selector).attr("src", e.target.result);
                displayPreview = true;
            };
        };
        if (displayPreview) {
            reader.readAsDataURL(input.files[0]);
            $(selector).show();
        }
    }
}

listenSubmit("#createSetting", function (e) {
    let companyAddress = $("#companyAddress").val();
    let companyName = $("#company_name").val();
    let appName = $("#app_name").val();
    if (!$.trim(appName)) {
        displayErrorMessage("App Name is required");
        return false;
    }
    if (!$.trim(companyName)) {
        displayErrorMessage("Company Name is required");
        return false;
    }
    if (!$.trim(companyAddress)) {
        displayErrorMessage("Please enter company address");
        return false;
    }
});
