<h1>Parking Decal Purchase Confirmation</h1>

<p>
  Thank you for your purchase!  At Check-In, you may simply pick up your Parking Decal at the Pre-Paid Decal table.
  <strong>All student vehicles parked on campus MUST display a RC Parking Decal!</strong>
</p>

<table class="gridtable">
  <tr>
    <th>Name</th>
    <td> {{ $user->PreferredName }} </td>
  </tr>
  <tr>
    <th>Decal Type</th>
    <td> {{ $decal_request->resident ? "Resident" : "Commuter" }} </td>
  </tr>
  <tr>
    <th>Make</th>
    <td> {{ $decal_request->make }} </td>
  </tr>
  <tr>
    <th>Model</th>
    <td> {{ $decal_request->model }} </td>
  </tr>
  <tr>
    <th>Color</th>
    <td> {{ $decal_request->color }} </td>
  </tr>
  <tr>
    <th>Year</th>
    <td> {{ $decal_request->year }} </td>
  </tr>
  <tr>
    <th>Plate Number</th>
    <td> {{ $decal_request->plate }} </td>
  </tr>
  <tr>
    <th>State</th>
    <td> {{ $decal_request->state }} </td>
  </tr>
</table>

<p>
  You will receive a separate email from Stripe with a purchase receipt.  You can also view your receipt online at
  <a href="{{ $purchase->receipt_url }}">{{ $purchase->receipt_url }}</a>.
</p>
