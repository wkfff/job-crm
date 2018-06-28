
function history_table(id){
    var dataTable = $('#historyCustomerTrip').DataTable({
        "processing":true,
        "serverSide":true,
        "order":[],
        "ajax":{
            url:"serverProcessing/tabelhistorytrip/get_data/"+id,
            type: "POST"

        },
        "columnDefs":[
            {
                "targets":[0],
                "orderable":false,
            },
            {
                "targets":[8],
                "orderable":false,
            },
        ],
    });
}