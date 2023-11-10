@extends('layouts.main') 
@section('title', 'Edit Product')
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
                            <h5>{{ __('Edit Products')}}</h5>
                            <span>{{ __('Edit')}} </span>
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
                                <a href="#">{{ __('Product')}}</a>
                            </li>

                            <li class="breadcrumb-item">
                                <a href="#">{{ __('Edit')}}</a>
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
    	        
                    <div class="card-header d-flex justify-content-between">
                            <h3>{{ __('Edit')}} "{{ $product->name }}"</h3>
                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addNewModal">{{ __('Add New Product')}}</button>
                    </div>
                    <div class="card-body">


                        <form class="forms-sample" action="{{ route('products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT') <!-- Use PUT method for updates -->
                        
                            
                                @if ($errors->any())
                                    <div class="alert alert-danger">
                                        <ul>
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif
                        
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="store">{{ __('Store')}}</label>
                                            <select class="form-control" id="store" name="store_id">
                                                @foreach($stores as $store)
                                                    <option value="{{ $store->id }}" {{ $product->store_id == $store->id ? 'selected' : '' }}>
                                                        {{ $store->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                        
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="category">{{ __('Category')}}</label>
                                            <select class="form-control" id="category" name="category_id" required>
                                                <option value="">--------</option>
                                                @foreach($categories as $category)
                                                    @if(!$category->sub_category_id || in_array($category->id, [1, 2]))
                                                        <option value="{{ $category->id }}" {{ $product->category_id == $category->id ? 'selected' : '' }}>
                                                            {{ $category->name }}
                                                        </option>
                                                    @endif
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                        
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="subcategory">{{ __('Subcategory')}}</label>
                                            <select class="form-control" id="subcategory" name="subcategory_id" disabled>
                                                <!-- Subcategories will be populated dynamically using JavaScript -->
                                            </select>
                                        </div>
                                    </div>
                                </div>
                        
                        
                                <div class="form-group">
                                    <label for="product_name">{{ __('Name')}}</label>
                                    <input type="text" value="{{ old('name', $product->name) }}" class="form-control" id="product_name" name="name" placeholder="Name" required>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="product_author">{{ __('Author')}}</label>
                                            <input type="text" value="{{ old('author', $product->author) }}" class="form-control" id="product_author" name="author" placeholder="Author">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="product_isbn">{{ __('ISBN')}}</label>
                                            <input type="text" value="{{ old('ISBN', $product->ISBN) }}" class="form-control" id="product_isbn" name="ISBN" placeholder="ISBN">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="product_description">{{ __('Description')}}</label>
                                    <textarea class="form-control" id="product_description" name="description" rows="4">
                                        {{ old('description', $product->description) }}
                                    </textarea>
                                </div>

                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="product_stock">{{ __('Stock Quantity')}}</label>
                                            <input type="number" value="{{ old('stock', $product->stock) }}" class="form-control" id="product_stock" name="stock" placeholder="Stock" required>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="product_alert_quantity">{{ __('Alert Quantity')}}</label>
                                            <input type="number" value="{{ old('alert_quantity', $product->alert_quantity) }}" class="form-control" id="product_alert_quantity" name="alert_quantity" placeholder="Alert Quantity">
                                        </div>
                                    </div>
        
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="product_price">{{ __('Price')}}</label>
                                            <input type="text" value="{{ old('price', $product->price) }}" class="form-control" id="product_price" name="price" placeholder="Price" required>
                                        </div>
                                    </div>
        
                                </div>
                                
                                <div class="form-group">
                                    <label for="product_image">{{ __('Product Image')}}</label>
                                    <input type="file" class="form-control-file" id="product_image" name="image">
                                </div>
                    
                            
                        
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('Close')}}</button>
                                <button type="submit" class="btn btn-primary">{{ __('Update')}}</button>
                            </div>
                        </form>
                        
                        
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
                <form class="forms-sample" action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="store">{{ __('Store')}}</label>
                                    <select class="form-control" id="store" name="store_id">
                                        @foreach($stores as $store)
                                            <option value="{{ $store->id }}">{{ $store->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="category">{{ __('Category')}}</label>
                                    <select class="form-control" id="category" name="category_id" required>
                                        <option value="">--------</option>
                                        @foreach($categories as $category)
                                            @if(!$category->sub_category_id || in_array($category->id, [1, 2]))
                                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="subcategory">{{ __('Subcategory')}}</label>
                                    <select class="form-control" id="subcategory" name="subcategory_id" disabled>
                                        <!-- Subcategories will be populated dynamically using JavaScript -->
                                    </select>
                                </div>
                            </div>
                        </div>
                    
                        <div class="form-group">
                            <label for="product_name">{{ __('Name')}}</label>
                            <input type="text" class="form-control" id="product_name" name="name" placeholder="Name" required>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="product_author">{{ __('Author')}}</label>
                                    <input type="text" class="form-control" id="product_author" name="author" placeholder="Author">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="product_isbn">{{ __('ISBN')}}</label>
                                    <input type="text" class="form-control" id="product_isbn" name="ISBN" placeholder="ISBN">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="product_description">{{ __('Description')}}</label>
                            <textarea class="form-control" id="product_description" name="description" rows="4"></textarea>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="product_stock">{{ __('Stock Quantity')}}</label>
                                    <input type="number" class="form-control" id="product_stock" name="stock" placeholder="Stock" required>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="product_alert_quantity">{{ __('Alert Quantity')}}</label>
                                    <input type="number" class="form-control" id="product_alert_quantity" name="alert_quantity" placeholder="Alert Quantity">
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="product_price">{{ __('Price')}}</label>
                                    <input type="text" class="form-control" id="product_price" name="price" placeholder="Price" required>
                                </div>
                            </div>

                        </div>
                        
                        <div class="form-group">
                            <label for="product_image">{{ __('Product Image')}}</label>
                            <input type="file" class="form-control-file" id="product_image" name="image">
                        </div>
                       
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('Close')}}</button>
                        <button type="submit" class="btn btn-primary">{{ __('Save')}}</button>
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