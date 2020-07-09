@extends('layouts.default')

@section('content')

    <!-- <div style="width:100vw"> -->
        @include('groups.components.search_bar_header')

        <div id="data-container"></div>
        <div id="pagination-container"></div>



            <script>
                 $(document).ready(function() {
                    listGroups("");
                });

                function listGroups(groupType){
                    $('#pagination-container').pagination({
                        dataSource: siteUrl + '/groups/groupsListPagination',
                        locator: 'items',
                        totalNumberLocator: function(response) {
                            // you can return totalNumber by analyzing response content
                            return response.count;
                        },
                        pageSize: 8,
                        ajax: {
                            method:"post",
                            data: {groupType:groupType},
                            beforeSend: function() {
                                $('#data-container').html('Loading Groups');
                            }
                        },
                        callback: function(data, pagination) {
                            // template method of yourself
                            var html = simpleTemplating(data);
                            $('#data-container').html(html);
                        }
                    })
                }

                function simpleTemplating(data) {
                    var html = '<div class="row no-gutters">';
                    $.each(data, function(index, item){
                        html += '<div class="col-md-3 p-3">'+ item +'</div>';
                    });
                    html += '</div>';
                    return html;
                }

                function addGroup(){

                    createGroupDlg = BootstrapDialog.show({
                    title:"New Group Type",
                    size:"size-wide",
                    message: $('<div></div>').load(siteUrl+"/groups/create/form"),
                    buttons: [
                        {
                            label: 'Submit',
                            cssClass: 'btn-primary',
                            action: function(dialogRef){
                                submitGroup();
                            }
                        },
                        {
                            label: 'Cancel',
                            action: function(dialogRef){
                                dialogRef.close();
                            }
                        }
                    ]
                });



                }
                function submitGroup(){
                    $('#create_group_form').ajaxForm(function(data) {
                        $("#create_group_form_status").html(data.message);
                        setTimeout(function(){
                            listGroups("");
                            createGroupDlg.close();

                        },2000);

                        //$("#create_resource_form").submit();

                });
                $("#formSubmitBtn").click();
                }
            </script>


    <!-- </div> -->
@endsection
