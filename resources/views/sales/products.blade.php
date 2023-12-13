

<!-- include product preview page -->
@foreach($products as $key => $product)
	<div class="col-xl-3 col-lg-4 col-12 col-sm-6 mb-2 list-item list-item-grid p-2">
		<div class="card mb-1 pos-product-card" data-info="{{ htmlentities(json_encode($product)) }}">
			<div class="d-flex card-img">
				<img src="{{ asset($product->image ? 'storage/' . $product->image : 'product_images/no-image.png') }}" alt="" class="list-thumbnail responsive border-0">
			</div>
			<div class="p-2">
				<p>{{$product->name}} <br><small class="text-muted">{{$product->category->name}}</small> </p>

				<span class="product-price"><span class="price-symbol">{{ $settings->currency_symbol }}</span>{{ number_format($product->price) }}</span>
			</div>
		</div>
	</div>
@endforeach
						