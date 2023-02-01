@extends('template')

@section("title")
    Page Title
@endsection

@section("heading")
    Page Heading
@endsection

@section('stylesheets')
<style>
    .page-styles {
        color: var(--maroon);
    }
</style>
@endsection

@section('javascript')
<script>
    console.log('Page Javascript');
</script>
@endsection

@section("content")
    
<h1 class="page-styles">Page Content</h1>

<h3>Default Typeahead</h3>
{!! 
    MustangBuilder::typeaheadAjax("input_name_here", 
    action([\App\Http\Controllers\SearchController::class, 'typeahead']), 
    '', 
    array("input_data_name" => "input_data", "display_data_name"=>"display_data"), 
    array("class"=>"typehead form-control", "autocomplete"=> "off"), 
    "hidden_input_id_here", 
    true)
!!}

@endsection

