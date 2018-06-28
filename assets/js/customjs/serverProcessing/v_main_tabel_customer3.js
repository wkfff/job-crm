$(document).ready(function () {
table = $('#tabelCustomer3').DataTable({

        "processing": true,
        "serverSide": true,
        "order": [],

        "ajax": {
            "url": "serverProcessing/tabelCustomer3/get_data",
            "type": "POST"
        },


        "columnDefs": [
            
            {
                "targets": [5],
                "orderable": false,
            },
            ],

    });
} );