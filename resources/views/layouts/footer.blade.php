</div> <!-- end container -->
        </div>
        <!-- end wrapper -->


        <!-- Footer -->
        <footer class="footer">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        © {{ date('Y') }} {{ Config::get('constants.BROWSERTITLE') }}
                    </div>
                </div>
            </div>
        </footer>
        <!-- End Footer -->


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

        @yield('js_script')

        <!-- Alertify js -->    
        <script src="{{ URL:: asset('assets/theme/plugins/alertify/js/alertify.js')}}"></script>
        <script src="{{ URL:: asset('js/custom/alertify-init.js')}}"></script>

        <script src="{{ URL:: asset('js/custom/form-advanced.js')}}"></script>
        <script src="{{ URL:: asset('assets/pagination/pagination.min.js')}}"></script>
            
    </body>
</html>
