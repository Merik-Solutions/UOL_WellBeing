$(document).ready(function () {
    $("#datatable").DataTable();
    var a = $("#datatable-buttons").DataTable({
        lengthChange: !1,
        buttons: ["copy","csv", "excel", "print"],
        keys: !0,
        // "bInfo": false, //Dont display info e.g. "Showing 1 to 4 of 4 entries"
        // "paging": false,//Dont want paging
        // "bPaginate": false,//Dont want paging
    });
    var b = $(".datatables").DataTable({
        lengthChange: !1,
        buttons: ["copy", "excel", "print"],
        keys: !0,
        // "bInfo": false, //Dont display info e.g. "Showing 1 to 4 of 4 entries"
        // "paging": false,//Dont want paging
        // "bPaginate": false,//Dont want paging
    });
    $("#key-table").DataTable({ keys: !0 }),
        $("#responsive-datatable").DataTable(),
        $("#selection-datatable").DataTable({ select: { style: "multi" } }),
        a
            .buttons()
            .container()
            .appendTo("#datatable-buttons_wrapper .col-md-6:eq(0)");
    b
        .buttons()
        .container()
        .appendTo("#datatable-buttons_wrapper .col-md-6:eq(0)");
});
setTimeout(function () {

    $(".dataTable").css("width", "100%");
}, 300)

