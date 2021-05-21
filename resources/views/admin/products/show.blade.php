@extends("admin.template")

@section("title")
  Roanoke College Business Office
@endsection

@section("heading")
  Stripe Item
@endsection

@section("javascript")
@endsection

@section("stylesheets")
  @parent
  <style>
    .list-group-item {
      display: grid;
      grid-template-columns: 1fr 1fr 100px;
    }
  </style>
@endsection

@section("content")
  <h2>{{ $item->product_name }}</h2>
  <p>
    @if(!empty($item->object_code))
      <strong>Object Code</strong> {{ $item->object_code }}
    @endempty
  </p>
  <hr />
  <h3>Prices</h3>
  <div class="list-group" style="margin-top: 10px;">
    @forelse($item->prices as $price)
      @include("admin.products.partials.price_display")
    @empty
      <p>
        There are no prices to show here.  Create a price first!
      </p>
    @endforelse
  </div>
@endsection
