$(document).ready(function () {
//    $(".container-fluid").addClass("m-0 p-0");
    // $(".container-fluid").css({ width: "100vw" });
    // $(".wrapper").css("padding-top", "118px");
    updateDatatable();
});

function updateDatatable() {
    let dt = $('#scheduleDatatable').DataTable({
        "serverSide": true,
        "destroy": true,
        "autoWidth": false,
        "searching": true,
        "aaSorting": [[1, "desc"]],
        "nowrap": true,
        "ajax": {
            type: "GET",
            url: siteUrl + `/api/settings/schedule/list`,
        },
        "columnDefs": [{
            "targets": 0,
            "orderable": false
        }, {
            "targets": 3,
            "orderable": false
        }]
    });
    dt.on('order search', function () {
        dt.column(0, { search: 'applied', order: 'applied' }).nodes().each(function (cell, i) {
            cell.innerHTML = i + 1;
        });
    }).draw();
}