 

    <div class="clearfix">
        <div class="pull-left">
            <a href="#modal-mycontactgrouppop"  data-toggle="modal" data-popgroupid="" data-popgroupname="" id="addContactsPop" class="btn btn-primary"><i class="fa fa-plus"></i> Add Contacts</a>

            
        </div>
    </div>
    <div class="table-responsive">
                        <table id="groupcontacts-datatable" class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th class="text-center">#</th>
                                    <th>Email</th>
                                    <th>First Name</th>
                                    <th>Last Name</th>
                                    <th class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                 
                                
                            </tbody>
                        </table>
                    </div>
 

    


     <!-- Javascript code only for this page -->


<script>

    $(function () {
        loadGroupContactsDatatable();
    });

    function loadGroupContactsDatatable() {
        // webApp.datatables();
        groupContactsTable = $('#groupcontacts-datatable').DataTable({
            "serverSide": true,
            "destroy": true,
            "autoWidth": false,
            "searching": true,
            "aaSorting": [
                [0, "desc"]
            ],
            "columnDefs": [{
                "targets": 0,
                "searchable": false,
                "visible": false
            }],
            pageLength: 15,
            lengthMenu: [[15, 20, 50, -1], [15, 20, 50, "All"]],
            "ajax": {
                type: "POST",
                data: {
                    addContactsPopGroupId:$("#addContactsPopGroupId").val()
                },
                url: siteUrl + '/settings/mycontactgroup/list_contacts',
            },
            "initComplete": function(settings, json) {
                // $("#eventsTable_filter").append('<button class="btn small btn-primary" id="eventDateSearch"  >Event Date</button>');

            }
        });

        /* Add placeholder attribute to the search form */
        $('.dataTables_filter input').attr('placeholder', 'Search');
    }

                // $(function () {
                

                //     webApp.datatables();

                

                //     $('#groupcontacts-datatable').dataTable({
                //         columnDefs: [{orderable: false, targets: [4]}],
                //         pageLength: 15,
                //         lengthMenu: [[15, 30, 50, -1], [15, 30, 50, "All"]]
                //     });

                

                //     $('.dataTables_filter input').attr('placeholder', 'Search');
                // });

                

    $('#modal-mycontactgrouppop').on('show.bs.modal', function (event) {

          var button = $(event.relatedTarget) // Button that triggered the modal
          var popgroupid = button.data('popgroupid') 
          var popgroupname = button.data('popgroupname') 
          //alert("mycontactgrouppop"+popgroupname+"+++"+popgroupid);
          var modal = $(this)
          modal.find('.modal-title').text('Add Contacts to Group -' + popgroupname)
          //modal.find('#addContactsPopGroupIdNewPop').val('')
          //modal.find('.modal-body input').val(popgroupname)

          var datastring = "popgroupid="+popgroupid;
            // alert(datastring);
            $.ajax({
                url: siteUrl + '/settings/mycontactgroup/showaddcontacts/'+popgroupid,
                async: true,
                type: "GET",
                // data: datastring,
                dataType: "html",
                // contentType: false,
                // cache: false,
                // processData: false,
                success: function (data)
                {
                    
                    //modal.find('#addContactsPopGroupIdNewPop').val(popgroupid)
                    modal.find('.modal-body').html(data)
                    /////////
                    // webApp.datatables();

                

                    $('#contactaddtogroup-datatable').dataTable({
                        columnDefs: [{orderable: false, targets: [0]}],
                        pageLength: 5,
                        lengthMenu: [[5, 25, 50, -1], [5, 25, 50, "All"]]
                    });

                

                    $('.dataTables_filter input').attr('placeholder', 'Search');
                    ///////
                }

            }); 
          //modal.find('.modal-body').html("popgroupname")
        });
 
   $('#addContactToGroupButton').click(function(){

        var contactadd_arr = [];
        // Read all checked checkboxes
        $("input:checkbox[class=addcontacttogroup]:checked").each(function () {
        contactadd_arr.push($(this).val());
        });

      // Check checkbox checked or not
        if(contactadd_arr.length > 0){
         // alert(contactadd_arr.length);
        // console.log("contactadd_arr=="+contactadd_arr);
         // Confirm alert
         // var confirmdelete = confirm("Do you want to add to this group?");
         // if (confirmdelete == true) {
            // alert(contactadd_arr);
            // var datastring = "contactadd_arr="+contactadd_arr;
            // alert($("#addContactsPopGroupId").val());
            $.ajax({
                        url: siteUrl + '/settings/addcontactstogroup',
                        async: true,
                        type: "POST",
                        // data: datastring,
                        dataType: "html",
                        // contentType: false,
                        // cache: false,
                        // processData: false,
                        // url: siteUrl+'/addcontactstogroup/',
                        // async: true,
                        // type: "POST",
                        // data: datastring,
                        // dataType: "html",
                        data: {pass_contact_group_id:$("#addContactsPopGroupId").val(), contactadd_arr: contactadd_arr},
                        success: function(response){
                            // alert("succces");
                            // console.log(response);
                            //dataTable.ajax.reload();
                            loadGroupContactsDatatable();
                            
                            loadMyContactDatatable();
                            loadMyContactGroupDatatable();
                            $('#modal-mycontactgrouppop').modal('hide');


                        }
                    });
                 // } 
        }
    });

   //Delete the group data
function group_contact_map_data_delete(id)
{
     

    var dataString = 'id=' + id;
    // alert(dataString);
    bootbox.confirm({
        title: "Confirm",
        message: "<h4 id='modal_content'>Do you want to continue to delete this contact from group?</h4>",
        buttons: {
            cancel: {
                label: '<i class="fa fa-times"></i> No',
                className: 'btn-danger'
            },
            confirm: {
                label: '<i class="fa fa-check"></i> Confirm',
                className: 'btn-success'
            }
        },
        callback: function (result) {
            if (result === true) {
                $.ajax({
                    url: siteUrl + '/settings/mycontactgroupmap/'+id,
                    async: true,
                    type: "DELETE",
                    // data: dataString,
                    data: {"id": id , _method: 'delete'},
                    dataType: "html",
                    // contentType: false,
                    // cache: false,
                    // processData: false,
                    success: function (data)
                    {
                        if(data == "success"){
                            alert("Contact Deleted from this Group ");
                            loadGroupContactsDatatable();
                            loadMyContactDatatable();
                            loadMyContactGroupDatatable();
                        }
                        //location.reload();
                        
                    }
                })
            }
            else
            {

            }
        }
    });
   
 }
</script>
 