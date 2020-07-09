@extends('layouts.default')

@section('content')
    @include('settings.forms.header-block') 
    <div class="row justify-content-md-center bg-light ml-0 mr-0" >
        <div class="col-sm-12 col-md-8">
            <div class="card">
                <div class="card-body">
                    <ul class="list-group list-group-flush">
                        <div class="card-header pb-0 pt-0"> <h5>Profile Details</h5></div>
                        @foreach($profile_fields as  $key => $value)
                            <li class="list-group-item"><strong>{{$key}}</strong> : {{$value}}</li>
                        @endforeach
                        <div class="card-header pb-0 pt-0"> <h5>General Details</h5></div>
                        @foreach($general_fields as  $key => $value)
                            <li class="list-group-item"><strong>{{$key}}</strong> : {{$value}}</li>
                        @endforeach
                        <li>
                            <a type="button" class="btn btn-light btn-sm pull-right m-2" href='{{URL::asset("/settings/forms/$form->id/submissions")}}'>Go Back</a>
                            <a type="button" class="btn btn-danger btn-sm pull-right m-2" href='{{URL::asset("/settings/forms/$form->id/submissions/$submission_id/delete")}}'>Delete</a> 
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
@endsection