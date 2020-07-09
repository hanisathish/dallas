<style>
    .m_check {
        zoom:1.5
    }
</style>
<div class="alert alert-primary" role="alert" id="attedence_result" style="display: none">

  </div>
<table class="table table-bordered dataTable no-footer">
    <thead>
        <tr>
            <th>
            </th>
            <th>FIRST NAME
                </th>
                <th>LAST NAME
                    </th>
                    <th>
                        	ROLE
                    </th>
        </tr>
    </thead>
<tbody>

@foreach($members as $member)
<tr>
<td> <input type="checkbox" class="m_check" value="1" {{($member->att)?"checked":""}} data-event="{{$eventId}}" data-group-member-id="{{$member->id}}" />

    </td>
    <td> {{$member->first_name}}</td>
    <td> {{$member->last_name}}</td>
    <td> {{ ($member->role==2)?"Member":"Leader"}}</td>
</tr>
@endforeach
</tbody>
</table>
<script>
$(document).ready(function() {
     $('.dataTable').DataTable({
        paging: false,
        lengthChange:false,
        paging:false,
        info:false,
            "serverSide": false,
            "destroy": true,
            "autoWidth": false,
            "searching": true,
            "aaSorting": [[ 1, "desc" ]],


        });




});
</script>

