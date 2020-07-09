<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
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
        <script>var siteUrl = '<?php echo url('/'); ?>';</script>
        <style>
            .pane {
                margin-bottom: 1.5rem;
                border-color: #EBEBEB;
                box-shadow: 0 2px 5px rgb(153, 153, 153);
            }
        </style>
    </head>
    <body>
        @include("groups.public.layout.header")
        <input type="text" class="d-none" id="orgObj" data-org="{{$org}}">
        <div class="container-fluid d-flex justify-content-center bg-light" style="min-height:80vh">
            <div class="row p-4 bg-white" >
                <div class="col-sm-12 " style="min-width:60vw;">
                    @yield("content")
                </div>
            </div>
        </div>
        @include("groups.public.layout.footer")
        <!-- jQuery  -->

        <script src="{{ URL:: asset('assets/theme/js/popper.min.js')}}"></script>
        <script src="{{ URL:: asset('assets/theme/js/bootstrap.min.js')}}"></script>
        <script src="{{ URL:: asset('assets/theme/js/modernizr.min.js')}}"></script>
        <script src="{{ URL:: asset('assets/theme/js/waves.js')}}"></script>
        <script src="{{ URL:: asset('assets/theme/js/jquery.slimscroll.js')}}"></script>
        <script src="{{ URL:: asset('assets/theme/js/jquery.nicescroll.js')}}"></script>
        <script src="{{ URL:: asset('assets/theme/js/jquery.scrollTo.min.js')}}"></script>


        <!-- Required datatable js -->
        <script src="{{ URL:: asset('assets/theme/plugins/datatables/jquery.dataTables.min.js')}}"></script>
        <script src="{{ URL:: asset('assets/theme/plugins/datatables/dataTables.bootstrap4.min.js')}}"></script>
        <!-- Buttons examples -->
        <script src="{{ URL:: asset('assets/theme/plugins/datatables/dataTables.buttons.min.js')}}"></script>
        <script src="{{ URL:: asset('assets/theme/plugins/datatables/buttons.bootstrap4.min.js')}}"></script>
        <script src="{{ URL:: asset('assets/theme/plugins/datatables/jszip.min.js')}}"></script>
        <script src="{{ URL:: asset('assets/theme/plugins/datatables/pdfmake.min.js')}}"></script>
        <script src="{{ URL:: asset('assets/theme/plugins/datatables/vfs_fonts.js')}}"></script>
        <script src="{{ URL:: asset('assets/theme/plugins/datatables/buttons.html5.min.js')}}"></script>
        <script src="{{ URL:: asset('assets/theme/plugins/datatables/buttons.print.min.js')}}"></script>
        <script src="{{ URL:: asset('assets/theme/plugins/datatables/buttons.colVis.min.js')}}"></script>
        <!-- Responsive examples -->
        <script src="{{ URL:: asset('assets/theme/plugins/datatables/dataTables.responsive.min.js')}}"></script>
        <script src="{{ URL:: asset('assets/theme/plugins/datatables/responsive.bootstrap4.min.js')}}"></script>

        <!-- Datepicker -->
        <script src="{{ URL:: asset('assets/theme/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js')}}"></script>


        <!-- Datatable init js -->
        <script src="{{ URL:: asset('assets/theme/pages/datatables.init.js')}}"></script>

        <script src="{{ URL:: asset('assets/bootstrap3-dialog/bootstrap-dialog.js')}}"></script>
        <script src="{{ URL:: asset('assets/formJs/jquery.form.js')}}"></script>

        <script src="{{ URL:: asset('assets/bootstrap-autocomplete/bootstrap-autocomplete.min.js')}}"></script>

        <script src="{{ URL:: asset('assets/scroller-dataTables/dataTables.scroller.min.js')}}"></script>

        <!-- Parsley js -->
<!--        <script type="text/javascript" src="{{ URL:: asset('assets/theme/plugins/parsleyjs/parsley.min.js')}}"></script>

        <script type="text/javascript">
            $(document).ready(function() {
                $('form').parsley();
            });
        </script>-->

        
        <!-- <script src="{{ URL:: asset('js/bootbox.min.js')}}"></script> -->
        <!-- App js -->
         <script src="{{ URL:: asset('assets/theme/js/app.js')}}"></script>

         <script type="text/javascript">
             var siteUrl = '<?php echo url('/'); ?>';
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });


        </script>



        <!-- Alertify js -->    
        <script src="{{ URL:: asset('assets/theme/plugins/alertify/js/alertify.js')}}"></script>
        <script src="{{ URL:: asset('js/custom/alertify-init.js')}}"></script>

        <script src="{{ URL:: asset('js/custom/form-advanced.js')}}"></script>
        <script src="{{ URL:: asset('assets/pagination/pagination.min.js')}}"></script>
    </body>
</html>