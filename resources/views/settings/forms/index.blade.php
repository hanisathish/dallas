@extends('layouts.default')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="text-white card-primary" >
                <div class="card-body">
                    <h3>Forms<small><a href="{{URL::asset('/settings/forms/manage')}}" 
                                class="btn btn-secondary pull-right">New Form</a></small>
                    </h3>
                </div>
            </div>
        </div>
    </div>
    <div class="row text-center" style="margin-top:0">
        <div class="col-md-12 ">
            <div class="card bg-light">
                <div class="card-body col-sm-10 col-md-10 mx-auto" style="min-height:550px;">
                    <ul class="list-group text-left" id="formEmptyGroup">
                    </ul>
                    <table id="formGroup" class="table table-bordered text-left">
                        <thead>
                            <tr>
                                <th>Form Name</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
<script src="{{ URL:: asset('js/fetch_api_call.js')}}"></script>
<script>
    $(function () {
        let apiPath = siteUrl + '/api/settings/forms';
        let queryData = {};
        let apiProps = { url: apiPath, method: 'get', queryData };
        fetchDataApi(apiProps, function (data) {
            updateFormsList(data);
        });
    }); 

    function updateFormsList(formsList){
        if(formsList.length>0){
            $('#formGroup').DataTable({
                serverSide: false,
                destroy: true,
                autoWidth: false,
                searching: true,
                paging:   false,
                bInfo : false,
                aaSorting: [[ 0, "desc" ]],
                data: formsList,
                columns: [{ data: 'name' }], 
                columnDefs: [
                    {
                        targets: 0, render: function ( data, type, row ) { return `<h6><a href="${siteUrl}/settings/forms/${row.id}/submissions">${row.title? row.title: "Not Defined"}</a><small><a class="pull-right" href="${siteUrl}/settings/forms/${row.id}/submissions" targent="_blank"><i class="fa fa-external-link"></i></a></small></h6><p class="text-secondary m-0">${row.submissions_count} Submissions</p>`; }
                    }
                ],
                language: {
                    emptyTable:`<h4 class="text-primary">Forms</h4><p>Create custom forms to easily and securely collect<br/>information from the people in your church.</p><p>Forms will show here afer you create them.</p><a href="/settings/forms/manage" class="btn btn-primary"> New Form</a>`
                },
                "responsive": true
            });
        } else {
            $("#formGroup").removeClass("text-left");
            let El = `<li class="list-group-item">
                        <h4 class="text-primary">Forms</h4>
                        <p>Create custom forms to easily and securely collect<br/>
                            information from the people in your church.</p>
                        <p>Forms will show here afer you create them.</p>
                        <a href="/settings/forms/manage" class="btn btn-primary"> New Form</a>
                    </li>`;
            $("#formGroup").html(El);
        }
    }
    
</script>
@endsection