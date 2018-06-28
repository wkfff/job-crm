$(document).ready(function () {
    
    
    // NOTE : Get Data Kendaraan
    $.ajax({
        url: "dashboard/kendaraan_get",
        type: "GET",
        dataType: "JSON",
        success: function (data) {
            var len = data.length;

            $('#golongan').empty();
            $('#golongan').append('<option disabled selected>Pilih Golongan...</option>');
            for (var i = 0; i < len; i++) {
                var id = data[i]['id_gol'];
                var name = data[i]['alias'];
                $('#golongan').append('<option value=' + id + '>' + name + '</option>');
            }
        }
    });



    // NOTE : Get Data Kapal
    $.ajax({
        url: "dashboard/ship_get",
        type: "GET", 
        dataType: "JSON",
        success: function (data) {
            var len = data.length;

            $('#nama_kapal_complain1').append('<option disabled selected value=""> Pilih Kapal... </option>');
            for (var i = 0; i < len; i++) {
                var id = data[i]['id_kapal'];
                var name = data[i]['nama_kapal'];
                $('#nama_kapal_complain1').append('<option value=' + id + '>' + name + '</option>');
            }

            $('#nama_kapal_complain1').selectize({
                dropdownParent: 'body'
            });
        }
    });
    

    //NOTE : Datepicker Loader
    jQuery.datetimepicker.setLocale('id');

       //TODO : Date Picker di bagian laporan
    jQuery('#tgl_awal').datetimepicker({
        format: 'Y-m-d',
        //        maxDate: 0,
        onShow: function (ct) {
            this.setOptions({
                maxDate: jQuery('#tgl_akhir').val() ? jQuery('#tgl_akhir').val() : false
            })
        },
        timepicker: false, // use timepicker

        scrollInput: false

    });

    jQuery('#tgl_akhir').datetimepicker({
        format: 'Y-m-d',
        onShow: function (ct) {
            this.setOptions({
                minDate: jQuery('#tgl_awal').val() ? jQuery('#tgl_awal').val() : false
            })
        },
        timepicker: false, // use timepicker
        //        maxDate: 0,
        scrollInput: false

    });
});









