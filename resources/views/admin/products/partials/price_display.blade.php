<div class="list-group-item">
  <price-name>{{ $price->name }}</price-name>
  <price-value>{{ sprintf("$%0.2f", $price->price) }}</price-value>
  <price-remove><button type="button" class="btn btn-danger remove-price"><span class="far fa-times"></span> Delete</price-remove>
</div>
