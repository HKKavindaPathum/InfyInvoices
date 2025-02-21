// delete client quote record
listenClick(".client-quote-delete-btn", function (event) {
    event.preventDefault();
    let quoteId = $(this).attr("data-id");
    deleteItem(route("client.quotes.destroy", quoteId), Lang.get("js.quote"));
});
