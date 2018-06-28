$(document).ready(function () {
table = $('#tabelCustomer2').DataTable({

        "processing": true,
        "serverSide": true,
        "order": [],

        "ajax": {
            "url": "serverProcessing/tabelCustomer2/get_data",
            "type": "POST"
        },


        "columnDefs": [
            
            {
                "targets": [7],
                "orderable": false,
            },
            {
                "targets": [2],
                "orderable": false,
            },
            ],

    });
} );