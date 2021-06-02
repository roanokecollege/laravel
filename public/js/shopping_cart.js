
function setupShoppingCart (csrf_token, add_to_cart_route, remove_from_cart_route, clear_cart_route) {

  $("#show-shopping-cart").on("click", function () {
    $("#cart").show();
  });
  $("#cart a.close").on("click", function () {
    $("#cart").hide();
  });

  function updateCartDisplay (response) {
    $("#cart_outer").html(response.data);
    $("#cart").show();
  }

  $(".add-to-cart").on("click", function (evt) {
    evt.preventDefault();
    $(".invalid").removeClass("invalid");
    let quantity_input = $(this).parent().prev().find("input[name='quantity']");
    let price_id       = quantity_input.data("price-id");
    let quantity       = Number.parseFloat(quantity_input.val());

    if (quantity == "" || quantity == "0" || !Number.isInteger(quantity)) {
      quantity_input.addClass("invalid");
      return false;
    }

    item = {};
    item['price_id'] = price_id;
    item['quantity'] = parseInt(quantity);

    $("form button[type='submit']").prop("disabled", true);

    $.ajax({
      method: "POST",
      url: add_to_cart_route,
      data: {
        '_token': csrf_token,
        'item': item,
      },
      success: updateCartDisplay
    });

  });
  $(document).on("click", ".remove-item", function (evt) {
    let $cart_item = $(this).parents(".cart-item");
    let index      = $cart_item.data("cart-index");

    $.ajax({
      method: "POST",
      url: remove_from_cart_route,
      data: {
        "_token": csrf_token,
        "index": index
      },
      success: updateCartDisplay,
      error: function (response) {
        console.log(response);
      }
    });
  });
  $(document).on("click", "#clear-cart", function (evt) {
    $.ajax({
      method: "POST",
      url: clear_cart_route,
      data: {
        "_token": csrf_token
      },
      success: updateCartDisplay
    });
  });
}
