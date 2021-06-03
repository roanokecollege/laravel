@extends("admin.template")

@section("heading")
  Purchase Receipt
@endsection

@section("stylesheets")
  @parent
  <link rel="stylesheet" type="text/css" href="{{ asset("css/dark_table.css") }}" />
@endsection


@section("content")

  <h2>Thank You!</h2>
  <p>
    You can view your full transaction receipt <a href="{{ $purchase->receipt_url }}">via Stripe</a>.
    Your purchase details are as follows:
  </p>
  <table class="table table-condensed dark_table">
    <thead>
      <tr>
        <th>Item</th>
        <th>Quantity</th>
        <th>Price Per</th>
        <th></th>
      </tr>
    </thead>
    <tbody>
      @foreach($purchase->items as $purchase_item)
        <tr>
          <td>{{ $purchase_item->price->item->product_name }} &ndash; {{ $purchase_item->price->name }}</td>
          <td>{{ $purchase_item->quantity }}</td>
          <td>${{ number_format($purchase_item->price->price, 2, ".", ",") }}</td>
          <td>${{ number_format($purchase_item->price->price * $purchase_item->quantity, 2, ".", ",") }}</td>
        </tr>
      @endforeach
    </tbody>
    <tfoot>
      <tr>
        <th colspan=3>Total</th>
        <td>${{ number_format($purchase->charge_amount, 2, ".", ",") }}</td>
      </tr>
    </tfoot>
  </table>

@endsection
