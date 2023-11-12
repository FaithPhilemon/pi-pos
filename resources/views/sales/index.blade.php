@extends('layouts.main') 
@section('title', 'Sales')
@section('content')

 <!-- push external head elements to head -->
 @push('head')
 <link rel="stylesheet" href="{{ asset('plugins/DataTables/datatables.min.css') }}">
@endpush
    <div class="container-fluid">
        <div class="page-header">
            <div class="row align-items-end">
                <div class="col-lg-8">
                    <div class="page-header-title">
                        <i class="ik ik-layers bg-blue"></i>
                        <div class="d-inline">
                            <h5>{{ __('Sales')}}</h5>
                            <span>{{ __('Manage products, categories and add new')}} </span>
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
                                <a href="#">{{ __('Products')}}</a>
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
                            <h3 class="mr-auto p-2">{{$pageTitle}}</h3>
                            {{-- <a href="{{ route('products.index', ['type' => 1]) }}" class="btn btn-outline-warning p-2 mr-5">{{ __('Book Products')}}</a>
                            <a href="{{ route('products.index', ['type' => 2]) }}" class="btn btn-outline-success p-2 mr-5">{{ __('Non-book Products')}}</a> --}}
                            <button type="button" class="btn btn-outline-primary p-2 mr-10" data-toggle="modal" data-target="#addNewModal">{{ __('Add Sale')}}</button>
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

                        <table id="data_table" class="table table-responsive">
                            <thead>
                                <tr>
                                    <th>{{ __('Date') }}</th>
                                    <th>{{ __('Invoice Number') }}</th>
                                    <th>{{ __('Customer Name') }}</th>
                                    <th>{{ __('Contact Number') }}</th>
                                    <th>{{ __('Store') }}</th>
                                    <th>{{ __('Sale Status') }}</th>
                                    <th>{{ __('Payment Status') }}</th>
                                    <th>{{ __('Payment Method') }}</th>
                                    <th>{{ __('Total Amount') }}</th>
                                    <th>{{ __('Total Paid') }}</th>
                                    <th>{{ __('Total Items') }}</th>
                                    {{-- <th>{{ __('Shipping Status') }}</th> --}}
                                    <th>{{ __('Added By') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($sales as $sale)
                                    <tr>
                                        <td>{{ date('d/m/Y', strtotime($sale->date)) }}</td>
                                        <td>{{ $settings->invoice_prefix }}{{ $sale->invoice_number }}</td>
                                        <td>{{ $sale->customer_name }}</td>
                                        <td>{{ $sale->phone_number }}</td>
                                        <td>{{ $sale->store }}</td>
                                        <td>
                                            @switch($sale->sale_status_id)
                                                @case(1)
                                                    <span class="badge badge-danger">{{ $sale->saleStatus->name }}</span>
                                                    @break

                                                @case(2)
                                                    <span class="badge badge-warning">{{ $sale->saleStatus->name }}</span>
                                                    @break

                                                @case(3)
                                                    <span class="badge badge-success">{{ $sale->saleStatus->name }}</span>
                                                    @break

                                                @case(4)
                                                    <span class="badge badge-primary">{{ $sale->saleStatus->name }}</span>
                                                    @break
                                                @default
                                                <span class="badge badge-secondary">N/A</span>
                                            @endswitch
                                            
                                        </td>
                                        <td>
                                            @switch($sale->payment_status_id)
                                                @case(1)
                                                    <span class="badge badge-danger">{{ $sale->paymentStatus->name }}</span>
                                                    @break

                                                @case(2)
                                                    <span class="badge badge-success">{{ $sale->paymentStatus->name }}</span>
                                                    @break

                                                @case(3)
                                                    <span class="badge badge-warning">{{ $sale->paymentStatus->name }}</span>
                                                    @break

                                                @case(4)
                                                    <span class="badge badge-secondary">{{ $sale->paymentStatus->name }}</span>
                                                    @break
                                                @default
                                                    <span class="badge badge-dark">N/A</span>
                                            @endswitch
                                        </td>
                                        <td>{{ $sale->paymentMethod->name }}</td>
                                        <td>{{ $settings->currency_symbol }}{{ number_format($sale->total_amount) }}</td>
                                        <td>{{ $settings->currency_symbol }}{{ number_format($sale->total_paid) }}</td>
                                        <td>{{ $sale->total_items }}</td>
                                        {{-- <td>{{ $sale->shippingStatus->name }}</td> --}}
                                        <td>{{ $sale->addedBy->name }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        
                        
                    </div>
                </div>
            </div>
        </div>

    </div>


    <div class="modal fade" id="addNewModal" tabindex="-1" role="dialog" aria-labelledby="demoModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="demoModalLabel">{{ __('Add New Product')}}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
                

                <form class="forms-sample" action="{{ route('sales.store') }}" method="POST">
                    @csrf

                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <div class="modal-body">
                        <div class="form-group">
                            <label for="invoice_number">{{ __('Invoice Number')}}</label>
                            <input type="text" class="form-control" id="invoice_number" name="invoice_number" placeholder="Invoice Number" required>
                        </div>
                
                        <div class="form-group">
                            <label for="date">{{ __('Date')}}</label>
                            <input type="date" class="form-control" id="date" name="date" required>
                        </div>
                
                        <div class="form-group">
                            <label for="invoice_number">{{ __('Customer Name')}}</label>
                            <input type="text" class="form-control" id="customer_name" name="customer_name" placeholder="Customer Name" required>
                        </div>
                
                        <div class="form-group">
                            <label for="contact_number">{{ __('Contact Number')}}</label>
                            <input type="text" class="form-control" id="contact_number" name="contact_number" placeholder="Contact Number" required>
                        </div>
                
                        <div class="form-group">
                            <label for="store">{{ __('Store')}}</label>
                            <select class="form-control" id="store" name="store" required>
                                @foreach($stores as $store)
                                    <option value="{{ $store->id }}">{{ $store->name }}</option>
                                @endforeach
                            </select>
                        </div>
                
                        <div class="form-group">
                            <label for="payment_status">{{ __('Payment Status')}}</label>
                            <select class="form-control" id="payment_status" name="payment_status" required>
                                @foreach($paymentStatuses as $status)
                                    <option value="{{ $status->id }}">{{ $status->name }}</option>
                                @endforeach
                            </select>
                        </div>
                
                        <div class="form-group">
                            <label for="payment_method">{{ __('Payment Method')}}</label>
                            <select class="form-control" id="payment_method" name="payment_method" required>
                                @foreach($paymentMethods as $method)
                                    <option value="{{ $method->id }}">{{ $method->name }}</option>
                                @endforeach
                            </select>
                        </div>
                
                        <div class="form-group">
                            <label for="total_amount">{{ __('Total Amount')}}</label>
                            <input type="text" class="form-control" id="total_amount" name="total_amount" placeholder="Total Amount" required>
                        </div>
                
                        <div class="form-group">
                            <label for="total_paid">{{ __('Total Paid')}}</label>
                            <input type="text" class="form-control" id="total_paid" name="total_paid" placeholder="Total Paid" required>
                        </div>
                
                        <div class="form-group">
                            <label for="total_items">{{ __('Total Items')}}</label>
                            <input type="number" class="form-control" id="total_items" name="total_items" placeholder="Total Items" required>
                        </div>
                
                        <div class="form-group">
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
                        </div>
                
                        <div class="form-group">
                            <label for="added_by">{{ __('Added By')}}</label>
                            <input type="text" class="form-control" id="added_by" name="added_by" placeholder="Added By" required>
                        </div>
                
                        <!-- Other input fields for the form -->
                
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('Close')}}</button>
                            <button type="submit" class="btn btn-primary">{{ __('Save')}}</button>
                        </div>
                    </div>
                </form>
                
            </div>
        </div>
    </div>


   

    

    <!-- push external js -->
    @push('script')
        {{-- <script src="{{ asset('src/js/vendor/jquery-3.3.1.min.js') }}"></script> --}}

        <script src="{{ asset('plugins/DataTables/datatables.min.js') }}"></script>
        <script src="{{ asset('js/datatables.js') }}"></script>


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
    @endpush

@endsection
