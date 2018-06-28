$(document).ready(function () {
    tabelArsip('semua','semua','semua');
} );

function tabelArsip(optCabang,optArea,optKategori){
    table = $('#tabelArsip').DataTable({

        "processing": true,
        "serverSide": true,
        "order": [],

        "ajax": {
            "url": "serverProcessing/tabelArsip/get_data/"+optCabang+"/"+optArea+"/"+optKategori,
            "type": "POST"
        },


        "columnDefs": [
            
            {
                "targets": [9],
                "orderable": false,
            },
            ],

    });
}