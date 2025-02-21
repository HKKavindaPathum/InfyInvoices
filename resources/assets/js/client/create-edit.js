document.addEventListener('DOMContentLoaded', createEditClient);

function createEditClient() {
    loadSelect2Dropdown()
    setEditCountryId()
}

function loadSelect2Dropdown() {
    let countyIdDropdownSelector = $('#countryID');
    if (!countyIdDropdownSelector.length) {
        return false;
    }

    if ($('#countryID').hasClass("select2-hidden-accessible")) {
        $('.select2-container').remove();
    }
    if ($('#stateID').hasClass("select2-hidden-accessible")) {
        $('.select2-container').remove();
    }

    $('#countryID, #stateID').select2({
        width: '100%',
    });
}

listenChange('#countryId', function (e) {
    let isEdit = 1;
    e.preventDefault();
    $.ajax({
        url: route('states-list'),
        type: 'get',
        dataType: 'json',
        data: { countryId: $(this).val() },
        success: function (data) {
            $('#stateId').empty();
            $('#cityId').empty();
            $('#stateId').empty();
            if (data.data.length != 0) {
                $.each(data.data, function (i, v) {
                    $('#stateId').
                        append($('<option></option>').attr('value', i).text(v));
                });
            } else {
                $('#stateId').
                    append(
                        $('<option value=""></option>').text('Select State'));
            }
            if (isEdit && $('#clientStateId').val()) {
                $('#stateId').val($('#clientStateId').val()).trigger('change');
                $('#clientStateId').val('');
            } else {
                $('#stateId').trigger('change');
            }
        },
    });
});

listenChange('#stateId', function (e) {
    let isEdit = 1;
    e.preventDefault();
    $.ajax({
        url: route('cities-list'),
        type: 'get',
        dataType: 'json',
        data: {
            stateId: $(this).val(),
            country: $('#countryId').val(),
        },
        success: function (data) {
            $('#cityId').empty();
            if (data.data.length != 0) {
                $.each(data.data, function (i, v) {
                    $('#cityId').
                        append($('<option></option>').
                            attr('value', i).
                            text(v));
                });
            } else {
                $('#cityId').
                    append(
                        $('<option value=""></option>').
                            text('Select City'));
            }
            if (isEdit && $('#clientCityId').val()) {
                $('#cityId').val($('#clientCityId').val()).trigger('change');
                $('#clientCityId').val('');
            } else  {
                $('#cityId').trigger('change');
            }
        },
    });
});

listenClick('.remove-image', function () {
    defaultAvatarImagePreview('#previewImage', 1);
});

listenSubmit('#clientForm, #editClientForm', function () {
    if ($('#error-msg').text() !== '') {
        $('#phoneNumber').focus();
        return false;
    }
});

function setEditCountryId() {
    if ($('#countryId').val()) {
        $('#countryId').val($('#countryId').val()).trigger('change');
    }
}
