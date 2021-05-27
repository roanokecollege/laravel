@extends("admin.template")

@section("title")
  Roanoke College Business Office
@endsection

@section("heading")
  Stripe Items
@endsection

@section("content")
  <h2>Purchasable Items in Stripe</h2>
  <a href="{{ action("Admin\ProductController@create") }}" class="btn btn-success btn-lg pull-right"><span class="far fa-plus"></span> Create Item</a>
  <div class="list-group" style="margin-top: 50px;">
    @forelse($items as $item)
      <a href="{{ action("Admin\ProductController@show", $item) }}" class="list-group-item">
        <h3>{{ $item->product_name }}</h3>
      </a>
    @empty
      <p>
        There are no items to show here.  Create an item first!
      </p>
    @endforelse
  </div>
@endsection
