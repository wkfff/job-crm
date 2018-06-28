$(document).ready(function () {
    complain_table();
});

function complain_table() {
        table = $('#tabelComplain').DataTable({

            "processing": true,
            "serverSide": true,
            "order": [],

            "ajax": {
                "url": "serverProcessing/tabelComplain/get_data",
                "type": "POST"
            },


            "columnDefs": [

                {
                    "targets": [8],
                    "orderable": false,
            },
            ],

        });
    }