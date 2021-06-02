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
    $(document).on("change", "item-qty input[type='number']", function (evt) {
      $(this).removeClass("invalid");
      let quantity = Number.parseFloat($(this).val());
      if (!Number.isInteger(quantity)) {
        $(this).addClass("invalid");
      }
    });
  </script>
@endsection

@section("stylesheets")
  @parent
  <style>
    item-name {
      font-weight: bold;
      font-size: 14pt;
    }
    item-price {
      font-size: 14pt;
    }
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
    @media(max-width: 1000px) {
      .list-group-item {
        grid-template-columns: 1fr 1fr;
        grid-gap: 20px;
      }
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
        <item-qty><input type="number" class="form-control" name="quantity" min="0" value="1" step="1" data-price-id="{{ $price->price_id }}" /></item-qty>
        <div class="checkout_button">
          <button type="button" class="btn btn-default btn-lg add-to-cart"><span class="far fa-cart-plus fa-lg"></span> Add to Cart</button>
        </div>
      </div>
    @endforeach
  </div>

  @include("partials.shopping_cart")
@endsection
