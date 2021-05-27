@extends("admin.template")

@section("title")
  Roanoke College Business Office
@endsection

@section("heading")
  Stripe Item
@endsection

@section("javascript")
  <script>
    $(document).on("click", ".remove-price", function (evt) {
      let remove_url = $(this).data("remove-url");
      var price_button = $(this);
      $.ajax({
        url:    remove_url,
        method: "DELETE",
        data: {
          "_token":   "{{ csrf_token() }}",
        },
        success: function (response) {
          console.log(response);
          price_button.parents(".list-group-item").remove();
        },
        error: function (response) {
          console.log(response);
        }
      });
    });
  </script>
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
  <div style="text-align: right">
    <button class="btn btn-success add-price" data-toggle="modal" data-target="#add-price-modal"><span class="far fa-plus"></span> Add Price</button>
  </div>

  <div class="modal fade" id="add-price-modal" tabindex="-1" role="dialog" aria-labelledby="addPriceModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
          <h4 class="modal-title" id="addPriceModalLabel">Add price for product</h4>
        </div>
        <form method="POST" action="{{ action("Admin\ProductController@addPrice", $item) }}">
          @csrf
          <div class="modal-body">
            <div class="form-group">
              <label for="description">
                Price Description
              </label>
              <input type="text" name="name" id="description" class="form-control" required />
            </div>
            <div class="form-group">
              <label for="price">
                Price
              </label>
              <div class="input-group input-group-lg">
                <span class="input-group-addon">$</span>
                <input type="number" min="0.00" step="any" name="price" id="price" class="form-control" required />
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button type="submit" class="btn btn-success btn-lg"><span class="far fa-plus"></span> Add Price</button>
          </div>
        </form>
      </div>
    </div>
  </div>

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
