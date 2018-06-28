var table;

$(document).ready(function () { 
    tabelLintasan(null);
    
    // NOTE : Bulk Delete
    $("#bulkDelete").on('click', function () { // bulk checked
        var status = this.checked;
        if (status) {
            $("#delLintasan_btn").removeClass('disabled');
        } else {
            $("#delLintasan_btn").addClass('disabled');
        }
        $(".deleteRow").each(function () {
            $(this).prop("checked", status);
        });
    });

    //TODO : Fungsi untuk select all
    function updateDataTableSelectAllCtrl(table) {
        var $table = table.table().node();
        var $chkbox_all = $('tbody input[type="checkbox"]', $table);
        var $chkbox_checked = $('tbody input[type="checkbox"]:checked', $table);
        var chkbox_select_all = $('thead input[name="select_all"]', $table).get(0);
        var del_button = $('#delLintasan_btn');

        //FUTURE: If none of the checkboxes are checked
        if ($chkbox_checked.length === 0) {
            chkbox_select_all.checked = false;
            if ('indeterminate' in chkbox_select_all) {
                chkbox_select_all.indeterminate = false;
                del_button.addClass('disabled');
            }

            //FUTURE: If all of the checkboxes are checked
        } else if ($chkbox_checked.length === $chkbox_all.length) {
            chkbox_select_all.checked = true;
            if ('indeterminate' in chkbox_select_all) {
                chkbox_select_all.indeterminate = false;
                del_button.removeClass('disabled');
            }

            //FUTURE: If some of the checkboxes are checked
        } else {
            chkbox_select_all.checked = true;
            if ('indeterminate' in chkbox_select_all) {
                chkbox_select_all.indeterminate = true;
                del_button.removeClass('disabled');
            }
        }
    }

    $('#tabelLintasan tbody').on('click', 'input[type="checkbox"]', function (e) {
        // Update state of "Select all" control
        updateDataTableSelectAllCtrl(table);

        // Prevent click event from propagating to parent
        e.stopPropagation();
    });

    $('#delLintasan_btn').on("click", function (event) { // triggering delete one by one

        var check = confirm("Apakah anda yakin menghapus baris tersebut?");

        if (check === true) {

            if ($('.deleteRow:checked').length > 0) { // at-least one checkbox checked
                var ids = [];
                $('.deleteRow').each(function () {
                    if ($(this).is(':checked')) {
                        ids.push($(this).val());
                    }
                });
                var ids_string = ids.toString(); // array to string conversion 
                $.ajax({
                    type: "POST",
                    url: "setting/lintasan_del_bulk",
                    data: {
                        data_ids: ids_string
                    },
                    success: function (result) {
                        var chkbox_select_all = $('thead input[name="select_all"]', $('#tabelLintasan')).get(0);
                        var del_button = $('#delLintasan_btn');

                        chkbox_select_all.checked = false;
                        chkbox_select_all.indeterminate = false;
                        del_button.addClass('disabled');
                        table.draw(); // redrawing datatable
                        notifSukses('<strong>Sukses!</strong> Data Lintasan berhasil dihapus');
                    },
                    async: false
                });
            }
        } else {
            return false;
        }
    });
    
} );

function tabelLintasan(cari){
    table = $('#tabelLintasan').DataTable({

        "processing": true,
        "searching" : false,
        "serverSide": true,
        "order": [],

        "ajax": {
            "url": "serverProcessing/tabelLintasan/get_data/"+cari,
            "type": "POST"
        },


        "columnDefs": [
            {
                "targets": [0],
                "orderable": false,
            },
            {
                "targets": [5],
                "orderable": false,
            },
            ],

    });
}