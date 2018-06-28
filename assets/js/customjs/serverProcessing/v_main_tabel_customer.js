/////////////////////////////////////////////////////////////////////////////////////////////

var table;


$(document).ready(function () {

    // NOTE : init tabel customer
    customerTable();

    // NOTE : Bulk Delete
    $("#bulkDelete").on('click', function () { // bulk checked
        var status = this.checked;
        if (status) {
            $("#delCustomer_btn").removeClass('disabled');
        } else {
            $("#delCustomer_btn").addClass('disabled');
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
        var $chkbox_select_all = $('thead input[name="select_all"]', $table).get(0);
        var del_button = $('#delCustomer_btn');

        //FUTURE: If none of the checkboxes are checked
        if ($chkbox_checked.length === 0) {
            $chkbox_select_all.checked = false;
            if ('indeterminate' in $chkbox_select_all) {
                $chkbox_select_all.indeterminate = false;
                del_button.addClass('disabled');
            }

            //FUTURE: If all of the checkboxes are checked
        } else if ($chkbox_checked.length === $chkbox_all.length) {
            $chkbox_select_all.checked = true;
            if ('indeterminate' in $chkbox_select_all) {
                $chkbox_select_all.indeterminate = false;
                del_button.removeClass('disabled');
            }

            //FUTURE: If some of the checkboxes are checked
        } else {
            $chkbox_select_all.checked = true;
            if ('indeterminate' in $chkbox_select_all) {
                $chkbox_select_all.indeterminate = true;
                del_button.removeClass('disabled');
            }
        }
    }

    $('#tabelCustomer tbody').on('click', 'input[type="checkbox"]', function (e) {
        // Update state of "Select all" control
        table = $('#tabelCustomer').DataTable();
        updateDataTableSelectAllCtrl(table);
        //        console.log('mountain');
        // Prevent click event from propagating to parent
        e.stopPropagation();
    });

    $('#delCustomer_btn').on("click", function (event) { // triggering delete one by one

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
                    url: "dashboard/customer_del_bulk",
                    data: {
                        data_ids: ids_string
                    },
                    success: function (result) {
                        var chkbox_select_all = $('thead input[name="select_all"]', $('#tabelCustomer')).get(0);
                        var del_button = $('#delCustomer_btn');

                        chkbox_select_all.checked = false;
                        chkbox_select_all.indeterminate = false;
                        del_button.addClass('disabled');
                        notifSukses('<strong>Sukses!</strong> Data berhasil dihapus');
                        $('#tabelCustomer').dataTable().fnDestroy();
                        customerTable();
                    },
                    async: false
                });
            }
        } else {
            return false;
        }
    });



});
///////////////////////////////////////////////////////////////////////////////////////////

// NOTE : Del Customer
function delCustomer(id) {

    if (confirm('Apakah anda yakin menghapus data ini ?')) {
        $.ajax({
            type: 'POST',
            url: 'dashboard/customer_del/' + id,
            data: 'id=' + id,
            success: function (html) {
                notifSukses('<strong>Sukses!</strong> Data berhasil dihapus');
                $('#tabelCustomer').dataTable().fnDestroy();
                customerTable();

            },
            error: function (html) {
                notifGagal('<strong>Gagal!</strong> Data gagal dihapus ');
            }
        });
    } else {
        return false;
    }

}

// NOTE : Tabel Customer
function customerTable() {
    $('#tabelCustomer').DataTable({

        "processing": true,
        "serverSide": true,
        "order": [],

        "ajax": {
            "url": "serverProcessing/tabelCustomer/get_data",
            "type": "POST"
        },


        "columnDefs": [
            {
                "targets": [0],
                "orderable": false,
            },
            {
                "targets": [8],
                "orderable": false,
            },
            ],

    });
}
