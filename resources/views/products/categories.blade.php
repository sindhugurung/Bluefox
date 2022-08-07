@foreach($categories->products as $product)
  <h5>{{ $product->category_id }}</h5>
  <h5>{{ $product->product_name }}</h5>
@endforeach
