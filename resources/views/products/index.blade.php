@extends('layouts.main') 
@section('title', 'Products')
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
                            <h5>{{ __('Products')}}</h5>
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
                            <a href="{{ route('products.index', ['type' => 1]) }}" class="btn btn-outline-warning p-2 mr-5">{{ __('Book Products')}}</a>
                            <a href="{{ route('products.index', ['type' => 2]) }}" class="btn btn-outline-success p-2 mr-5">{{ __('Non-book Products')}}</a>
                            <button type="button" class="btn btn-outline-primary p-2 mr-10" data-toggle="modal" data-target="#addNewModal">{{ __('Add New Product')}}</button>
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

                        <table id="data_table" class="table">
                            <thead>
                                <tr>
                                    <th>{{ __('ID') }}</th>
                                    <th>{{ __('Image') }}</th>
                                    <th>{{ __('Name') }}</th>
                                    <th>{{ __('Author') }}</th>
                                    <th>{{ __('ISBN') }}</th>
                                    <th>{{ __('Price') }}</th>
                                    <th>{{ __('Category') }}</th>
                                    <th>{{ __('Stock') }}</th>
                                    <th>{{ __('Actions') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($products as $product)
                                    <tr>
                                        <td>{{ $settings->product_prefix }}{{ $product->id }}</td>
                                        <td>
                                            <div class="d-inline-block align-middle">
                                               
                                                 <img src="{{ asset($product->image ? 'storage/' . $product->image : 'storage/product_images/no-image.png') }}" alt="" class="rounded img-40 align-top mr-15">
                                                {{-- <div class="d-inline-block">
                                                    <h6>{{ $settings->currency_symbol }}{{ number_format($product->price) }}</h6>
                                                    <p class="text-muted mb-0">{{ $settings->currency_symbol }}{{ number_format($product->price) }}</p>
                                                </div> --}}
                                            </div>
                                        </td>
                                        <td>{{ $product->name }}</td>
                                        <td>{{ $product->author }}</td>
                                        <td>{{ $product->ISBN }}</td>
                                        <td>{{ $settings->currency_symbol }}{{ number_format($product->price) }}</td>
                                        <td>{{ $product->category->name }}</td>
                                        <td>
                                            @if ($product->stock > $product->alert_quantity)
                                                <span class="badge badge-success">{{ $product->stock }}</span>
                                            @else
                                                <span class="badge badge-danger">{{ $product->stock }}</span>
                                            @endif
                                        </td>
                                        
                                        <td>
                                            <div class="table-actions row">
                                                {{-- <a href="#"><i class="ik ik-eye text-blue"></i></a> --}}
                                                <a href="{{ route('products.edit', $product->id) }}"><i class="ik ik-edit f-16 text-green"></i></a>
                                                <a href="#" data-toggle="modal" data-target="#deleteModal{{ $product->id }}"><i class="ik ik-trash-2 f-16 text-red"></i></a>
                                               
                                            </div>
                                        </td>
                                    </tr>


                                    <!-- Delete Modal -->
                                    <div class="modal fade" id="deleteModal{{ $product->id }}" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="deleteModalLabel">Confirm Delete</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    Are you sure you want to delete this product?
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
                                                    <form action="{{ route('products.destroy', $product->id) }}" method="POST">
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

                        {{ $products->links() }}

                        
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
                        <div class="row">
                            <div class="col-sm-8">

                                <div class="form-group">
                                    <label for="name">Product Title/Name<span class="text-red">*</span></label>
                                    <input id="name" type="text" class="form-control" name="name" value="" placeholder="Enter product title" required="">
                                    <div class="help-block with-errors"></div>
                                </div>

                                <div class="form-group">
                                    <label>Description</label>
                                    <textarea class="form-control html-editor h-205" id="product_description" name="description" rows="10"></textarea>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Product Image</label>
                                            {{-- <div class="input-images" data-input-name="product-images" data-label="Drag & Drop product images here or click to browse"></div> --}}
                                            <input type="file" class="form-control-file" id="productImage" name="image">
                                            <img id="preview" src="#" alt="image" height="50" width="50" class="img-thumbnail responsive border-0 mt-3" style="display:none;"/>
                                        </div>
                                    </div>
    
    
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="store">{{ __('Store')}}</label>
                                            <select class="form-control" id="store" name="store_id">
                                                @foreach($stores as $store)
                                                    <option value="{{ $store->id }}">{{ $store->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>


                            </div>
                            <div class="col-sm-4">

                                <div class="form-group">
                                    <label for="category">{{ __('Category')}}<span class="text-red">*</span></label>
                                    <select class="form-control" id="category" name="category_id" required>
                                        <option value="">--------</option>
                                        @foreach($categories as $category)
                                            @if(!$category->parent_category_id || in_array($category->id, [1, 2]))
                                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="subcategory">{{ __('Subcategory')}}</label>
                                    <select class="form-control" id="subcategory" name="subcategory_id" disabled>
                                        <!-- Subcategories will be populated dynamically using JavaScript -->
                                    </select>
                                </div>

                                {{-- <div class="form-group">
                                    <label for="sku">SKU<span class="text-red">*</span></label>
                                    <input id="sku" type="text" class="form-control" name="sku" value="" placeholder="Enter Product SKU" required="">
                                    <div class="help-block with-errors"></div>
                                </div> --}}

                                <div class="form-group">
                                    <label for="product_stock">{{ __('Qty')}}<span class="text-red">*</span></label>
                                    <input type="number" class="form-control" id="product_stock" name="stock" placeholder="Stock Quantity" required>
                                </div>

                                <div class="form-group">
                                    <label for="product_alert_quantity">{{ __('Stock Alert')}}<span class="text-red">*</span></label>
                                    <input type="number" class="form-control" id="product_alert_quantity" name="alert_quantity" placeholder="Alert Quantity">
                                </div>

                                <div class="form-group">
                                    <label for="product_price">{{ __('Price')}} <span class="text-red">*</span></label>
                                    <input type="text" class="form-control" id="product_price" name="price" placeholder="Enter product price" required>
                                </div>

                                <div class="form-group">
                                    <label for="product_author">{{ __('Author')}}</label>
                                    <input type="text" class="form-control" id="product_author" name="author" placeholder="Author">
                                </div>
                                <div class="form-group">
                                    <label for="product_isbn">{{ __('ISBN')}}</label>
                                    <input type="text" class="form-control" id="product_isbn" name="ISBN" placeholder="ISBN">
                                </div>

                            </div>
                            {{-- <div class="col-sm-3">

                                <div class="form-group">

                                    <label>Select Categories</label>
                                    <div class="border-checkbox-section ml-3">
                                        <div class="border-checkbox-group border-checkbox-group-success d-block">
                                            <input class="border-checkbox" type="checkbox" id="checkbox1" value="1">
                                            <label class="border-checkbox-label" for="checkbox1">Electronics</label>
                                        </div>
                                        <div class="border-checkbox-group border-checkbox-group-success d-block">
                                            <input class="border-checkbox" type="checkbox" id="checkbox2" value="2">
                                            <label class="border-checkbox-label" for="checkbox2">Computers</label>
                                        </div>
                                        <div class="border-checkbox-group border-checkbox-group-success d-block">
                                            <input class="border-checkbox" type="checkbox" id="checkbox3" value="3">
                                            <label class="border-checkbox-label" for="checkbox3">Smart Home</label>
                                        </div>
                                        <div class="border-checkbox-group border-checkbox-group-success d-block">
                                            <input class="border-checkbox" type="checkbox" id="checkbox4" value="4">
                                            <label class="border-checkbox-label" for="checkbox4">Arts &amp; Crafts</label>
                                        </div>
                                        <div class="border-checkbox-group border-checkbox-group-success d-block">
                                            <input class="border-checkbox" type="checkbox" id="checkbox5" value="5">
                                            <label class="border-checkbox-label" for="checkbox5">Fashion</label>
                                        </div>
                                        <div class="border-checkbox-group border-checkbox-group-success d-block">
                                            <input class="border-checkbox" type="checkbox" id="checkbox6" value="6">
                                            <label class="border-checkbox-label" for="checkbox6">Baby</label>
                                        </div>
                                        <div class="border-checkbox-group border-checkbox-group-success d-block">
                                            <input class="border-checkbox" type="checkbox" id="checkbox7" value="7">
                                            <label class="border-checkbox-label" for="checkbox7">Health &amp; Care</label>
                                        </div>
                                        <div class="border-checkbox-group border-checkbox-group-success d-block">
                                            <input class="border-checkbox" type="checkbox" id="checkbox8" value="8">
                                            <label class="border-checkbox-label" for="checkbox8">Others</label>
                                        </div>
                                        <div class="border-checkbox-group border-checkbox-group-success d-block">
                                            <input class="border-checkbox" type="checkbox" id="checkbox9" value="9">
                                            <label class="border-checkbox-label" for="checkbox9">Mobile Accesories</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label>Shiping</label>
                                    <div class="border-checkbox-section ml-3">
                                        <div class="border-checkbox-group border-checkbox-group-success d-block">
                                            <input class="border-checkbox" type="checkbox" id="checkboxfree" value="free">
                                            <label class="border-checkbox-label" for="checkboxfree">Free Shipping</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="tax_type">Tax Type<span class="text-red">*</span></label>
                                    <select name="tax_type" class="form-control">
                                        <option>Select</option>
                                        <option value="Inclusive">Inclusive</option>
                                        <option value="Exclusive">Exclusive</option>
                                    </select>
                                    <div class="help-block with-errors"></div>
                                </div>
                                <div class="form-group">
                                    <label for="input">Product Tag</label>
                                    <input type="text" id="tags" class="form-control h-100" value="">
                                </div>
                                <div class="form-group text-right">
                                    <button type="submit" class="btn btn-primary">Save</button>
                                </div>
                            </div> --}}
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('Close')}}</button>
                        <button type="submit" class="btn btn-primary btn-block">{{ __('Save')}}</button>
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

        <script>
            productImage.onchange = evt => {
                preview = document.getElementById('preview');
                preview.style.display = 'block';
                const [file] = productImage.files
                if (file) {
                    preview.src = URL.createObjectURL(file)
                }
            }
        </script>

    @endpush

@endsection
