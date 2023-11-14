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
                            <span>{{ __('Add, view and manage sales records')}} </span>
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
                                <a href="#">{{ __('Sales')}}</a>
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
                                    <th>{{ __('Action') }}</th>
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
                                    <th>{{ __('Added By') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($sales as $sale)
                                    <tr>
                                        <td>
                                            <button type="button" class="btn btn-outline-dark btn-xs dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">{{ __('Actions')}} <i class="ik ik-chevron-down"></i></button>
                                            <div class="dropdown-menu">
                                                <a class="dropdown-item" href="#">{{ __('View')}}</a>
                                                <a class="dropdown-item" data-toggle="modal" data-target="#editNewModal{{ $sale->id}}" href="#">{{ __('Edit')}}</a>
                                                <a class="dropdown-item" data-toggle="modal" data-target="#deleteModal{{ $sale->id }}" href="#">{{ __('Delete')}}</a>
                                                <div role="separator" class="dropdown-divider"></div>
                                                <a class="dropdown-item" data-toggle="modal" data-target="#invoiceModal{{ $sale->id }}" href="#">{{ __('Ivoice')}}</a>
                                                <a class="dropdown-item" data-toggle="modal" data-target="#packingSlipModal{{ $sale->id }}" href="#">{{ __('Packing Slip')}}</a>
                                                {{-- <a class="dropdown-item" href="{{ url('sales') }}">{{ __('Payments')}}</a> --}}
                                            </div>
                                        </td>
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
                                        <td>{{ $sale->addedBy->name }}</td>
                                    </tr>


                                    <div class="modal fade" id="editNewModal{{ $sale->id }}" tabindex="-1" role="dialog" aria-labelledby="demoModalLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-lg" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="demoModalLabel">{{ __('Add New Sale')}}</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                </div>
                                                
                                
                                                <form class="forms-sample" action="{{ route('sales.update', $sale->id) }}" method="POST">
                                                    @csrf
                                                    @method('PUT')

                                                    <div class="modal-body">
                                                        <div class="row">
                                                            @if ($errors->any())
                                                                <div class="alert alert-danger">
                                                                    <ul>
                                                                        @foreach ($errors->all() as $error)
                                                                            <li>{{ $error }}</li>
                                                                        @endforeach
                                                                    </ul>
                                                                </div>
                                                            @endif

                                                        </div>
                                                        
                                                        <div class="row">
                                                            <div class="col-md-4">
                                                                <div class="form-group">
                                                                    <label for="invoice_number">{{ __('Invoice Number')}}</label>
                                                                    <input value="{{ $sale->invoice_number }}" type="text" class="form-control" id="invoice_number" name="invoice_number">
                                                                </div>
                                                            </div>


                                                            <div class="col-md-4">
                                                                <div class="form-group">
                                                                    <label for="date">{{ __('Date')}}</label>
                                                                    <input value="{{ date('d/m/Y', strtotime($sale->date)) }}" type="date" class="form-control" id="date" name="date" required>
                                                                </div>
                                                            </div>


                                                            <div class="col-md-4">
                                                                <div class="form-group">
                                                                    <label for="invoice_number">{{ __('Customer Name')}}</label>                                    
                                                                    <select class="form-control" id="customer_name" name="customer_name" required>
                                                                        @foreach($customers as $customer)
                                                                            <option value="{{ $customer->contact_name }}">{{ $customer->contact_name }}</option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                            </div>
                                
                                                            <div class="col-md-4">
                                                                <div class="form-group">
                                                                    <label for="phone_number">{{ __('Contact Number')}}</label>
                                                                    <input value="{{ $sale->phone_number }}" type="text" class="form-control" id="phone_number" name="phone_number" placeholder="Phone Number" required>
                                                                </div>
                                                            </div>
                                
                                
                                                            <div class="col-md-4">
                                                                <div class="form-group">
                                                                    <label for="store">{{ __('Store')}}</label>
                                                                    <select class="form-control" id="store" name="store" required>
                                                                        @foreach($stores as $store)
                                                                            <option value="{{ $store->name }}">{{ $store->name }}</option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                            </div>
                                
                                                            <div class="col-md-4">
                                                                <div class="form-group">
                                                                    <label for="payment_status">{{ __('Payment Status')}}</label>
                                                                    <select class="form-control" id="payment_status" name="payment_status" required>
                                                                        @foreach($paymentStatuses as $status)
                                                                            <option value="{{ $status->id }}">{{ $status->name }}</option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                            </div>
                                
                                                            <div class="col-md-4">
                                                                <div class="form-group">
                                                                    <label for="payment_method">{{ __('Payment Method')}}</label>
                                                                    <select class="form-control" id="payment_method" name="payment_method" required>
                                                                        @foreach($paymentMethods as $method)
                                                                            <option value="{{ $method->id }}">{{ $method->name }}</option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                            </div>
                                
                                                            <div class="col-md-4">
                                                                <div class="form-group">
                                                                    <label for="sale_status">{{ __('Sale Status')}}</label>
                                                                    <select class="form-control" id="sale_status" name="sale_status" required>
                                                                        @foreach($saleStatuses as $saleStatus)
                                                                            <option value="{{ $saleStatus->id }}">{{ $saleStatus->name }}</option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                            </div>
                                
                                                            <div class="col-md-4">
                                                                <div class="form-group">
                                                                    <label for="total_amount">{{ __('Total Amount')}}</label>
                                                                    <input value="{{ $sale->total_amount }}" type="number" class="form-control" id="total_amount" name="total_amount" placeholder="Total Amount" required>
                                                                </div>
                                                            </div>
                                
                                                            <div class="col-md-4">
                                                                <div class="form-group">
                                                                    <label for="total_paid">{{ __('Total Paid')}}</label>
                                                                    <input value="{{ $sale->total_paid }}" type="number" class="form-control" id="total_paid" name="total_paid" placeholder="Total Paid" required>
                                                                </div>
                                                            </div>
                                
                                                            <div class="col-md-4">
                                                                <div class="form-group">
                                                                    <label for="total_items">{{ __('Total Items')}}</label>
                                                                    <input value="{{ $sale->total_items }}" type="number" class="form-control" id="total_items" name="total_items" placeholder="Total Items" required>
                                                                </div>
                                                            </div>

                                                            <div class="col-md-4">
                                                                <div class="form-group">
                                                                    <label for="added_by">{{ __('Added By')}}</label>
                                                                    <select class="form-control" id="added_by" name="added_by" required>
                                                                        @foreach($users as $user)
                                                                            <option value="{{ $user->id }}">{{ $user->name }}</option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                            </div>
                                
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
                                                
                                                
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('Close')}}</button>
                                                            <button type="submit" class="btn btn-primary">{{ __('Save')}}</button>
                                                        </div>
                                                    </div>
                                                </form>
                                                
                                            </div>
                                        </div>
                                    </div>


                                    <!-- Delete Modal -->
                                    <div class="modal fade" id="deleteModal{{ $sale->id }}" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="deleteModalLabel">Confirm Delete</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    Are you sure you want to delete this sale?
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
                                                    <form action="{{ route('sales.destroy', $sale->id) }}" method="POST">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger">Yes, Delete</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>


                                @endforeach
                            </tbody>
                        </table>
                        
                        {{ $sales->links() }}
                        
                    </div>
                </div>
            </div>
        </div>

    </div>


    <div class="modal fade" id="addNewModal" tabindex="-1" role="dialog" aria-labelledby="demoModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="demoModalLabel">{{ __('Add New Sale')}}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
                

                <form class="forms-sample" action="{{ route('sales.store') }}" method="POST">
                    @csrf

                    {{-- @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif --}}

                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="date">{{ __('Date')}}</label>
                                    <input type="date" class="form-control" id="date" name="date" required>
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="invoice_number">{{ __('Customer Name')}}</label>                                    
                                    <select class="form-control" id="customer_name" name="customer_name" required>
                                        @foreach($customers as $customer)
                                            <option value="{{ $customer->contact_name }}">{{ $customer->contact_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="phone_number">{{ __('Contact Number')}}</label>
                                    <input type="text" class="form-control" id="phone_number" name="phone_number" placeholder="Phone Number" required>
                                </div>
                            </div>


                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="store">{{ __('Store')}}</label>
                                    <select class="form-control" id="store" name="store" required>
                                        @foreach($stores as $store)
                                            <option value="{{ $store->name }}">{{ $store->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="payment_status">{{ __('Payment Status')}}</label>
                                    <select class="form-control" id="payment_status" name="payment_status" required>
                                        @foreach($paymentStatuses as $status)
                                            <option value="{{ $status->id }}">{{ $status->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="payment_method">{{ __('Payment Method')}}</label>
                                    <select class="form-control" id="payment_method" name="payment_method" required>
                                        @foreach($paymentMethods as $method)
                                            <option value="{{ $method->id }}">{{ $method->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="sale_status">{{ __('Sale Status')}}</label>
                                    <select class="form-control" id="sale_status" name="sale_status" required>
                                        @foreach($saleStatuses as $saleStatus)
                                            <option value="{{ $saleStatus->id }}">{{ $saleStatus->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-4">
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
                            </div>

                        </div>
                        {{-- <div class="form-group">
                            <label for="invoice_number">{{ __('Invoice Number')}}</label>
                            <input type="text" class="form-control" id="invoice_number" name="invoice_number" placeholder="Invoice Number" required>
                        </div> --}}
                
        
                
                        
                
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
