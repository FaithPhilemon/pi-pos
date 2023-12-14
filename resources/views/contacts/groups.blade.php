@extends('layouts.main') 
@section('title', 'Contact  Groups')
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
                            <h5>{{ __('Contact group')}}</h5>
                            <span>{{ __('Add and manage contact groups')}} </span>
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
                                <a href="{{url('products')}}">{{ __('Contacts')}}</a>
                            </li>
                            <li class="breadcrumb-item">
                                <a href="#">{{ __('Groups')}}</a>
                            </li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>

        <div class="row">
            @include('include.message')
            <div class="col-md-7">
                <div class="card">
    	        
                    <div class="card-header d-flex">
                        {{-- <h3 class="mr-auto p-2">groups/Gropus List</h3> --}}
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

                        
                       
                        <h3 class="mr-auto p-2">Contact Groups</h3>

                        <table class="table">
                            <thead>
                                <tr>
                                    <th>{{ __('ID') }}</th>
                                    <th>{{ __('Name') }}</th>
                                    <th>{{ __('Actions') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($groups as $group)
                                    @if(!$group->parent_group_id || in_array($group->id, [1, 2]))
                                        <tr>
                                            <td>{{ $group->id }}</td>
                                            <td>{{ $group->name }}</td>
                                            <td>
                                                <div class="table-actions row">
                                                    <a href="#" data-toggle="modal" data-target="#editModal{{ $group->id }}"><i class="ik ik-edit f-16 text-green"></i></a>
                                                    {{-- <a href="#" data-toggle="modal" data-target="#deleteModal{{ $group->id }}"><i class="ik ik-trash-2 f-16 text-red"></i></a> --}}
                                                </div>
                                            </td>
                                        </tr>
                                    @endif
                                    

                                    <!-- Edit Modal -->
                                    <div class="modal fade" id="editModal{{ $group->id }}" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="eidtModalLabel">Edit group</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <form class="forms-sample" action="{{ route('contactGroup.update', $group->id) }}" method="POST" enctype="multipart/form-data">
                                                        @csrf
                                                        @method('PUT')
                                                        <div class="modal-body">
                                                        
                                                            <div class="form-group">
                                                                <label for="product_name">{{ __('Name')}}</label>
                                                                <input type="text" value="{{ $group->name }}" class="form-control" id="name" name="name" placeholder="group Name" required>
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
                                    <div class="modal fade" id="deleteModal{{ $group->id }}" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="deleteModalLabel">Confirm Delete</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    Are you sure you want to delete this group?
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
                                                    <form action="{{ route('products.destroy', $group->id) }}" method="POST">
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
                        
                    </div>
                </div>
            </div>

            <div class="col-md-5">
                <div class="card">
    	        


                    <div class="card-header d-flex">
                        {{-- <h3 class="mr-auto p-2">Add New groups</h3> --}}
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


                        <h3 class="mr-auto p-2">Add Group</h3>

                        <form class="forms-sample" action="{{ route('contactGroup.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf

                            <div class="form-group">
                                <label for="product_name">{{ __('Name')}}</label>
                                <input type="text" class="form-control" id="name" name="name" placeholder="Group Name" required>
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

    @endpush

@endsection
