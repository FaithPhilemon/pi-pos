@extends('layouts.main') 
@section('title', 'Categories')
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
                            <h5>{{ __('Product Catgories')}}</h5>
                            <span>{{ __('Add and manage product categories and sub categories')}} </span>
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
                                <a href="{{url('products')}}">{{ __('Products')}}</a>
                            </li>
                            <li class="breadcrumb-item">
                                <a href="#">{{ __('Categories')}}</a>
                            </li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>

        <div class="row">
            @include('include.message')
            <div class="col-md-8">
                <div class="card">
    	        
                    <div class="card-header d-flex">
                        {{-- <h3 class="mr-auto p-2">Categories/Gropus List</h3> --}}
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

                        
                       
                        <h3 class="mr-auto p-2">Categories</h3>

                        <table class="table">
                            <thead>
                                <tr>
                                    <th>{{ __('ID') }}</th>
                                    <th>{{ __('Name') }}</th>
                                    <th>{{ __('Code') }}</th>
                                    <th>{{ __('Actions') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($categories as $category)
                                    @if(!$category->sub_category_id || in_array($category->id, [1, 2]))
                                        <tr>
                                            <td>{{ $category->id }}</td>
                                            <td>{{ $category->name }}</td>
                                            <td>{{ $category->code }}</td>
                                            <td>
                                                <div class="table-actions row">
                                                    <a href="#" data-toggle="modal" data-target="#editModal{{ $category->id }}"><i class="ik ik-edit f-16 text-green"></i></a>
                                                    {{-- <a href="#" data-toggle="modal" data-target="#deleteModal{{ $category->id }}"><i class="ik ik-trash-2 f-16 text-red"></i></a> --}}
                                                </div>
                                            </td>
                                        </tr>
                                    @endif
                                    

                                    <!-- Edit Modal -->
                                    <div class="modal fade" id="editModal{{ $category->id }}" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="eidtModalLabel">Edit Category</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <form class="forms-sample" action="{{ route('categories.update') }}" method="POST" enctype="multipart/form-data">
                                                        @csrf
                                                        <div class="modal-body">
                                                        
                                                            <div class="form-group">
                                                                <label for="product_name">{{ __('Name')}}</label>
                                                                <input type="text" value="{{ $category->name }}" class="form-control" id="name" name="name" placeholder="Category Name" required>
                                                            </div>

                                                            <div class="form-group">
                                                                <label for="code">{{ __('Code')}}</label>
                                                                <input type="text" value="{{ $category->code }}" class="form-control" id="code" name="code" placeholder="Category Code" required>
                                                            </div>
                            
                                                            <button type="submit" class="btn btn-primary">{{ __('Update')}}</button>
                                                            
                                                        </div>
                                                        
                                                    </form>
                                                </div>
                                                {{-- <div class="modal-footer">
                                                </div> --}}
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Delete Modal -->
                                    <div class="modal fade" id="deleteModal{{ $category->id }}" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="deleteModalLabel">Confirm Delete</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    Are you sure you want to delete this category?
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
                                                    <form action="{{ route('products.destroy', $category->id) }}" method="POST">
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


                        <hr>
                        <h3 class="mr-auto p-2 mt-20">Sub-Categories</h3>

                        <table id="data_table" class="table">
                            <thead>
                                <tr>
                                    <th>{{ __('ID') }}</th>
                                    <th>{{ __('Name') }}</th>
                                    <th>{{ __('Code') }}</th>
                                    <th>{{ __('Actions') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($categories as $category)
                                    @if(!in_array($category->id, [1, 2]))
                                        <tr>
                                            <td>{{ $category->id }}</td>
                                            <td>{{ $category->name }}</td>
                                            <td>{{ $category->code }}</td>
                                            <td>
                                                <div class="table-actions row">
                                                    <a href="#" data-toggle="modal" data-target="#editModal{{ $category->id }}"><i class="ik ik-edit f-16 text-green"></i></a>
                                                    {{-- <a href="#" data-toggle="modal" data-target="#deleteModal{{ $category->id }}"><i class="ik ik-trash-2 f-16 text-red"></i></a> --}}
                                                </div>
                                            </td>
                                        </tr>
                                    @endif
                                    

                                    <!-- Edit Modal -->
                                    {{-- <div class="modal fade" id="editModal{{ $category->id }}" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="eidtModalLabel">Edit Category</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    
                                                </div>
                                              
                                            
                                            </div>
                                        </div>
                                    </div> --}}

                                    <!-- Delete Modal -->
                                    {{-- <div class="modal fade" id="deleteModal{{ $category->id }}" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="deleteModalLabel">Confirm Delete</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    Are you sure you want to delete this category?
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
                                                    <form action="{{ route('products.destroy', $category->id) }}" method="POST">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger">Yes, Delete</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div> --}}
                                @endforeach
                            </tbody>

                        </table>
                        
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card">
    	        


                    <div class="card-header d-flex">
                        {{-- <h3 class="mr-auto p-2">Add New Categories</h3> --}}
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


                        <h3 class="mr-auto p-2">Add Category</h3>

                        <form class="forms-sample" action="{{ route('categories.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            
                            <div class="form-group">
                                <label for="product_name">{{ __('Name')}}</label>
                                <input type="text" class="form-control" id="name" name="name" placeholder="Category Name" required>
                            </div>

                            <div class="form-group">
                                <label for="code">{{ __('Code')}}</label>
                                <input type="text" class="form-control" id="code" name="code" placeholder="Category Code">
                            </div>

                            <button type="submit" class="btn btn-primary">{{ __('Save')}}</button>
                                
                        
                            
                        </form>

                            
                        <hr>
                        <h3 class="mr-auto p-2">Add Sub-Category</h3>

                        <form class="forms-sample mb-20" action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf

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

                            <div class="form-group">
                                <label for="product_name">{{ __('Name')}}</label>
                                <input type="text" class="form-control" id="product_name" name="name" placeholder="Subcategory Name" required>
                            </div>

                            <div class="form-group">
                                <label for="code">{{ __('Code')}}</label>
                                <input type="text" class="form-control" id="code" name="code" placeholder="Subcategory Code">
                            </div>

                            <button type="submit" class="btn btn-primary">{{ __('Save')}}</button>
                                
                        
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
