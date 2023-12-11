@extends('layouts.main') 
@section('title', 'Edit Product')
@section('content')

    <!-- push external head elements to head -->
    @push('head')
        <link rel="stylesheet" href="{{ asset('plugins/DataTables/datatables.min.css') }}">
        <link rel="stylesheet" href="{{ asset('plugins/select2/dist/css/select2.min.css') }}">
    @endpush

    <div class="container-fluid">
        <div class="page-header">
            <div class="row align-items-end">
                <div class="col-lg-8">
                    <div class="page-header-title">
                        <i class="ik ik-layers bg-blue"></i>
                        <div class="d-inline">
                            <h5>{{ __('Sales')}}</h5>
                            <span>{{ __('Edit Sale')}} </span>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <nav class="breadcrumb-container" aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="{{route('dashboard')}}"><i class="ik ik-home"></i></a>
                            </li>
                            <li class="breadcrumb-item">
                                <a href="{{url('sales')}}">{{ __('Sales')}}</a>
                            </li>
                            <li class="breadcrumb-item">
                                <a href="#">{{ __('Edit sale')}}</a>
                            </li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>

        <div class="row">
            @include('include.message')
            <div class="col-md-12">
                <div class="card">
    	        


                    <div class="card-header d-flex">
                        <h3 class="mr-auto p-2">Edit Sale</h3>
                        <a href="{{url('sales')}}" class="btn btn-outline-primary p-2 mr-5">{{ __('List all Sales')}}</a>
                    </div>
                    <div class="card-body">
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form class="forms-sample repeater" action="{{ route('sales.update', ['sale' => $sale->id]) }}" method="POST">
                            @csrf
                            @method('PUT')
                        
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="store">{{ __('Store')}}</label>
                                        <select class="form-control" id="store" name="store" required>
                                            @foreach($stores as $store)
                                                <option value="{{ $store->name }}" {{ $store->name == $sale->store ? 'selected' : '' }}>{{ $store->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                        
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="invoice_number">{{ __('Customer Name')}}</label>
                                        <select class="form-control" id="customer_name" name="customer_name" required>
                                            @foreach($customers as $customer)
                                                <option value="{{ $customer->contact_name }}" {{ $customer->contact_name == $sale->customer_name ? 'selected' : '' }}>{{ $customer->contact_name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                        
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="phone_number">{{ __('Phone Number')}}</label>
                                        <input type="text" class="form-control" id="phone_number" name="phone_number" placeholder="Customer's Phone Number" value="{{ $sale->phone_number }}">
                                    </div>
                                </div>
                        
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="date">{{ __('Date')}}</label>
                                        <input type="date" class="form-control" id="date" name="date" value="{{ $sale->date }}" required>
                                    </div>
                                </div>
                        
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="payment_status">{{ __('Payment Status')}}</label>
                                        <select class="form-control" id="payment_status" name="payment_status" required>
                                            @foreach($paymentStatuses as $status)
                                                <option value="{{ $status->id }}" {{ $status->id == $sale->payment_status ? 'selected' : '' }}>{{ $status->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                        
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="payment_method">{{ __('Payment Method')}}</label>
                                        <select class="form-control" id="payment_method" name="payment_method" required>
                                            @foreach($paymentMethods as $method)
                                                <option value="{{ $method->id }}" {{ $method->id == $sale->payment_method ? 'selected' : '' }}>{{ $method->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                        
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="sale_status">{{ __('Sale Status')}}</label>
                                        <select class="form-control" id="sale_status" name="sale_status" required>
                                            @foreach($saleStatuses as $saleStatus)
                                                <option value="{{ $saleStatus->id }}" {{ $saleStatus->id == $sale->sale_status ? 'selected' : '' }}>{{ $saleStatus->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                        
                            <hr>
                        
                            <div class="form-group">
                                <label for="invoice_number">{{ __('Search and add Products')}}</label>
                                <select class="form-control select2" id="product_selector" name="product_selector">
                                    <option value="">Enter product name or ISBN number</option>
                                    @foreach($products as $product)
                                        <option value="{{ $product->id }}" data-price="{{ $product->price }}">{{ $product->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        
                            <div class="table-responsive">
                                <table class="table mb-0" id="products_table">
                                    <thead>
                                        <th style="width: 50%;">Product</th>
                                        <th>Quantity</th>
                                        <th>Price</th>
                                        <th>Discount (%)</th>
                                        <th>Sub-total</th>
                                        <th>Remove</th>
                                    </thead>
                                    
                                    @if(count($saleItems) > 0)
                                        <tbody>    
                                            @foreach($saleItems as $index => $item)
                                                <input type="hidden" name="products[{{ $index }}][sale_id]" value="{{ $sale->id }}">
                                                
                                                <tr>
                                                    <td><input class="form-control" type="text" name="products[{{ $index }}][product_name]" value="{{ $item->product_name }}" readonly /></td>
                                                    <td><input class="form-control quantity" type="number" name="products[{{ $index }}][quantity]" value="{{ $item->quantity }}" /></td>
                                                    <td><input class="form-control price" type="text" name="products[{{ $index }}][price]" value="{{ $item->price }}" readonly /></td>
                                                    <td><input class="form-control discount" type="number" name="products[{{ $index }}][discount]" value="{{ $item->discount }}" /></td>
                                                    <td class="sub-total">{{ $item->sub_total }}</td>
                                                    <td><button type="button" class="btn btn-danger btn-icon ml-2 remove-row"><i class="ik ik-trash-2"></i></button></td>
                                                </tr>
                                            @endforeach
                                            
                                        </tbody>
                            
                                        <tfoot>
                                            <tr class="text-bold">
                                                {{-- {{ $grandTotal }} --}}
                                                <td colspan="4">Grand Total</td>
                                                <td><span id="grand_total">₦0.00</span></td>
                                                <td></td>
                                            </tr>
                                            <tr>
                                                <td colspan="4">Discount (%)</td>
                                                <td><input class="form-control" type="number" id="discount" name="discount" value="{{ $sale->discount }}" /></td>
                                                <td></td>
                                            </tr>
                                        </tfoot>
                                    @else
                                    <tbody>    
                                    </tbody>
                        
                                    <tfoot>
                                        <tr class="text-bold">
                                            {{-- {{ $grandTotal }} --}}
                                            <td colspan="4">Grand Total</td>
                                            <td><span id="grand_total">₦0.00</span></td>
                                            <td></td>
                                        </tr>
                                        <tr>
                                            <td colspan="4">Discount (%)</td>
                                            <td><input class="form-control" type="number" id="discount" name="discount" value="{{ $sale->discount }}" /></td>
                                            <td></td>
                                        </tr>
                                    </tfoot>
                                    @endif
                                </table>
                            </div>
                        
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-primary btn-block">{{ __('Update Sale')}}</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>




   

    

    <!-- push external js -->
    @push('script')
        {{-- <script src="{{ asset('src/js/vendor/jquery-3.3.1.min.js') }}"></script> --}}

        <script src="{{ asset('plugins/DataTables/datatables.min.js') }}"></script>
        <script src="{{ asset('js/datatables.js') }}"></script>
        <script src="{{ asset('plugins/jquery.repeater/jquery.repeater.min.js') }}"></script>
        <script src="{{ asset('plugins/select2/dist/js/select2.min.js') }}"></script>
        <script src="{{ asset('plugins/bootstrap-tagsinput/dist/bootstrap-tagsinput.min.js') }}"></script>


        <script>
            $(document).ready(function () {
                var categorySelect = $('#category');
                var subcategorySelect = $('#subcategory');
    
                categorySelect.on('change', function () {
                    console.log('Category selected');
                    var selectedCategoryId = $(this).val();
                    // Enable or disable subcategory based on category selection
                    subcategorySelect.prop('disabled', !selectedCategoryId);
    
                    // Fetch and populate subcategories based on the selected category
                    if (selectedCategoryId) {
                        fetchSubcategories(selectedCategoryId, subcategorySelect);
                    } else {
                        // Clear subcategory dropdown if no category is selected
                        subcategorySelect.html('<option value="">Select Subcategory</option>');
                    }
                });
    
                function fetchSubcategories(categoryId, subcategorySelect) {
                    // Use the correct route for fetching subcategories
                    $.ajax({
                        url: '{{ route('subcategories.index') }}',
                        method: 'GET',
                        data: { category_id: categoryId },
                        dataType: 'json',
                        success: function (data) {
                            // Populate subcategory dropdown with fetched data
                            subcategorySelect.html('<option value="">Select Subcategory</option>');
                            $.each(data, function (index, subcategory) {
                                subcategorySelect.append('<option value="' + subcategory.id + '">' + subcategory.name + '</option>');
                            });
                        },
                        error: function (error) {
                            console.error('Error fetching subcategories:', error);
                        }
                    });
                }
            });
        </script>

        <script>
           
            $(document).ready(function () {
                $('#product_selector').change(function () {
                    var productId       = $(this).val();
                    var productName     = $(this).find('option:selected').text();
                    var productPrice    = $(this).find('option:selected').data('price');
                    var saleId          =  {{ $sale->id }};
                    

                    if (productId) {
                        // Add a new row with product details
                        var newRow = $('<tr>');
                        newRow.append('<td><input class="form-control" type="text" name="products[' + productId + '][product_name]" value="' + productName + '" readonly /> <input type="hidden" name="products[' + productId + '][sale_id]" value="' + saleId + '" /></td>');
                        newRow.append('<td><input class="form-control quantity" type="number" name="products[' + productId + '][quantity]" value="1" /></td>');
                        newRow.append('<td><input class="form-control price" type="text" name="products[' + productId + '][price]" value="' + productPrice + '" readonly /></td>');
                        newRow.append('<td><input class="form-control discount" type="number" name="products[' + productId + '][discount]" value="0" /></td>');
                        newRow.append('<td class="sub-total">'+ productPrice +'</td>');
                        newRow.append('<td><button type="button" class="btn btn-danger btn-icon ml-2 remove-row"><i class="ik ik-trash-2"></i></button></td>');

                        // Append the new row to the table
                        $('#products_table tbody').append(newRow);

                        updateGrandTotal();
                    }
                });

                // Remove row when the "Remove" button is clicked
                $('#products_table').on('click', '.remove-row', function () {
                    $(this).closest('tr').remove();
                    updateGrandTotal();
                });

                // Update sub-total and grand total when quantity or discount changes
                $('#products_table').on('input', '.quantity, .discount', function () {
                    updateSubTotal($(this).closest('tr'));
                    updateGrandTotal();
                });

                // Update grand total when discount input changes
                $('#discount').on('input', function () {
                    updateGrandTotal();
                });

                function updateSubTotal(row) {
                    var quantity = parseFloat(row.find('.quantity').val()) || 0;
                    var price = parseFloat(row.find('.price').val()) || 0;
                    var discount = parseFloat(row.find('.discount').val()) || 0;

                    var subTotal = quantity * price * (1 - discount / 100);
                    row.find('.sub-total').text(subTotal.toFixed(2));
                }

                function updateGrandTotal() {
                    var grandTotal = 0;

                    $('#products_table tbody tr').each(function () {
                        grandTotal += parseFloat($(this).find('.sub-total').text()) || 0;
                    });

                    var discount = parseFloat($('#discount').val()) || 0;
                    grandTotal *= (1 - discount / 100);

                    $('#grand_total').text("₦" + grandTotal.toFixed(2));
                }
            });

        </script>
    @endpush

@endsection
