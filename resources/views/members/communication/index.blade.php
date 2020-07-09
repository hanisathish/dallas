@extends('layouts.default')

@section('content')
@if(session()->has('message'))
    <div class="alert alert-success" role="alert">
        {{ session()->get('message') }}
    </div>
@endif

<div class="row">
    
    @include('members.member_profile_header_block')

</div>
<div class="row">
    <div class="col-lg-3">
        @include('members.member_profile_sidebar')
    </div>
    <div class="col-lg-9">
        <div class="card m-b-30">
            <div class="card-body">

                <h4 class="mt-0 header-title">Communications</h4>

                <!-- Tab panes -->
                <div class="tab-content comm-table">
                    <div class="tab-pane active" id="allusers" role="tabpanel">
                        <table id="commdatatable" class="table table-bordered ">
                            <thead>
                                <tr>
                                    <th>Sl No</th>
                                    <th>Name</th>
                                    <th>Subject</th>
                                    <!-- <th>Body</th> -->
                                    <!-- <th>Read Status</th>
                                    <th>Del Status</th> -->
                                    <th>Created By</th>
                                    <th>Created At</th>
                                    <th>Open </th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div> <!-- end col -->
</div> <!-- end row -->

<div id="commModal" class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" data-backdrop="static">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header" id="commModalTitle"></div>
            <div class="modal-body" id="commModalBody"></div>
            <div class="modal-footer" id="commModalFooter"></div>
        </div>
    </div>
</div>

<script type="text/javascript">
    let user = <?php echo json_encode($user) ?>;

    $(function () {
        load_commDatatable();
    }); 
    
    function load_commDatatable() {
        var dt = $('#commdatatable').DataTable({
            "serverSide": true,
            "destroy": true,
            "autoWidth": false,
            "searching": false,
            "aaSorting": [[ 1, "desc" ]],
            "nowrap" : false,
            "ajax": {
                type: "GET",
                url: siteUrl + `/api/people/member/${user.personal_id}/get_messages`,
            },
            "columnDefs": [ {
            "targets": 0,
            "orderable": false
            }, {
                "targets": 5,
                "orderable": false
            } ]
        });
        dt.on( 'order search', function () {
        dt.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
            cell.innerHTML = i+1;
        } );
    } ).draw();
    }

    function openModalWithCommData(templateId){
        let url = siteUrl + `/api/people/member/${user.personal_id}/get_messages/${templateId}`
        fetchDataApi(url, function(data){
            console.log(data);
            updateModalDetails(data);
        })
    }

    function updateModalDetails(data){
        let header = data.name ? `<h5 class="modal-title">${data.name}</h5>` : '';
        let body = `<div class="card m-b-30">
                        <div class="card-body">
                            <h4 class="card-title font-14 mt-0"> Subject : ${data.subject}</h4>
                            <p class="card-text">${data.body}</p>
                        </div>
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item">
                                <h5 class="card-title font-14 mt-0"> Crated By: ${data.created_user.full_name}</h5>
                                <p>${data.created_user.email? data.created_user.email : ''}<br/>
                                    ${data.created_user.mobile_null ? data.created_user.mobile_null : ''}
                                </p>
                            </li>
                        </ul>
                    </div>`
        let footer = `<button type="button" class="btn btn-secondary" onClick="closeModal()">Close</button>`

        $("#commModalTitle").html(header);
        $("#commModalBody").html(body);
        $('#commModalFooter').html(footer);
        $("#commModal").modal("show");
    }

    function closeModal(){
        $("#commModal").modal("hide");
    }
    // Calling Restfull Api's
    function fetchDataApi(url, callback){
        fetch(url).then(
            function(response) {
                if (response.status !== 200) {
                    throw new Error("failure with error code"+response.status)
                }
                response.json().then(function(data) {
                    return callback(data);
                });
            }
        )
        .catch(function(err) {
            console.log('Fetch Error :-S', err);
        });
    }
</script>    
@endsection
