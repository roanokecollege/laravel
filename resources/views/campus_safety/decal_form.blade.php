@extends("admin.template")

@section("title")
  Roanoke College Campus Safety
@endsection

@section("heading")
  Parking Decals
@endsection

@section("javascript")
  @parent
@endsection

@section("stylesheets")
  @parent
  <style>
    #vehicle-info {
      display: grid;
      grid-template-columns: 1fr 1fr 1fr;
      grid-gap: 20px;
    }
  </style>
@endsection

@section("content")
  <h2>Decal Request Form</h2>

  @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
  @endif

  <form action="{{ action("ParkingDecalController@storeRequest") }}" method="POST">
    @csrf
    <div class="form-group">
      <label for="name">
        Name
      </label>
      <div id="name">
        {{ $user->PreferredName }}
      </div>
    </div>
    <div class="form-group">
      <label for="resident">
        Decal Type
      </label>
      <div class="radio">
        <label class="radio-inline">
          <input type="radio" name="resident" value=0 /> Commuter
        </label>
        <label class="radio-inline">
          <input type="radio" name="resident" value=1 /> Resident
        </label>
      </div>
    </div>
    <div id="vehicle-info">
      <div class="form-group">
        <label for="make">
          Vehicle Make
        </label>
        <input type="text" name="make" id="make" class="form-control" />
      </div>
      <div class="form-group">
        <label for="model">
          Vehicle Model
        </label>
        <input type="text" name="model" id="model" class="form-control" />
      </div>
      <div class="form-group">
        <label for="color">
          Vehicle Color
        </label>
        <input type="text" name="color" id="color" class="form-control" />
      </div>
      <div class="form-group">
        <label for="year">
          Vehicle Year
        </label>
        <input type="number" name="year" id="year" min="1900" max="{{ \Carbon\Carbon::now()->addYear(1)->format("Y") }}" class="form-control" />
      </div>
      <div class="form-group">
        <label for="year">
          Vehicle Plate Number
        </label>
        <input type="text" name="plate" id="plate" class="form-control" />
      </div>
      <div class="form-group">
        <label for="state">
          Vehicle Plate State
        </label>
        <select name="state" id="state" class="form-control">
          <option selected disabled></option>
          @foreach($states as $state)
            <option value="{{ $state->StateCode }}">{{ $state->StateName }}</option>
          @endforeach
        </select>
      </div>
    </div>
    <div>
      The annual parking fee is <strong>${{ number_format($item->prices->first()->price, 2, ".", ",") }}</strong>.  Students may only register one car.
      You will be forwarded to Stripe to complete your transaction on the next step.
    </div>
    <div class="form-group" style="text-align: right">
      <button type="submit" class="btn btn-success">Purchase</button>
    </div>
  </form>

@endsection
