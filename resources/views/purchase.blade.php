@extends("template")

@section("title")
  Roanoke College Business Office
@endsection

@section("heading")
  Checkout
@endsection

@section("javascript")
  <script src="https://js.stripe.com/v3/"></script>
  <script>
  function updateCheckout (input) {
    let price_id            = input.data("price-id");
    let quantity            = input.val();
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

    $(document).on("change", "input[name='quantity']", function () {
      updateCheckout($(this));
    });
  </script>
@endsection

@section("stylesheets")
  <style>
    .list-group-item {
      display: grid;
      grid-template-columns: repeat(4, 1fr);
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
        <item-price>{{ sprintf("$%0.2f", $price->price) }}</item-price>
        <item-qty><input type="number" class="form-control" name="quantity" min="0" value="1" data-price-id="{{ $price->price_id }}" /></item-qty>
        <div class="checkout_button">
          {{ $stripe_user->checkout([$price->price_id => 1])->button("Purchase") }}
        </div>
      </div>
    @endforeach
  </div>
@endsection
