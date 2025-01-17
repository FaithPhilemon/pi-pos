<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
	<title>POS | Discovery World Bookshop</title>
	<!-- initiate head with meta tags, css and script -->
	@include('include.head')
	<link rel="stylesheet" href="{{ asset('plugins/select2/dist/css/select2.min.css') }}">
</head>
{{-- @php
$products = config('mockdata.products');
shuffle($products);
@endphp --}}


<body id="app">
	<div class="wrapper">
		<div class="pos-container p-3 pt-0">

			<header class="header-top" header-theme="light">
				<div class="container-fluid">
					<div class="d-flex justify-content-between">
						<div class="top-menu d-flex align-items-center">
							<a class="nav-link" href="{{ url('logout') }}">
								<i class="ik ik-power"></i>
							</a>&nbsp;&nbsp;

							<a href="{{url('/dashboard')}}" class="nav-link"><i class="ik ik-arrow-left-circle"></i></a>&nbsp;&nbsp;

							{{-- <button type="button" class="btn-icon mobile-nav-toggle d-lg-none"><span></span></button> --}}
							
				
							{{-- <button class="nav-link" title="clear cache">
								<a  href="{{url('clear-cache')}}">
								<i class="ik ik-battery-charging"></i> 
							</a>
							</button> &nbsp;&nbsp;
							<button type="button" id="navbar-fullscreen" class="nav-link"><i class="ik ik-maximize"></i></button> --}}
						</div>
						<div class="top-menu d-flex align-items-center">
							<div class="dropdown">
								<a class="nav-link dropdown-toggle" href="#" id="notiDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
									<i class="ik ik-shopping-cart"></i>
									<span class="badge bg-danger" id="holdCount">{{$holdCount}}</span>
									{{-- <span class="ml-2">{{ __('HOLD LIST')}}</span> --}}
								</a>
								<div class="dropdown-menu dropdown-menu-right notification-dropdown" aria-labelledby="notiDropdown">
									<h4 class="header">{{ __('Hold List')}}</h4>
									<div class="table-responsive">
										<table class="table table-hover mb-0">
											<thead>
												<tr>
													<th>Date</th>
													<th>Reference</th>
													<th>Action</th>
												</tr>
											</thead>
											<tbody id="holdList">
												@foreach ($holdSales as $holdSale)
													<tr>
														<td>{{ \Carbon\Carbon::parse($holdSale->date)->format('Y-m-d') }}</td>
														<td><a href="#" class="hold-link" data-hold-id="{{ $holdSale->id }}">{{ $holdSale->hold_reference }}</a></td>
														<td>
															<div class="row justify-content-left">
																{{-- <form action="{{ route('posHold.show', $holdSale->id) }}" method="GET">
																	@csrf
																	<button type="submit" class="btn-outline-primary">
																		<i class="ik ik-edit-2"></i>
																	</button>
																</form> --}}
																<a href="{{ route('posHold.show', $holdSale->id) }}" class="btn btn-outline-primary">
																	<i class="ik ik-edit-2"></i>
																</a>																
																<form action="{{ route('hold.destroy', $holdSale->id) }}" method="POST">
																	@csrf
																	@method('DELETE')
																	<button type="submit" class="btn btn-outline-danger">
																		<i class="ik ik-trash-2"></i>
																	</button>
																</form>
															</div>
														</td>
													</tr>
												@endforeach
											</tbody>
										</table>
									</div>
									<div class="footer"><a href="javascript:void(0);">{{ __('See all activity')}}</a></div>
								</div>
							</div>							
							

							{{-- <button type="button" class="nav-link ml-10 right-sidebar-toggle"><i class="ik ik-message-square"></i><span class="badge bg-success">3</span></button>
							<div class="dropdown">
								<a class="nav-link dropdown-toggle" href="#" id="menuDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="ik ik-plus"></i></a>
								<div class="dropdown-menu dropdown-menu-right menu-grid" aria-labelledby="menuDropdown">
									<a class="dropdown-item" href="#" data-toggle="tooltip" data-placement="top" title="Dashboard"><i class="ik ik-bar-chart-2"></i></a>
									<a class="dropdown-item" href="#" data-toggle="tooltip" data-placement="top" title="Message"><i class="ik ik-mail"></i></a>
									<a class="dropdown-item" href="#" data-toggle="tooltip" data-placement="top" title="Accounts"><i class="ik ik-users"></i></a>
									<a class="dropdown-item" href="#" data-toggle="tooltip" data-placement="top" title="Sales"><i class="ik ik-shopping-cart"></i></a>
									<a class="dropdown-item" href="#" data-toggle="tooltip" data-placement="top" title="Purchase"><i class="ik ik-briefcase"></i></a>
									<a class="dropdown-item" href="#" data-toggle="tooltip" data-placement="top" title="Pages"><i class="ik ik-clipboard"></i></a>
									<a class="dropdown-item" href="#" data-toggle="tooltip" data-placement="top" title="Chats"><i class="ik ik-message-square"></i></a>
									<a class="dropdown-item" href="#" data-toggle="tooltip" data-placement="top" title="Contacts"><i class="ik ik-map-pin"></i></a>
									<a class="dropdown-item" href="#" data-toggle="tooltip" data-placement="top" title="Blocks"><i class="ik ik-inbox"></i></a>
									<a class="dropdown-item" href="#" data-toggle="tooltip" data-placement="top" title="Events"><i class="ik ik-calendar"></i></a>
									<a class="dropdown-item" href="#" data-toggle="tooltip" data-placement="top" title="Notifications"><i class="ik ik-bell"></i></a>
									<a class="dropdown-item" href="#" data-toggle="tooltip" data-placement="top" title="More"><i class="ik ik-more-horizontal"></i></a>
								</div>
							</div> --}}
							{{-- <button type="button" class="nav-link ml-10" id="apps_modal_btn" data-toggle="modal" data-target="#appsModal"><i class="ik ik-grid"></i></button> --}}
							<div class="dropdown">
								<a class="dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><img class="avatar" src="{{ asset('img/user.jpg')}}" alt=""></a>
								<div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
									<a class="dropdown-item" href="{{url('profile')}}"><i class="ik ik-user dropdown-icon"></i> {{ __('Profile')}}</a>
									{{-- <a class="dropdown-item" href="#"><i class="ik ik-navigation dropdown-icon"></i> {{ __('Message')}}</a> --}}
									<a class="dropdown-item" href="{{ url('logout') }}">
										<i class="ik ik-power dropdown-icon"></i> 
										{{ __('Logout')}}
									</a>
								</div>
							</div>
						</div>
					</div>
				</div>
			</header>

			<div class="row" style="margin-top: 70px">

				{{-- <div class="col-sm-1 bg-white h-100vh ">
					<div class="pos top-menu mt-20 text-center">
						<a href="{{url('/dashboard')}}" class="nav-link m-auto mb-10"><i class="ik ik-arrow-left-circle"></i></a>
						<a href="#" class="nav-link m-auto mb-10" id="apps_modal_btn" data-toggle="modal" data-target="#appsModal"><i class="ik ik-grid"></i></a>
						<a class="nav-link m-auto mb-10" href="#" id="notiDropdown"><i class="ik ik-bell"></i><span class="badge bg-danger">1</span></a> 
						<a class="nav-link m-auto mb-10" href="{{url('profile')}}"><i class="ik ik-user"></i></a> 
						<a class="nav-link m-auto mb-10" href="{{ url('logout') }}">
							<i class="ik ik-power"></i>
						</a>
					</div>
				</div> --}}

				<div class="col-sm-7 bg-white">
					@include('include.message')

					<div class="customer-area">
						<div class="row">
							<div class="col-sm-3">
								<div class="form-group">
									<select class="form-control" name="warehouse">
										<option selected="selected" value="">Select Store</option>
										<option value="1">Warehouse 1</option>
										<option value="2">Warehouse 2</option>
									</select>
								</div>
							</div>
							
							<div class="col-sm-3">
								<select id="categoryFilter" class="form-control select2">
									<option value="">All Categories</option>
									@foreach($categories as $category)
										<option value="{{ $category->id }}">{{ $category->name }}</option>
										@foreach($category->subcategories as $subcategory)
											<option value="{{ $subcategory->id }}">- {{ $subcategory->name }}</option>
										@endforeach
									@endforeach
								</select>
							</div>


							<div class="col-sm-6">
								<div class="form-group">
									<input type="text" class="form-control" id="productSearch" placeholder="Search Product">
								</div>
							</div>

						</div>

						<div class="row pos-products layout-wrap" id="layout-wrap">

							@foreach($products as $key => $product)
								<div class="col-xl-2 col-lg-4 col-12 col-sm-6 mb-2 list-item list-item-grid p-2">
									<div class="card mb-1 pos-product-card" data-info="{{ htmlentities(json_encode($product)) }}">
										<div class="d-flex card-img">
											<img src="{{ asset($product->image ? 'public/img/products/' . $product->image : 'public/img/products/no-image.png') }}" alt="" class="list-thumbnail responsive border-0">
										</div>
										<div class="p-2" style="height: 120px; overflow: hidden;">
											<p style="margin-bottom: 0; overflow: hidden; display: -webkit-box; -webkit-line-clamp: 3; -webkit-box-orient: vertical;">
												{{$product->name}}
												<br>
												<small class="text-muted">{{$product->category->name}}</small>
											</p>
											<span class="product-price">
												<span class="price-symbol">{{ $settings->currency_symbol }}</span>{{ number_format($product->price) }}
											</span>
										</div>
									</div>
								</div>
							@endforeach
							
						</div>

						{{-- {{ $products->links() }} --}}
						
						<button id="loadMoreBtn" class="btn btn-outline-danger p-2 mr-10 btn-checkout btn-pos-checkout">Load More</button>
					</div>
				</div>

				<div class="col-sm-5 bg-white product-cart-area">
					<div class="product-selection-area">
						<div class="d-flex justify-content-between align-items-center">
							<h5 class="mb-0"> Order Details</h6>
								<i class="text-danger ik ik-refresh-ccw cursor-pointer font-15" onclick="cleartCart()"></i>
						</div>
						<hr>

						@if ($errors->any())
							<div class="alert alert-danger">
								<ul>
									@foreach ($errors->all() as $error)
										<li>{{ $error }}</li>
									@endforeach
								</ul>
							</div>
						@endif

						@if(isset($saleItems))
							<!-- Prepopulated form for hold sale -->
							<form action="{{ route('pos.store') }}" method="POST" id="mainForm">
								@csrf
	
								{{-- <div id="product-cart" class="product-cart mb-3">
									<script>
										$(document).ready(function() {
											var holdSaleItems = {!! json_encode($holdSale->items) !!};
											var productCart = $('#product-cart');
								
											holdSaleItems.forEach(function(item) {
												var html = `
													<div class="d-flex justify-content-between position-relative">
														<i class="text-red ik ik-x-circle cart-remove cursor-pointer" onclick="removeCartItem(${item.id})"></i>
														<div class="cart-image-holder">
															<img src="${item.image}">
														</div>
														<div class="w-100 p-2">
															<h5 class="mb-2 cart-item-title">${item.name}</h5>
															<input type="hidden" name="products[${item.id}][product_name]" value="${item.name}">
															<div class="d-flex justify-content-between">
																<span class="text-muted">${item.quantity}x</span>
																<input type="hidden" name="products[${item.id}][quantity]" value="${item.quantity}">
																<span class="text-success font-weight-bold cart-item-price">${item.subtotal.toFixed()}</span>
																<input class="sub-total" type="hidden" name="products[${item.id}][price]" value="${item.price.toFixed()}">
																<span class="text-muted">discount>></span>
																<input class="form-control w-30 discount" type="number" name="products[${item.id}][discount]" value="${item.discount}" readonly data-toggle="tooltip" data-placement="top" title="Click to change" style="cursor: pointer;"/>
															</div>
														</div>
													</div>
												`;
												productCart.append(html);
											});
										});
									</script>
								</div> --}}

								<div id="product-cart" class="product-cart mb-3">
									@foreach($saleItems as $item)
										<div class="d-flex justify-content-between position-relative">
											<i class="text-red ik ik-x-circle cart-remove cursor-pointer" onclick="removeCartItem({{ $item->id }})"></i>
											<div class="cart-image-holder">
												<img src="{{ $item->image }}">
											</div>
											<div class="w-100 p-2">
												<h5 class="mb-2 cart-item-title">{{ $item->product_name }}</h5>
												<input type="hidden" name="products[{{ $item->id }}][product_name]" value="{{ $item->product_name }}">
												<div class="d-flex justify-content-between">
													<span class="text-muted">{{ $item->quantity }}x</span>
													<input type="hidden" name="products[{{ $item->id }}][quantity]" value="{{ $item->quantity }}">
													<span class="text-success font-weight-bold cart-item-price">{{ $item->total }}</span>
													<input class="sub-total" type="hidden" name="products[{{ $item->id }}][price]" value="{{ $item->price }}">
													<span class="text-muted">discount>></span>
													<input class="form-control w-30 discount" type="number" name="products[{{ $item->id }}][discount]" value="{{ $item->discount }}" readonly data-toggle="tooltip" data-placement="top" title="Click to change" style="cursor: pointer;"/>
												</div>
											</div>
										</div>
									@endforeach
								</div>

								<div class="box-shadow p-3">
									<div class="d-flex justify-content-between font-15 align-items-center">
										<span>Subtotal</span>
										<strong id="subtotal-products">0.00</strong>
									</div>
									
	
									<hr>
									<div class="d-flex justify-content-between font-20 align-items-center">
										<b>Total Payable</b>
										<b id="total-bill">0.00</b>
									</div>
								</div>
								<div class="box-shadow p-3 mb-3">
									<div class="form-group">
										<select class="form-control select2" id="store" name="store" required>
											@foreach($stores as $store)
												<option value="{{ $store->name }}">{{ $store->name }}</option>
											@endforeach
										</select>
									</div>
	
	
									<label class="d-block">Customer Information</label>
									<div class="d-block">
										<div class="form-group">
											<select class="form-control select2" id="customer_name" name="customer_name" required>
												@foreach($customers as $customer)
												<option value="{{ $customer->contact_name }}">{{ $customer->contact_name }}</option>
												@endforeach
											</select>
										</div>
										
										<div class="form-group">
											<input type="text" class="form-control" id="phone_number" name="phone_number" placeholder="Customer's Number">
										</div>
									</div>
								</div>
								
								<div class="box-shadow p-3 row">
									<div class="col-md-6">
										<button type="button" class="btn btn-danger btn-block" id="holdBtn" data-toggle="modal" data-target="#holdModal">
											<i class="fa fa-hand-paper" aria-hidden="true"></i>HOLD
										</button>
									</div>
	
									<div class="col-md-6">
										<button type="submit" class="btn btn-success btn-checkout btn-pos-checkout">PLACE ORDER</button>
									</div>
								</div>
							</form>
						@else
							<!-- Default order form -->
							<form action="{{ route('pos.store') }}" method="POST" id="mainForm">
								@csrf
	
								<div id="product-cart" class="product-cart mb-3">
									
								</div>
								<div class="box-shadow p-3">
									<div class="d-flex justify-content-between font-15 align-items-center">
										<span>Subtotal</span>
										<strong id="subtotal-products">0.00</strong>
									</div>
									{{-- <div class="d-flex justify-content-between font-15 align-items-center">
										<span>Percentage Discount</span>
										<input type="number" class="form-control w-90 font-15 text-right" name="percentage" id="discount">
									</div>
	
									<div class="d-flex justify-content-between font-15 align-items-center pt-5">
										<span>Price Discount</span>
										<input class="form-control w-90 font-15 text-right" id="discountAmt" name="price">
									</div> --}}
	
									<hr>
									<div class="d-flex justify-content-between font-20 align-items-center">
										<b>Total Payable</b>
										<b id="total-bill">0.00</b>
									</div>
								</div>
								<div class="box-shadow p-3 mb-3">
									<div class="form-group">
										<select class="form-control select2" id="store" name="store" required>
											@foreach($stores as $store)
												<option value="{{ $store->name }}">{{ $store->name }}</option>
											@endforeach
										</select>
									</div>
	
									{{-- <input type="date" class="form-control" id="date" name="date" required> --}}
	
									<label class="d-block">Customer Information</label>
									<div class="d-block">
										<div class="form-group">
											{{-- <input type="text" name="name" class="form-control" placeholder="Enter Customer Name" value="Christopher Alex"> --}}
											<select class="form-control select2" id="customer_name" name="customer_name" required>
												@foreach($customers as $customer)
												<option value="{{ $customer->contact_name }}">{{ $customer->contact_name }}</option>
												@endforeach
											</select>
										</div>
										
										<div class="form-group">
											<input type="text" class="form-control" id="phone_number" name="phone_number" placeholder="Customer's Number">
										</div>
										 {{--<div class="form-group">
											<textarea type="text" name="name" class="form-control h-82px" placeholder="Enter Address" value="Christopher Alex"></textarea>
										</div> --}}
									</div>
								</div>
	
	
								
								<div class="box-shadow p-3 row">
									<div class="col-md-6">
										<button type="button" class="btn btn-danger btn-block" id="holdBtn" data-toggle="modal" data-target="#holdModal">
											<i class="fa fa-hand-paper" aria-hidden="true"></i>HOLD
										</button>
										
										{{-- <button class="btn btn-danger btn-checkout btn-pos-checkout " data-toggle="modal" data-target="#InvoiceModal">PLACE ORDER 2</button> --}}
									</div>
	
									<div class="col-md-6">
										<button type="submit" class="btn btn-success btn-checkout btn-pos-checkout">PLACE ORDER</button>
									</div>
								</div>
							</form>
						@endif
						
					</div>

				</div>
			</div>
		</div>
	</div>
	<!-- initiate modal menu section-->
	@include('include.modalmenu')

	{{-- Hold transaction modal --}}
	<div class="modal fade" id="holdModal" tabindex="-1" role="dialog" aria-labelledby="holdModalLabel" aria-hidden="true">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="holdModalLabel">Hold Invoice?</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				
				<div class="modal-body">
					<div class="form-group">
						<label for="holdReference">Enter Reference:</label>
						<input type="text" class="form-control" id="holdReference" name="hold_reference" placeholder="Enter reference code" required>
						<br>
						<div class="alert alert-primary" role="alert">
							<strong>Note</strong> Same Reference will replace the old list if exist!
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button class="btn btn-danger" id="holdSubmitBtn">Yes, Hold</button>
					<button type="button" class="btn btn-secondary" data-dismiss="modal">No, Cancel</button>
				</div>
			</div>
		</div>
	</div>

	<!-- Preview Invoice Modal -->
	<div class="modal fade edit-layout-modal pr-0 " id="InvoiceModal" role="dialog" aria-labelledby="InvoiceModalLabel" aria-hidden="true">
		<div class="modal-dialog mw-70" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="InvoiceModalLabel">Preview Invoice</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
				</div>
				<div class="modal-body">
					<div class="card-header">
						<h3 class="d-block w-100">Radmin<small class="float-right">07/10/2021</small></h3>
					</div>
					<div class="card-body">
						@include('common.invoice')
						<div class="row no-print">
							<div class="col-12">
								<button type="button" class="btn btn-success pull-right"><i class="fa fa-credit-card"></i> Submit Payment</button>
								<button type="button" class="btn btn-primary pull-right"><i class="fa fa-download"></i> Generate PDF</button>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<!-- Modal for discount input -->
	<div class="modal fade" id="discountModal" tabindex="-1" role="dialog" aria-labelledby="discountModalLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="discountModalLabel">Apply Discount</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<form id="discountForm">
					<div class="form-group">
						<label for="discountType">Discount Type</label>
						<select class="form-control" id="discountType" name="discountType">
							<option value="percentage">Percentage(%)</option>
							<option value="fixed">Fixed(₦)</option>
						</select>
					</div>
					<div class="form-group">
						<label for="discountAmount">Discount Amount</label>
						<input type="number" class="form-control" id="discountAmount" name="discountAmount" min="0" step="0.01">
					</div>
				</form>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
				<button type="button" class="btn btn-primary" id="applyDiscountBtn">Apply Discount</button>
			</div>
		</div>
	</div>
	</div>


	{{-- Modal for success hold --}}
	<div class="modal fade" id="successModal" tabindex="-1" role="dialog" aria-labelledby="successModalLabel" aria-hidden="true">
		<div class="modal-dialog" role="document">
		  <div class="modal-content">
			<div class="modal-header">
			  <h5 class="modal-title" id="successModalLabel">Success</h5>
			  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
				<span aria-hidden="true">&times;</span>
			  </button>
			</div>
			<div class="modal-body">
			  <!-- Success message will be displayed here -->
			</div>
			<div class="modal-footer">
			  <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
			</div>
		  </div>
		</div>
	  </div>
	
	<!-- push external js -->
	<script src="{{ asset('all.js') }}"></script>
	<script src="{{ asset('dist/js/theme.js') }}"></script>
	{{-- <script src="{{ asset('src/js/vendor/jquery-3.3.1.min.js') }}"></script> --}}
	<script src="{{ asset('plugins/select2/dist/js/select2.min.js') }}"></script>
	

	<script>
		$(document).ready(function() {
			$(".select2").select2();
		});


		const parser = new DOMParser();

		function decodeString(inputStr) {
			return parser.parseFromString(`<!doctype html><body>${inputStr}`, 'text/html').body.textContent
		}

		var cart = {};
		$(document).on('click', '.pos-product-card', function() {
			var product = JSON.parse(decodeString($(this).data('info')));
			var price = parseFloat(product.price) || 0; // Ensure price is a number //product.offer_price ? product.offer_price : product.regular_price;
			var id = product.id;
			// console.log(product.image);

			if (cart.hasOwnProperty(id)) {
				cart[id].quantity++;
				cart[id].subtotal = price * cart[id].quantity;
			} else {
				cart[id] = {
					name: product.name,
					image: 'public/img/products/'+product.image,
					price: price,
					quantity: 1,
					subtotal: price
				};
			}

			// console.log(cart);
			// Update cart table
			updateCartTable();
		});

		$(document).on('keyup', '#discount', function() {
			updateCartTable();
		});

		$(document).on('keyup', '#discountAmt', function() {
			updateCartTable();
		});

		function removeCartItem(id) {
			delete cart[id];
			updateCartTable();
		}

		function cleartCart() {
			if (confirm('Are you sure to clear cart?')) {
				cart = {};
				$('#discount').val(0)
				$('#discountAmt').val(0)
				updateCartTable();
			}
		}

		// function updateCartTable() {
		// 	var $cartTable = $('#product-cart'),
		// 		$cartTotal = $('#subtotal-products'),
		// 		$totalText = $('#total-bill');

		// 	var cartTotal = 0,
		// 		discountPercentage = parseFloat($('#discount').val()) || 0,
		// 		discountAmount2 = parseFloat($('#discountAmt').val()) || 0;

		// 	// Loop through cart items and add them to cart table
		// 	for (var id in cart) {
		// 		if (cart.hasOwnProperty(id)) {
		// 			var item = cart[id];

		// 			var $tr = `<div class="d-flex justify-content-between position-relative">
		// 						<i class="text-red ik ik-x-circle cart-remove cursor-pointer" onclick="removeCartItem(${id})"></i>
		// 						<div class="cart-image-holder">
		// 							<img src="${item.image}">
		// 						</div>
		// 						<div class="w-100 p-2">
		// 							<h5 class="mb-2 cart-item-title">${item.name}</h5>
		// 							<input type="hidden" name="products[${id}][product_name]" value="${item.name}">
		// 							<div class="d-flex justify-content-between">
		// 								<span class="text-muted">${item.quantity}x</span>
		// 								<input type="hidden" name="products[${id}][quantity]" value="${item.quantity}">
		// 								<span class="text-success font-weight-bold cart-item-price">${item.subtotal.toFixed()}</span>
		// 								<input class="sub-total" type="hidden" name="products[${id}][price]" value="${item.price.toFixed()}">
		// 								<span class="text-muted">discount>></span>
		// 								<input class="form-control w-30 discount" type="number" name="products[${id}][discount]" value="${item.discount}" readonly data-toggle="tooltip" data-placement="top" title="Click to change" style="cursor: pointer;"/>
		// 							</div>
		// 						</div>
		// 					</div>`;
		// 			$cartTable.append($tr);
		// 			cartTotal += item.subtotal;
		// 		}
		// 	}

		// 	// Check which input field has focus to determine discount type
		// 	var activeDiscountInput = document.activeElement.id;
		// 	var discountAmount = 0;
		// 	if (activeDiscountInput === 'discount') {
		// 		discountAmount = (cartTotal * (discountPercentage / 100));
		// 		$('#discountAmt').val(''); // Clear price-based discount input
		// 	} else if (activeDiscountInput === 'discountAmt') {
		// 		discountAmount = Math.min(discountAmount2, cartTotal); // Ensure price-based discount doesn't exceed cart total
		// 		$('#discount').val(''); // Clear percentage-based discount input
		// 	}

		// 	// Update cart total and total text
		// 	$cartTotal.text(cartTotal.toFixed());
		// 	$totalText.text((cartTotal - discountAmount).toFixed());
		// }


		function updateCartTable() {
			var $cartTable = $('#product-cart'),
				$cartTotal = $('#subtotal-products'),
				$totalText = $('#total-bill');

			var cartTotal = 0,
				discountPercentage = parseFloat($('#discount').val()) || 0,
				discountAmount2 = parseFloat($('#discountAmt').val()) || 0;

			// Empty cart table
			$cartTable.empty();

			// Loop through cart items and add them to cart table
			for (var id in cart) {
				if (cart.hasOwnProperty(id)) {
					var item = cart[id];

					var $tr = `<div class="d-flex justify-content-between position-relative">
								<i class="text-red ik ik-x-circle cart-remove cursor-pointer" onclick="removeCartItem(${id})"></i>
								<div class="cart-image-holder">
									<img src="${item.image}">
								</div>
								<div class="w-100 p-2">
									<h5 class="mb-2 cart-item-title">${item.name}</h5>
									<input type="hidden" name="products[${id}][product_name]" value="${item.name}">
									<div class="d-flex justify-content-between">
										<span class="text-muted">${item.quantity}x</span>
										<input type="hidden" name="products[${id}][quantity]" value="${item.quantity}">

										<span class="text-success font-weight-bold cart-item-price">${item.subtotal.toFixed()}</span>
										<input class="sub-total" type="hidden" name="products[${id}][price]" value="${item.price.toFixed()}">
										<span class="text-muted">discount>></span>
										<input class="form-control w-30 discount" type="number" name="products[${id}][discount]" value="${item.discount}" readonly data-toggle="tooltip" data-placement="top" title="Click to change" style="cursor: pointer;"/>
									</div>
								</div>
							</div>`;
					$cartTable.append($tr);
					cartTotal += item.subtotal;
				}
			}

			// Check which input field has focus to determine discount type
			var activeDiscountInput = document.activeElement.id;
			var discountAmount = 0;
			if (activeDiscountInput === 'discount') {
				discountAmount = (cartTotal * (discountPercentage / 100));
				$('#discountAmt').val(''); // Clear price-based discount input
			} else if (activeDiscountInput === 'discountAmt') {
				discountAmount = Math.min(discountAmount2, cartTotal); // Ensure price-based discount doesn't exceed cart total
				$('#discount').val(''); // Clear percentage-based discount input
			}

			// Update cart total and total text
			$cartTotal.text(cartTotal.toFixed());
			$totalText.text((cartTotal - discountAmount).toFixed());
		}


		$(document).ready(function () {
			// Load more button click event
			$('#loadMoreBtn').click(function () {
				var nextPage = {{ $products->currentPage() + 1 }};
				var url = '{{ route('sales.pos') }}?page=' + nextPage;

				$.get(url, function (data) {
					$('#layout-wrap').append(data);
				});
			});

			// Real-time search input
			$('#productSearch').on('input', function () {
				var searchTerm = $(this).val();
				updateProductsSearch(searchTerm);
			});

			// Real-time category filter
			$('#categoryFilter').change(function () {
				var categoryId = $(this).val();
				updateProductsCategory(categoryId);
			});

			function updateProductsSearch(searchTerm) {
				var url = '{{ route('sales.pos') }}';
				var data = { searchTerm: searchTerm};

				$.get(url, data, function (data) {
					console.log(data);
					$('#layout-wrap').html(data);
				});
			}

			function updateProductsCategory(categoryId) {
				var url = '{{ route('sales.pos') }}';
				var data = { categoryId: categoryId };

				$.get(url, data, function (data) {
					console.log(data);
					$('#layout-wrap').html(data);
				});
			}

			// function updateProducts(searchTerm ='', categoryId='') {
			// 	var url = '{{ route('sales.pos') }}';
			// 	var data = { searchTerm: searchTerm, categoryId: categoryId };

			// 	$.get(url, data, function (data) {
			// 		$('#layout-wrap').html(data);
			// 	});
			// }


			var selectedRowIndex; // Variable to store the selected row index

			// Click event handler for discount inputs to open modal
			$('#product-cart').on('click', '.discount', function () {
				var $parentDiv = $(this).closest('.position-relative');
				selectedRowIndex = $('#product-cart > .position-relative').index($parentDiv); // Store the index of the selected row
				$('#discountModal').modal('show');
				// console.log(selectedRowIndex);
			});



			// Apply discount button click event handler
			$('#applyDiscountBtn').click(function () {
				var discountType = $('#discountType').val();
				var discountAmount = parseFloat($('#discountAmount').val()) || 0;

				if (!isNaN(selectedRowIndex)) {
					var row = $('#product-cart > .position-relative').eq(selectedRowIndex);
					var price = parseFloat(row.find('.cart-item-price').text());
					var quantity = parseFloat(row.find('.text-muted').text().split('x')[0]) || 0;

					var discount = 0;

					if (discountType === 'percentage') {
						discount = price * discountAmount / 100;
					} else {
						discount = Math.min(discountAmount, price * quantity);
					}

					// console.log("Discount is: "+discount);

					// Update the discount value
					row.find('.discount').val(discount.toFixed());
					var subTotal = (price * quantity) - discount;
					row.find('.sub-total').text(subTotal.toFixed());

					// Update the grand total
					updateGrandTotal();
				} else {
					console.log("No selected row index found.");
				}

				$('#discountModal').modal('hide');
			});


			function updateGrandTotal() {
				var grandTotal = 0;

				// Loop through cart items to calculate subtotal and apply discounts
				$('#product-cart > .position-relative').each(function () {
					var price = parseFloat($(this).find('.cart-item-price').text());
					var quantity = parseFloat($(this).find('.text-muted').text().split('x')[0]) || 0;
					var discount = parseFloat($(this).find('.discount').val()) || 0;
					var subTotal = (price * quantity) - discount;
					grandTotal += subTotal;
				});

				// Update grand total based on discount type and amount
				// var discountType = $('#discountType').val();
				// var discountAmount = parseFloat($('#discountAmount').val()) || 0;

				// if (discountType === 'percentage') {
				// 	grandTotal *= (1 - discountAmount / 100);
				// } else {
				// 	grandTotal -= discountAmount;
				// }

				// Display the updated grand total
				$('#total-bill').text("₦" + grandTotal.toFixed());
			}


		});
							

		// Handle hold transactions
		document.getElementById('holdSubmitBtn').addEventListener('click', function() {
			// Capture data from the main form
			var formData = new FormData(document.getElementById('mainForm'));
			// Add hold reference
			var holdReference = document.getElementById('holdReference').value;
			formData.append('hold_reference', holdReference);


			// Send hold request to the server using AJAX
			$.ajax({
				url: 'pos', 
				type: 'POST',
				data: formData, // form data
				processData: false, 
				contentType: false, 
				success: function(response) {
					// if (response.success) {
					// 	// Reload the page
					// 	window.location.href = response.reload_url;
					// } else {
					// 	console.error('Sale hold failed:', response.message);
					// }

					if (response.success) {
						// Show success message in a modal or alert
						showAlert('Success', response.message);
						window.location.href = response.reload_url;
					} else {
						console.error('Sale creation failed:', response.message);
					}
				},
				error: function(xhr, status, error) {
					// Handle error
					console.error('Hold request failed:', error);
				}
			});
		});


		function showAlert(title, message) {
			// Example of showing a Bootstrap modal
			$('#successModal .modal-title').text(title);
			$('#successModal .modal-body').text(message);
			$('#successModal').modal('show');
		}


		// Function to load hold sales
		// function loadHoldSales() {
		// 	$.ajax({
		// 		url: 'hold-sales', // Assuming this is the route to fetch hold sales
		// 		type: 'GET',
		// 		success: function(response) {
		// 			$('#holdList').empty(); // Clear existing hold list
		// 			$('#holdCount').text(response.holdCount); // Update hold count badge
		// 			$.each(response.holdSales, function(index, holdSale) {
		// 				var holdDate = new Date(holdSale.date);
		// 				var formattedDate = holdDate.toLocaleDateString();

		// 				var holdItem = `
		// 					<tr>
		// 						<td>${formattedDate}</td>
		// 						<td><a href="#" class="hold-link" data-hold-id="${holdSale.id}">${holdSale.hold_reference}</a></td>
		// 						<td>
		// 							<form action="/sale/${holdSale.id}" method="POST" id="deleteForm_${holdSale.id}">
		// 								@csrf
		// 								@method('DELETE')
		// 								<button type="submit" class="btn btn-sm btn-outline-danger delete-hold" data-hold-id="${holdSale.id}">
		// 									<i class="ik ik-trash-2"></i>
		// 								</button>
		// 							</form>
		// 							<button class="btn btn-sm btn-outline-primary edit-hold" data-hold-id="${holdSale.id}">
		// 								<i class="ik ik-edit-2"></i>
		// 							</button>
		// 						</td>
		// 					</tr>`;
		// 				$('#holdList').append(holdItem);
		// 			});

		// 			// $.each(response.holdSales, function(index, holdSale) {
		// 			// 	var holdItem = `
		// 			// 		<a href="#" class="media">
		// 			// 			<span class="d-flex">
		// 			// 				<i class="ik ik-cart"></i> 
		// 			// 			</span>
		// 			// 			<span class="media-body">
		// 			// 				<span class="text-muted">${holdSale.date}</span> 
		// 			// 				<span class="heading-font-family media-heading">
		// 			// 					<a href="#" class="hold-link" data-hold-id="${holdSale.id}">${holdSale.holdReference}</a>
		// 			// 				</span> 
		// 			// 				<span class="media-content">${holdSale.message}</span>
		// 			// 			</span>
		// 			// 			<span class="ml-auto">
		// 			// 				<button class="btn btn-sm btn-outline-primary edit-hold" data-hold-id="${holdSale.id}">
		// 			// 					<i class="ik ik-edit-2"></i>
		// 			// 				</button>
		// 			// 				<button class="btn btn-sm btn-outline-danger delete-hold" data-hold-id="${holdSale.id}">
		// 			// 					<i class="ik ik-trash-2"></i>
		// 			// 				</button>
		// 			// 			</span>
		// 			// 		</a>`;
		// 			// 	$('#holdList').append(holdItem);
		// 			// });
		// 		},
		// 		error: function(xhr, status, error) {
		// 			console.error('Failed to load hold sales:', error);
		// 		}
		// 	});
		// }

		// Call the function to load hold sales when the page loads
		// $(document).ready(function() {
		// 	loadHoldSales();
		// });

		// Click event listener for hold link
		// $(document).on('click', '.hold-link', function(e) {
		// 	e.preventDefault();
		// 	var holdId = $(this).data('hold-id');
		// 	// Logic to populate form with hold sales data goes here
		// });


	</script>


</body>

</html>