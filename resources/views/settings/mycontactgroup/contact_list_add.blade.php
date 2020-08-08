
    <div class="table-responsive">
        <table id="contactaddtogroup-datatable" class="table table-bordered table-hover">
            <thead>
                <tr>
                    <th class="text-center"><input type="checkbox" class='checkall' id='checkall' /></th>
                    <th>Email</th>
                    <th>First Name</th>
                    <th>Last Name</th>
                </tr>
            </thead>
            <tbody>
                 <?php
                 if(count($selectShowAddContactsList) > 0){
                    // $i=0;
                    // foreach ($selectShowAddContactsList as $ssaclValue) {
                    for($i=0;$i<count($selectShowAddContactsList);$i++){
                        ?>
                        <tr>
                            <td class="text-center"><input type="checkbox" onclick='checkcheckbox();' class="addcontacttogroup" id="{{$selectShowAddContactsList[$i]->id}}" name="{{$selectShowAddContactsList[$i]->id}}" value="{{$selectShowAddContactsList[$i]->id}}"></td>
                            <td>{{$selectShowAddContactsList[$i]->c_email}}</td>
                            <td>{{$selectShowAddContactsList[$i]->c_f_name}}</td>
                            <td>{{$selectShowAddContactsList[$i]->c_l_name}}</td>
                        </tr>    
                        <?php
                        // $i++;
                    }
                 }
                 ?>
                
            </tbody>
        </table>
    </div>
 

    


     <!-- Javascript code only for this page -->


<script>

    // Checkbox checked
function checkcheckbox(){

   // Total checkboxes
   var length = $('.addcontacttogroup').length;

   // Total checked checkboxes
   var totalchecked = 0;
   $('.addcontacttogroup').each(function(){
      if($(this).is(':checked')){
         totalchecked+=1;
      }
   });

   // Checked unchecked checkbox
   if(totalchecked == length){
      $("#checkall").prop('checked', true);
   }else{
      $('#checkall').prop('checked', false);
   }
}
    /* Select/Deselect all checkboxes in tables */
    $('thead input:checkbox').click(function () {
        var checkedStatus = $(this).prop('checked');
        var table = $(this).closest('table');

        $('tbody input:checkbox', table).each(function () {
            $(this).prop('checked', checkedStatus);
        });
    });
</script>
 