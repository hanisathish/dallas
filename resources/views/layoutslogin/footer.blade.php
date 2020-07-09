        </div>
        <!-- jQuery  -->
        
        <script src="{{ URL:: asset('assets/theme/js/popper.min.js')}}"></script>
        <script src="{{ URL:: asset('assets/theme/js/bootstrap.min.js')}}"></script>
        <script src="{{ URL:: asset('assets/theme/js/modernizr.min.js')}}"></script>
        <script src="{{ URL:: asset('assets/theme/js/waves.js')}}"></script>
        <script src="{{ URL:: asset('assets/theme/js/jquery.slimscroll.js')}}"></script>
        <script src="{{ URL:: asset('assets/theme/js/jquery.nicescroll.js')}}"></script>
        <script src="{{ URL:: asset('assets/theme/js/jquery.scrollTo.min.js')}}"></script>

        <!-- App js -->
        <script src="{{ URL:: asset('assets/theme/js/app.js')}}"></script>
        
        <script type="text/javascript">
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
        </script>

    </body>
</html>