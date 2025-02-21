listenClick(".product-delete-btn", function (event) {
    let productId = $(event.currentTarget).data("id");
    deleteItem(
        route("products.destroy", productId),
        Lang.get("js.product")
    );
});
