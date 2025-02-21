"use strict";

$(document).ready(function () {
    $('[data-toggle="password"]').each(function () {
        let input = $(this);
        let eye_btn = $(this).parent().find(".input-icon");
        eye_btn.css("cursor", "pointer").addClass("input-password-hide");
        eye_btn.on("click", function () {
            if (eye_btn.hasClass("input-password-hide")) {
                eye_btn
                    .removeClass("input-password-hide")
                    .addClass("input-password-show");
                eye_btn
                    .find(".bi")
                    .removeClass("bi-eye-slash-fill")
                    .addClass("bi-eye-fill");
                input.attr("type", "text");
            } else {
                eye_btn
                    .removeClass("input-password-show")
                    .addClass("input-password-hide");
                eye_btn
                    .find(".bi")
                    .removeClass("bi-eye-fill")
                    .addClass("bi-eye-slash-fill");
                input.attr("type", "password");
            }
        });
    });
});

$(document).on("click", ".language-select", function () {
    let languageName = $(this).data("id");
    $.ajax({
        type: "get",
        url: changeLanguageUrl,
        data: {
            languageName: languageName,
        },
        success: function () {
            window.location.reload();
        },
    });
});
