@extends('layouts.default')

@section('content')
    @include('settings.forms.header-block') 

    <input type="hidden" name="form_id_hidden" id="form_id_hidden" value="{{$form->id}}">
    <div class="row justify-content-md-center bg-light ml-0 mr-0" >
        <div class="col-sm-12 col-md-8">
            <div class="card">
                <div class="card-body">
                    <form class="data-validation needs-validation" novalidate>
                        <div id="form-preview" style="min-height:80vh"></div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script src="{{ URL:: asset('js/fetch_api_call.js')}}"></script>
    <script src="{{ URL:: asset('js/forms/fields.js')}}"></script>
@endsection