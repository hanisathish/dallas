@extends('layouts.default')

@section('content')

<!-- Page-Title -->
<div class="row">
    <div class="col-sm-12">
        <div class="page-title-box">
            <div class="btn-group pull-right">
                <ol class="breadcrumb hide-phone p-0 m-0">
                    <li class="breadcrumb-item active">Roles Edit</li>
                </ol>
            </div>
            <!--<h4 class="page-title">Roles Management</h4>-->

        </div>
    </div>
</div>
<!-- end page title end breadcrumb -->

<div class="row">
    <div class="col-md-12">
        <div class="card m-b-30">
            <div class="card-body">
                <div class="col-12">
                    <div class="row">
                        <div class="col-md-6 col-lg-6 col-xl-6">
                            <h4><i class='fa fa-key'></i> Update Role: {{$role->name}}</h4>
                            <hr>
                            {{ Form::model($role, array('route' => array('roles.update', $role->id), 'method' => 'PUT')) }}
                            <div class="form-group">
                                {{ Form::label('name', 'Role Name') }}
                                {{ Form::text('name', null, array('class' => 'form-control col-4')) }}
                            </div>
                            <h3>Assign Permissions</h3>
                            @foreach ($permissions as $permission)
                            {{Form::checkbox('permissions[]',  $permission->id, $role->permissions ) }}
                            {{Form::label($permission->name, ucfirst($permission->name)) }}<br>
                            @endforeach
                            <br>
                            {{ Form::submit('Update', array('class' => 'btn btn-primary')) }}
                            <a href="{{URL::asset('role_management')}}" class="btn btn-warning"><i class="fa fa-arrow-left"></i> Go Back
                            {{ Form::close() }}

                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
