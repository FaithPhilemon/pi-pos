@extends('layouts.main') 
@section('title', 'Contacts')
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
                            <h5>{{ __('Contacts')}}</h5>
                            <span>{{ __('Manage customers, suppliers & add new contacts')}} </span>
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
                                <a href="#">{{ __('contacts')}}</a>
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
                            <a href="{{ route('contacts.index', ['type' => 'suppliers']) }}" class="btn btn-outline-warning p-2 mr-5">{{ __('Suppliers')}}</a>
                            <a href="{{ route('contacts.index', ['type' => 'customers']) }}" class="btn btn-outline-success p-2 mr-5">{{ __('Customers')}}</a>
                            <button type="button" class="btn btn-outline-primary p-2 mr-10" data-toggle="modal" data-target="#addNewModal">{{ __('Add New Contact')}}</button>
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
                                    <th>{{ __('Contact') }}</th>
                                    <th>{{ __('Phone Number') }}</th>
                                    <th>{{ __('Email') }}</th>
                                    <th>{{ __('Address') }}</th>
                                    @if ($pageTitle !== 'Suppliers' && $pageTitle !== 'Customers')
                                        <th>{{ __('Group') }}</th>
                                    @endif
                                    <th>{{ __('Actions') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($contacts as $contact)
                                    <tr>
                                        <td>{{ $contact->id }}</td>
                                        <td>{{ $contact->contact_name }} <br> <small>{{ $contact->business_name }}</small></td>
                                        <td>{{ $contact->phone_number }}</td>
                                        <td>{{ $contact->email }}</td>
                                        <td>{{ $contact->address }}</td>
                                        @if ($pageTitle !== 'Suppliers' && $pageTitle !== 'Customers')
                                            <td>{{ $contact->contactGroup->name }}</td>
                                        @endif
                                        
                                        <td>
                                            <div class="table-actions row">
                                                {{-- <a href="#"><i class="ik ik-eye text-blue"></i></a> --}}
                                                {{-- <a href="{{ route('contacts.edit', $contact->id) }}"><i class="ik ik-edit f-16 text-green"></i></a> --}}
                                                <a href="#" data-toggle="modal" data-target="#editModal{{ $contact->id }}"><i class="ik ik-edit f-16 text-green"></i></a>
                                                <a href="#" data-toggle="modal" data-target="#deleteModal{{ $contact->id }}"><i class="ik ik-trash-2 f-16 text-red"></i></a>
                                               
                                            </div>
                                        </td>
                                    </tr>

                                    <!-- Edit Modal -->
                                    <div class="modal fade" id="editModal{{ $contact->id }}" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-lg" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="eidtModalLabel">Edit group</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <form class="forms-sample" action="{{ route('contacts.update', $contact->id) }}" method="POST" enctype="multipart/form-data">
                                                        @csrf
                                                        @method('PUT')
                                                        <div class="modal-body">
                                                        
                                                            <div class="row">
                                                                <div class="col-sm-8">
                                    
                                                                    <div class="form-group">
                                                                        <label for="contact_name">Contact Name<span class="text-red">*</span></label>
                                                                        <input id="contact_name" type="text" class="form-control" name="contact_name" value="{{ $contact->contact_name }}" placeholder="Enter contact name" required>
                                                                        <div class="help-block with-errors"></div>
                                                                    </div>
                                    
                                                                    <div class="form-group">
                                                                        <label for="business_name">Business/Organizarion Name</label>
                                                                        <input id="business_name" type="text" class="form-control" name="business_name" value="{{ $contact->business_name }}" placeholder="Business Name">
                                                                        <div class="help-block with-errors"></div>
                                                                    </div>
                                    
                                                                    <div class="form-group">
                                                                        <label>Address</label>
                                                                        <input id="address" type="text" class="form-control" name="address" value="{{ $contact->address }}" placeholder="">
                                                                    </div>
                                    
                                                                </div>
                                                                <div class="col-sm-4">
                                    
                                                                    <div class="form-group">
                                                                        <label for="contact_group">{{ __('Contact Group')}}<span class="text-red">*</span></label>
                                                                        <select class="form-control" id="contact_group" name="contact_group" required>
                                                                            <option value="">--------</option>
                                                                            @foreach($groups as $group)
                                                                                {{-- <option value="{{ $group->id }}">{{ $group->name }}</option> --}}
                                                                                <option value="{{ $group->id }}" {{ $group->id == $contact->contact_group ? 'selected' : '' }}>{{ $group->name }}</option>
                                                                            @endforeach
                                                                        </select>
                                                                    </div>
                                    
                                                                    
                                    
                                                                    <div class="form-group">
                                                                        <label for="phone_number">{{ __('Phone Number')}}<span class="text-red">*</span></label>
                                                                        <input type="text" class="form-control" id="phone_number" name="phone_number" value="{{ $contact->phone_number }}" placeholder="Contact Number" required>
                                                                    </div>
                                    
                                                                    <div class="form-group">
                                                                        <label for="email">{{ __('Email')}}</label>
                                                                        <input type="email" class="form-control" id="email" name="email" value="{{ $contact->email }}" placeholder="Contact Email">
                                                                    </div>
                                    
                                                                </div>
                                                                
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
                                    <div class="modal fade" id="deleteModal{{ $contact->id }}" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="deleteModalLabel">Confirm Delete</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    Are you sure you want to delete this contact?
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
                                                    <form action="{{ route('contacts.destroy', $contact->id) }}" method="POST">
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

                        {{ $contacts->links() }}

                        
                    </div>
                </div>
            </div>
        </div>

    </div>


    <div class="modal fade" id="addNewModal" tabindex="-1" role="dialog" aria-labelledby="demoModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="demoModalLabel">{{ __('Add New contact')}}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>

                <form class="forms-sample" action="{{ route('contacts.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-sm-8">

                                <div class="form-group">
                                    <label for="contact_name">Contact Name<span class="text-red">*</span></label>
                                    <input id="contact_name" type="text" class="form-control" name="contact_name" value="" placeholder="Enter contact name" required>
                                    <div class="help-block with-errors"></div>
                                </div>

                                <div class="form-group">
                                    <label for="business_name">Business/Organizarion Name</label>
                                    <input id="business_name" type="text" class="form-control" name="business_name" value="" placeholder="Business Name">
                                    <div class="help-block with-errors"></div>
                                </div>

                                <div class="form-group">
                                    <label>Address</label>
                                    <input id="address" type="text" class="form-control" name="address" placeholder="">
                                </div>

                            </div>
                            <div class="col-sm-4">

                                <div class="form-group">
                                    <label for="contact_group">{{ __('Contact Group')}}<span class="text-red">*</span></label>
                                    <select class="form-control" id="contact_group" name="contact_group" required>
                                        <option value="">--------</option>
                                        @foreach($groups as $group)
                                            <option value="{{ $group->id }}">{{ $group->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                

                                <div class="form-group">
                                    <label for="phone_number">{{ __('Phone Number')}}<span class="text-red">*</span></label>
                                    <input type="text" class="form-control" id="phone_number" name="phone_number" placeholder="Contact Number" required>
                                </div>

                                <div class="form-group">
                                    <label for="email">{{ __('Email')}}</label>
                                    <input type="email" class="form-control" id="email" name="email" placeholder="Contact Email">
                                </div>

                            </div>
                            
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
            contactImage.onchange = evt => {
                preview = document.getElementById('preview');
                preview.style.display = 'block';
                const [file] = contactImage.files
                if (file) {
                    preview.src = URL.createObjectURL(file)
                }
            }
        </script>

    @endpush

@endsection
