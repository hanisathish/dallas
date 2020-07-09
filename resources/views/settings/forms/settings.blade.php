@extends('layouts.default')

@section('content')
    @include('settings.forms.header-block') 
    <div class="row justify-content-md-center bg-light ml-0 mr-0">
        <div class="col-sm-12 col-md-8">
            <div class="card">
                <div class="card-body"  style="min-height:80vh;">
                    <div class="row">
                        <div class="col-sm-12">
                            <h5>Form Status</h5>
                            <p>Form is publicly accessible and open to receive new submissions.</p>
                            @if($form->is_active == 1)
                                <p class="p-2"><span class="text-success">Currently form available publicly</span>
                                    <a class="btn btn-danger btn-sm pull-right" href='{{URL::asset("/settings/forms/$form->id/changeStatus")}}'>Disable</a>
                                </p>
                            @else
                                <p> <span class="text-danger">Form not availbe publicly</span>
                                    <a class="btn btn-success btn-sm pull-right" href='{{URL::asset("/settings/forms/$form->id/changeStatus")}}'>Enable</a>
                                </p>
                            @endif
                        </div>
                    </div>
                    <hr/>
                    <div class="row">
                        <div class="col-sm-12">
                            <h5>Embed</h5>
                            <p>You’ll need your form’s public URL:</p>
                            <input type="text" style="width:80%; padding:10px;" value="{{url('/form/submission/'.$form->id)}}" readonly>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection