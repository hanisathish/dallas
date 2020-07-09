$(document).ready(function () {
//    $(".container-fluid").addClass("m-0 p-0");
    $(".container-fluid").css({ width: "100vw" });
    $(".wrapper").css("padding-top", "118px");
	
    updateDatatable("","","");
     
	
});

function updateDatatable(start_date, end_date, event_id) {
	
	  let dt = $('#scheduleDatatable').DataTable({
			"serverSide": true,
			"destroy": true,
			"autoWidth": false,
			"searching": true,
			"aaSorting": [[1, "desc"]],
			"nowrap": true,
			"ajax": {
				type: "GET",
				 //url: siteUrl + `/attendance/list`,
				   url: siteUrl + "/attendance/list?start_date="+start_date+"&end_date="+end_date+"&event_id="+event_id,
			},
			"columnDefs": [{
				"targets": 0,
				"orderable": false
			}, {
				"targets": 2,
				"orderable": false
			}]
		});
		dt.on('order search', function () {
			dt.column(0, { search: 'applied', order: 'applied' }).nodes().each(function (cell, i) {
				cell.innerHTML = i + 1;
			});
		}).draw();
}

$('#btnFiterSubmitSearch').click(function(){

	var start_date = $('#start_date').val();
    var end_date = $('#end_date').val();
    var event_id = $('#event_id').val();
	
	//alert(start_date);
	//alert(event_id);
	updateDatatable(start_date, end_date, event_id);
	
});