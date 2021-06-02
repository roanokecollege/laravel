@extends("admin.template")

@section("title")
  Roanoke College Business Office
@endsection

@section("heading")
  Shopping Items
@endsection

@section("javascript")
  @parent
  <script>
    setupShoppingCart("{{ csrf_token() }}", "{{ action("CashierController@addToCart") }}", "{{ action("CashierController@removeFromCart") }}", "{{ action("CashierController@clearCart") }}");
  </script>
@endsection

@section("content")
  <h2>Purchasable Items</h2>
  <div class="list-group" style="margin-top: 50px;">
    @forelse($items as $item)
      <a href="{{ action("CashierController@showItemCheckout", $item) }}" class="list-group-item">
        <h3>{{ $item->product_name }}</h3>
      </a>
    @empty
      <p>
        There are no items to show here.  Create an item first!
      </p>
    @endforelse
  </div>

  @include("partials.shopping_cart")
@endsection
