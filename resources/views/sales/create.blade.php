@extends('layouts.main') 
@section('title', 'Add Product')
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
                            <span>{{ __('Add new sales')}} </span>
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
                                <a href="#">{{ __('Add New sale')}}</a>
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
                        <h3 class="mr-auto p-2">Add New Sale</h3>
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

                        <form class="forms-sample repeater" action="{{ route('sales.store') }}" method="POST">
                            @csrf
        
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="store">{{ __('Store')}}</label>
                                            <select class="form-control" id="store" name="store" required>
                                                @foreach($stores as $store)
                                                    <option value="{{ $store->name }}">{{ $store->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="invoice_number">{{ __('Customer Name')}}</label>                                    
                                            <select class="form-control select2" id="customer_name" name="customer_name" required>
                                                @foreach($customers as $customer)
                                                    <option value="{{ $customer->contact_name }}">{{ $customer->contact_name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="phone_number">{{ __('Phone Number')}}</label>
                                            <input type="text" class="form-control" id="phone_number" name="phone_number" placeholder="Customer's Phone Number">
                                        </div>
                                    </div>


                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="date">{{ __('Date')}}</label>
                                            <input type="date" class="form-control" id="date" name="date" required>
                                        </div>
                                    </div>
        
        
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="payment_status">{{ __('Payment Status')}}</label>
                                            <select class="form-control" id="payment_status" name="payment_status" required>
                                                @foreach($paymentStatuses as $status)
                                                    <option value="{{ $status->id }}">{{ $status->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
        
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="payment_method">{{ __('Payment Method')}}</label>
                                            <select class="form-control" id="payment_method" name="payment_method" required>
                                                @foreach($paymentMethods as $method)
                                                    <option value="{{ $method->id }}">{{ $method->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
        
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="sale_status">{{ __('Sale Status')}}</label>
                                            <select class="form-control" id="sale_status" name="sale_status" required>
                                                @foreach($saleStatuses as $saleStatus)
                                                    <option value="{{ $saleStatus->id }}">{{ $saleStatus->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
        
                                    {{-- <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="total_amount">{{ __('Total Amount')}}</label>
                                            <input type="text" class="form-control" id="total_amount" name="total_amount" value="0" placeholder="Total Amount" required>
                                        </div>
                                    </div>
        
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="total_paid">{{ __('Total Paid')}}</label>
                                            <input type="text" class="form-control" id="total_paid" name="total_paid" value="0" placeholder="Total Paid" required>
                                        </div>
                                    </div>
        
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="total_items">{{ __('Total Items')}}</label>
                                            <input type="number" class="form-control" id="total_items" value="0" name="total_items" placeholder="Total Items" required>
                                        </div>
                                    </div> --}}
        
                                </div>
                        
                                {{-- <div class="form-group">
                                    <label for="shipping_status">{{ __('Shipping Status')}}</label>
                                    <select class="form-control" id="shipping_status" name="shipping_status" required>
                                        @foreach($shippingStatuses as $status)
                                            <option value="{{ $status->id }}">{{ $status->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                        
                                <div class="form-group">
                                    <label for="shipping_details">{{ __('Shipping Details')}}</label>
                                    <textarea class="form-control" id="shipping_details" name="shipping_details" rows="4" placeholder="Shipping Details"></textarea>
                                </div> --}}
                        
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
                                        <tbody>
                                        </tbody>

                                        <tfoot>
                                            <tr class="text-bold">
                                                <td colspan="4">Grand Total</td>
                                                <td><span id="grand_total">₦0.00</span></td>
                                                <td></td>
                                            </tr>
                                            <tr>
                                                <td colspan="4">Discount (%)</td>
                                                <td><input class="form-control" type="number" id="discount" name="discount" value="0" /></td>
                                                <td></td>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>


                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('Close')}}</button>
                                    <button type="submit" class="btn btn-primary">{{ __('Save')}}</button>
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
            // $(document).ready(function () {
            //     $('#product_selector').change(function () {
            //         var productId = $(this).val();
            //         var productName = $(this).find('option:selected').text();
            //         var productPrice = $(this).find('option:selected').data('price');

            //         if (productId) {
            //             // Add a new row with product details
            //             var newRow = $('<tr>');
            //             newRow.append('<td><input class="form-control" type="text" name="products[' + productId + '][product_name]" value="' + productName + '" readonly /></td>');
            //             newRow.append('<td><input class="form-control quantity" type="number" name="products[' + productId + '][quantity]" value="1" /></td>');
            //             newRow.append('<td><input class="form-control price" type="text" name="products[' + productId + '][price]" value="' + productPrice + '" readonly /></td>');
            //             newRow.append('<td><input class="form-control discount" type="number" name="products[' + productId + '][discount]" value="0" /></td>');
            //             newRow.append('<td><input class="form-control sub-total" type="text" name="products[' + productId + '][sub_total]" readonly /></td>');
            //             newRow.append('<td><button type="button" class="btn btn-danger btn-icon ml-2 remove-row"><i class="ik ik-trash-2"></i></button></td>');

            //             // Append the new row to the table
            //             $('#products_table tbody').append(newRow);

            //             updateSubTotal(newRow);
            //             updateGrandTotal();
            //         }
            //     });

            //     // Remove row when the "Remove" button is clicked
            //     $('#products_table').on('click', '.remove-row', function () {
            //         $(this).closest('tr').remove();
            //         updateGrandTotal();
            //     });

            //     // Update sub-total and grand total when quantity or discount changes
            //     $('#products_table').on('input', '.quantity, .discount', function () {
            //         updateSubTotal($(this).closest('tr'));
            //         updateGrandTotal();
            //     });

            //     // Update grand total when discount input changes
            //     $('#discount').on('input', function () {
            //         updateGrandTotal();
            //     });

            //     function updateSubTotal(row) {
            //         var quantity = parseFloat(row.find('.quantity').val()) || 0;
            //         var price = parseFloat(row.find('.price').val()) || 0;
            //         var discount = parseFloat(row.find('.discount').val()) || 0;

            //         var subTotal = quantity * price * (1 - discount / 100);
            //         row.find('.sub-total').val(subTotal.toFixed(2));
            //     }

            //     function updateGrandTotal() {
            //         var grandTotal = 0;

            //         $('#products_table tbody tr').each(function () {
            //             grandTotal += parseFloat($(this).find('.sub-total').val()) || 0;
            //         });

            //         var discount = parseFloat($('#discount').val()) || 0;
            //         grandTotal *= (1 - discount / 100);

            //         $('#grand_total').text("₦" + grandTotal.toFixed(2));
            //     }
            // });


            $(document).ready(function () {
                $('#product_selector').change(function () {
                    var productId = $(this).val();
                    var productName = $(this).find('option:selected').text();
                    var productPrice = $(this).find('option:selected').data('price');
                    

                    if (productId) {
                        // Add a new row with product details
                        var newRow = $('<tr>');
                        newRow.append('<td><input class="form-control" type="text" name="products[' + productId + '][product_name]" value="' + productName + '" readonly /></td>');
                        newRow.append('<td><input class="form-control quantity" type="number" name="products[' + productId + '][quantity]" value="1" /></td>');
                        newRow.append('<td><input class="form-control price" type="text" name="products[' + productId + '][price]" value="' + productPrice + '" readonly /></td>');
                        newRow.append('<td><input class="form-control discount" type="number" name="products[' + productId + '][discount]" value="0" readonly /></td>');
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
