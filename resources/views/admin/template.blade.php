@extends("template")

@section("stylesheets")
  <link rel="stylesheet" type="text/css" href="{{ asset("css/shopping_cart.css") }}" />
  <style>
    .widescreen-container {
      max-width: 1000px;
    }
  </style>
@endsection

@section("javascript")
  <script src="{{ asset("js/shopping_cart.js") }}"></script>
@endsection

@section("content")
  <div class="widescreen-container">
    @yield("content")
  </div>
@overwrite
