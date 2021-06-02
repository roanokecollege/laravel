<div class="cart-item" data-cart-index="{{ $item->price_id }}">
  <div>${{ number_format($item->price, 2, ".", ",") }} x {{ $item->quantity }}</div>
  <div class="item-name">{{ sprintf("%s - %s", $item->item->product_name, $item->name) }}</div>
  <div class="buttons"><button class="btn btn-link remove-item"><span class="far fa-times" aria-label="remove"></span></button></div>
</div>
