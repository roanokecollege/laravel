@extends("admin.template")

@section("title")
  Roanoke College Business Office
@endsection

@section("heading")
  Create Product
@endsection

@section("javascript")
@endsection

@section("content")
    <form method="POST" action="{{ action("Admin\ProductController@store") }}">
      @csrf
      <div class="form-group">
        <label for="product_name">
          Product Name
        </label>
        <input type="text" name="product_name" id="product_name" class="form-control" />
      </div>
      <div class="form-group">
        <label for="object_code">
          Object Code
        </label>
        <input type="text" name="object_code" id="object_code" class="form-control" />
      </div>
      <div class="form-group" style="text-align: right">
        <button type="submit" class="btn btn-success btn-lg"><span class="far fa-plus"></span> Create
      </div>
    </form>
@endsection
