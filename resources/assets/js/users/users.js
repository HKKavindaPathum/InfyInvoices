listenClick('.user-delete-btn', function (event) {
    let recordId = $(event.currentTarget).data('id');
    deleteItem(route('users.destroy', recordId),
        Lang.get('js.admin'));
})
