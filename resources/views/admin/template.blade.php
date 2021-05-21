@extends("template")

@section("stylesheets")
  <style>
    .widescreen-container {
      max-width: 1000px;
    }
  </style>
@endsection

@section("content")
  <div class="widescreen-container">
    @yield("content")
  </div>
@overwrite
