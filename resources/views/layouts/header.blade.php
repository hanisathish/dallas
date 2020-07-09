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

        <!--Morris Chart CSS -->
        <link rel="stylesheet" href="{{ URL::asset('assets/theme/plugins/morris/morris.css') }}">

        <!-- DataTables -->
        <link href="{{ URL::asset('assets/theme/plugins/datatables/dataTables.bootstrap4.min.css')}}" rel="stylesheet" type="text/css" />
        <link href="{{ URL::asset('assets/theme/plugins/datatables/buttons.bootstrap4.min.css')}}" rel="stylesheet" type="text/css" />
        <!-- Responsive datatable examples -->
        <link href="{{ URL::asset('assets/theme/plugins/datatables/responsive.bootstrap4.min.css')}}" rel="stylesheet" type="text/css" />


        <!-- App css -->
        <link href="{{ URL::asset('assets/theme/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{ URL::asset('assets/theme/css/icons.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{ URL::asset('assets/theme/css/style.css') }}" rel="stylesheet" type="text/css" />

         <!-- Custom css -->
         <link href="{{ URL::asset('assets/bootstrap3-dialog/bootstrap-dialog.css') }}" rel="stylesheet" type="text/css" />

         <link href="{{ URL::asset('assets/scroller-dataTables/scroller.dataTables.min.css') }}" rel="stylesheet" type="text/css" />

        <link href="{{ URL::asset('css/custom.css') }}" rel="stylesheet" type="text/css" />
        <!--<link href="{{ URL::asset('css/adminlte.css') }}" rel="stylesheet" type="text/css" />-->
        <script src="{{ URL:: asset('assets/theme/js/jquery.min.js')}}"></script>
        <script>
            var siteUrl = '<?php echo url('/'); ?>';
        </script>

        <!-- datepicker -->
        <link href="{{ URL::asset('assets/theme/plugins/bootstrap-datepicker/css/bootstrap-datepicker.min.css') }}" rel="stylesheet" type="text/css" />


        <!--------Crop -->

        <link href="{{ URL::asset('css/main.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{ URL::asset('css/form_build.css') }}" rel="stylesheet" type="text/css" />

        <link href="{{ URL::asset('assets/pagination/pagination.css') }}" rel="stylesheet" type="text/css" />

        <!-- Jquery Validation Js-->        
        <script src="{{ URL:: asset('js/jquery_validation/jquery.validate.min.js')}}"></script>

        <link href="{{ URL::asset('assets/theme/plugins/alertify/css/alertify.css') }}" rel="stylesheet" type="text/css" />
		
		<!-- <script type="text/javascript" src="{{ URL:: asset('assets/js/validation/validate.min.js')}}"></script> -->
		
        <!-- <script type="text/javascript" src="{{ URL:: asset('assets/js/validation/select2.min.js')}}"></script> -->
		 
    </head>

    <body>
        <!-- Loader -->
        <div id="preloader"><div id="status"><div class="spinner"></div></div></div>
