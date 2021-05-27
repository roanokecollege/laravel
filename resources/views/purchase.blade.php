@extends("admin.template")

@section("title")
  Roanoke College Business Office
@endsection

@section("heading")
  Checkout
@endsection

@section("javascript")
  @parent
  <script src="https://js.stripe.com/v3/"></script>

  <script>
    setupShoppingCart("{{ csrf_token() }}", "{{ action("CashierController@addToCart") }}", "{{ action("CashierController@removeFromCart") }}", "{{ action("CashierController@clearCart") }}");

    function updateCheckout (input) {
      let price_id            = input.data("price-id");
      let quantity            = input.val();
      $(".checkout_button").html($("<button class='btn btn-lg btn-danger'><span class='fas fa-spinner fa-pulse fa-lg'></span></button>"));
      $.ajax({
        url: "{{ action("CashierController@getUpdatedCheckoutButton", $stripe_item) }}",
        method: "POST",
        data: {
          "_token": "{{ csrf_token() }}",
          quantity: quantity,
          price_id: price_id
        },
        success: function (response) {
          input.parent().next().html(response);
        }
      });
    }

    // $(document).on("change", "input[name='quantity']", function () {
    //   updateCheckout($(this));
    // });
  </script>
@endsection

@section("stylesheets")
  @parent
  <style>
    .list-group-item {
      display: grid;
      grid-template-columns: repeat(4, 1fr);
    }
    .list-group-item * {
      align-self: center;
    }
    .list-group-item *:last-child {
      justify-self: end;
    }
  </style>
@endsection

@section("content")
  <h2>{{ $stripe_item->product_name }}</h2>

  <div class="list-group">
    @foreach($stripe_item->prices as $price)
      <div class="list-group-item">
        <item-name>{{ $price->name }}</item-name>
        <item-price>${{ number_format($price->price, 2, ".", ",") }}</item-price>
        <item-qty><input type="number" class="form-control" name="quantity" min="0" value="1" data-price-id="{{ $price->price_id }}" /></item-qty>
        <div class="checkout_button">
          <button type="button" class="btn btn-default btn-lg add-to-cart"><span class="far fa-cart-plus fa-lg"></span> Add to Cart</button>
        </div>
      </div>
    @endforeach
  </div>

  @include("partials.shopping_cart")
@endsection
