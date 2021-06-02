<div id="cart" @if(!$cart_items->isEmpty())style="display: block;"@endif>
  <h4>Cart <span class="far fa-shopping-cart"></span></h4>
  <a class="close" data-dismiss="#cart">x</a>
  <div class="alert alert-warning light cart-warning">
      <div>
          <span class="fas fa-fw fa-2x fa-exclamation-triangle" aria-hidden="true"></span>
      </div>
      <div>
          Discounts and shipping will be calculated in the next step.
      </div>
  </div>
  <div style="text-align: right">
      <button class="btn btn-danger" id="clear-cart">Empty Cart</button>
  </div>
  <div id="cart-items">
      @foreach ($cart_items as $index => $item)
        @include("partials.cart_item", ["item" => $item, "cart_index" => $index])
      @endforeach
  </div>
  <div class="form-group">
      <label for="subtotal">
          Subtotal
      </label>
      <div id="subtotal">${{ number_format($cart_items->reduce(function ($collector, $item) { return $collector + $item->price * $item->quantity; }, 0), 2, ".", ",") }}</div>
  </div>
  <div class="form-group" style="text-align: right">
    <form method="POST" action="{{ $stripe_checkout_route }}">
        @csrf

      <button type="submit" class="btn btn-success" @if($cart_items->count() <= 0)disabled @endif><span class="far fa-lg fa-cash-register"></span> Check Out</button>
    </form>
  </div>
</div>
