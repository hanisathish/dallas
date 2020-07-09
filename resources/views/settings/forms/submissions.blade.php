@extends('layouts.default')

@section('content')
    @include('settings.forms.header-block') 
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-body">
                    <h5 class="mt-0 header-title">Form Submissions</h5>
                    <!-- <div class="tab-content comm-table">
                        <div class="tab-pane active" id="allusers" role="tabpanel"> -->
                            <table id="submissionTable" class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Email Id</th>
                                        @foreach($form->profile_fields as $field)
                                            <th>{{$field}}</th>
                                        @endforeach
                                        <th>Submit Date</th>
                                        <th></th>
                                    </tr>
                                </thead>
                            </table>
                        <!-- </div>
                    </div> -->
                </div>
            </div>
        </div>
    </div>
<script>
    let form = <?php echo json_encode($form) ?>;
    $(function () {
        load_submission_table();
    }); 

    function load_submission_table() {
        $('#submissionTable').DataTable({
            "serverSide": true,
            "destroy": true,
            "autoWidth": false,
            "searching": true,
            "aaSorting": [[ 1, "desc" ]],
            "nowrap" : true,
            "ajax": {
                type: "GET",
                url: siteUrl + `/api/form/submissions/list/${form.id}`,
            }
        });
    }
</script>
@endsection