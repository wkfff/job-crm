function complain_table(){
    var dataTable = $('#complain_table').DataTable({
        "ordering": false,
        "processing":true,
        "serverSide":true,
        "ajax":{
            url:"dashboard/complain_get/",
            type: "POST"

        },
        "columnDefs":[
            {
                "targets":[1],
                "orderable":false,
                
            },
        ],
    });
}