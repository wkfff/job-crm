$(document).ready(function () {
    tabelLoyalty1(null);
    tabelLoyalty2(null);
    tabelLoyalty3(null);
});

function tabelLoyalty1(cari){
    table = $('#tabelLoyalty1').DataTable({

        "processing": true,
        "searching" : false,
        "serverSide": true,
        "order": [],

        "ajax": {
            "url": "serverProcessing/tabelLoyalty1/get_data/"+cari,
            "type": "POST"
        },


        "columnDefs": [
            {
                "targets": [4],
                "orderable": false,
            },
            {
                "targets": [5],
                "orderable": false,
            },
            ],

    });
}

function tabelLoyalty2(cari){
    table = $('#tabelLoyalty2').DataTable({

        "processing": true,
        "searching" : false,
        "serverSide": true,
        "order": [],

        "ajax": {
            "url": "serverProcessing/tabelLoyalty2/get_data/"+cari,
            "type": "POST"
        },


        "columnDefs": [
            {
                "targets": [4],
                "orderable": false,
            },
            {
                "targets": [5],
                "orderable": false,
            },
            ],

    });
}

function tabelLoyalty3(cari){
    table = $('#tabelLoyalty3').DataTable({

        "processing": true,
        "searching" : false,
        "serverSide": true,
        "order": [],

        "ajax": {
            "url": "serverProcessing/tabelLoyalty3/get_data/"+cari,
            "type": "POST"
        },


        "columnDefs": [
            {
                "targets": [4],
                "orderable": false,
            },
            {
                "targets": [5],
                "orderable": false,
            },
            ],

    });
}