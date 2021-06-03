@extends("admin.template")

@section("title")
  Roanoke College Business Office
@endsection

@section("heading")
  Purchase History
@endsection

@section("javascript")
  @parent
@endsection

@section("content")
  <div class="list-group">
    @foreach($purchases as $purchase)
      <a href="{{ action("TransactionHistoryController@show", $purchase) }}" class="list-group-item">
        {{ $purchase->created_at->format("n/j/Y g:i A") }} &ndash; ${{ number_format($purchase->charge_amount, 2, ".", ",") }}
      </a>
    @endforeach
  </div>
@endsection
