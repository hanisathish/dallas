@extends('layouts.default')

@section('content')
    <div style="width:100vw">
        <div class="row">
            <div class="col-md-12 p-3" style="background-color:#4d5467">
                <div class="card-body">
                    <h4 class="text-white">Shared Group Tags</h4>  
                </div>
            </div>
        </div>
        <div class="row p-3 groupSortable" style="position:relative"></div>
    </div>
    <script src="{{ URL:: asset('assets/theme/plugins/jquery-ui/jquery-ui.min.js')}}"></script>
    <script src="{{ URL:: asset('js/fetch_api_call.js')}}"></script>
    <script src="{{ URL:: asset('js/custom.js')}}"></script>
    <script src="{{ URL:: asset('js/groups/tags.js')}}"></script>
@endsection