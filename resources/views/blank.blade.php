@extends('layouts.main') 
@section('title', 'REST API')
@section('content')
    
    <div class="container-fluid">
        <div class="page-header">
            <div class="row align-items-end">
                <div class="col-lg-8">
                    <div class="page-header-title">
                        <i class="ik ik-layers bg-blue"></i>
                        <div class="d-inline">
                            <h5>{{ __('REST API')}}</h5>
                            <span>{{ __('REST API with Laravel Passport')}} </span>
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
                                <a href="#">{{ __('REST API')}}</a>
                            </li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
       

        <div class="row">
            <div class="col-md-12">
                <div class="card p-3">
                    <div class="card-header"><h3>{{ __('Available Api Endpoints')}}</h3></div>
                    <div class="card-body">
                        <table id="permission_table" class="table">
                            <thead>
                                <tr>
                                    <th>{{ __('Method')}}</th>
                                    <th>{{ __('URl')}}</th>
                                    <th>{{ __('Parameters')}}</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td><strong class="text-warning">POST</strong></td>
                                    <td>/api/v1/login</td>
                                    <td><code>{email, password}</code></td>
                                </tr>
                                <tr>
                                    <td><strong class="text-green">GET</strong></td>
                                    <td>/api/v1/profile</td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td><strong class="text-warning">POST</strong></td>
                                    <td>/api/v1/change-password</td>
                                    <td><code>{old_password, password, password_confirmation}</code></td>
                                </tr>
                                <tr>
                                    <td><strong class="text-warning">POST</strong></td>
                                    <td>/api/v1/update-profile</td>
                                    <td><code>{name, email}</code></td>
                                </tr>
                                <tr>
                                    <td><strong class="text-green">GET</strong></td>
                                    <td>/api/v1/logout</td>
                                    <td></td>
                                </tr>
                                <tr><td colspan="3"></tr>
                                <tr>
                                    <td><strong class="text-green">GET</strong></td>
                                    <td>/api/v1/users</td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td><strong class="text-warning">POST</strong></td>
                                    <td>/api/v1/user/create</td>
                                    <td><code>{name, email, password, password_confirmation, role[]}</code></td>
                                </tr>
                                <tr>
                                    <td><strong class="text-green">GET</strong></td>
                                    <td>/api/v1/user/<span class="text-red">1</span></td>
                                    <td><span class="text-muted">Note:1 is id, you can replace it with any id</td>
                                </tr>
                                <tr>
                                    <td><strong class="text-green">GET</strong></td>
                                    <td>/api/v1/user/delete/<span class="text-red">1</span></td>
                                    <td><span class="text-muted">Note:1 is id, you can replace it with any id</td>
                                </tr>
                                <tr>
                                    <td><strong class="text-warning">POST</strong></td>
                                    <td>/api/v1/user/change-role/<span class="text-red">1</span></td>
                                    <td><code>{role[]}</code><span class="text-muted">Note:1 is id, you can replace it with any id</td>
                                </tr>
                                <tr><td colspan="3"></tr>
                                <tr>
                                    <td><strong class="text-green">GET</strong></td>
                                    <td>/api/v1/roles</td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td><strong class="text-warning">POST</strong></td>
                                    <td>/api/v1/role/create</td>
                                    <td><code>{role, permissions[]}</code></td>
                                </tr>
                                <tr>
                                    <td><strong class="text-green">GET</strong></td>
                                    <td>/api/v1/</td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td><strong class="text-green">GET</strong></td>
                                    <td>/api/v1/role/<span class="text-red">1</span></td>
                                    <td><span class="text-muted">Note:1 is id, you can replace it with any id</td>
                                </tr>
                                <tr>
                                    <td><strong class="text-green">GET</strong></td>
                                    <td>/api/v1/role/delete/<span class="text-red">1</span></td>
                                    <td><span class="text-muted">Note:1 is id, you can replace it with any id</td>
                                </tr>
                                <tr>
                                    <td><strong class="text-warning">POST</strong></td>
                                    <td>/api/v1/role/change-permission/<span class="text-red">1</span></td>
                                    <td><code>{permissions[]}</code><span class="text-muted">Note:1 is id, you can replace it with any id</td>
                                </tr>
                                <tr><td colspan="3"></tr>
                                <tr>
                                    <td><strong class="text-green">GET</strong></td>
                                    <td>/api/v1/permissions</td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td><strong class="text-warning">POST</strong></td>
                                    <td>/api/v1/permission/create</td>
                                    <td><code>{permission}</code></td>
                                </tr>
                                <tr>
                                    <td><strong class="text-green">GET</strong></td>
                                    <td>/api/v1/</td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td><strong class="text-green">GET</strong></td>
                                    <td>/api/v1/permission/<span class="text-red">1</span></td>
                                    <td><span class="text-muted">Note:1 is id, you can replace it with any id</td>
                                </tr>
                                <tr>
                                    <td><strong class="text-green">GET</strong></td>
                                    <td>/api/v1/permission/delete/<span class="text-red">1</span></td>
                                    <td><span class="text-muted">Note:1 is id, you can replace it with any id</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection