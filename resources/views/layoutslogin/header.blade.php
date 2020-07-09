<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Login</title>
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
        
        <script src="{{ URL:: asset('assets/theme/js/jquery.min.js')}}"></script>
        
        <!-- Jquery Validation Js-->        
        <script src="{{ URL:: asset('js/jquery_validation/jquery.validate.min.js')}}"></script>
        <script src="{{ URL:: asset('js/jquery_validation/additional-methods.min.js')}}"></script>
        
        <script>
            var siteUrl = '<?php echo url('/'); ?>';
        </script>
    </head>

    <body>
        <!-- Begin page -->
        <div class="accountbg"></div>
        <div class="wrapper-page">
        