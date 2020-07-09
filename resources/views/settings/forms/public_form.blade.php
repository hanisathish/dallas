<!DOCTYPE html>
<html>
<head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>{{$title}}</title>
        <!-- Tell the browser to be responsive to screen width -->
        <meta name="csrf-token" content="{{ csrf_token() }}" />
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        
        <!-- App Icons -->
        <link rel="shortcut icon" href="{{ URL::asset('assets/theme/images/favicon.ico') }}">

        <!-- App css -->
        <link href="{{ URL::asset('assets/theme/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{ URL::asset('assets/theme/css/icons.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{ URL::asset('assets/theme/css/style.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{ URL::asset('css/form_build.css') }}" rel="stylesheet" type="text/css" />
        <script>
            var siteUrl = '<?php echo url('/'); ?>';
        </script>
    </head>

    <body>
        <input type="hidden" name="form_id_hidden" id="form_id_hidden" value="{{$form_id}}">
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
        <script src="{{ URL:: asset('assets/theme/js/jquery.min.js')}}"></script>
        <script src="{{ URL:: asset('assets/theme/js/popper.min.js')}}"></script>
        <script src="{{ URL:: asset('assets/theme/js/bootstrap.min.js')}}"></script>
        <script src="{{ URL:: asset('js/fetch_api_call.js')}}"></script>
        <script src="{{ URL:: asset('js/forms/fields.js')}}"></script>
    </body>
</html>