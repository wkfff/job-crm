var search = null;
$(document).ready(function () {

    $('#cariLintasan').keyup(function () {
        var cari = $('#cariLintasan').val();
        if (cari == '')
            cari = null;
        $('#tabelLintasan').dataTable().fnDestroy();
        tabelLintasan(cari); 
    });



});

//NOTE : Lintasan - Input - Button Tambah Lintasan
function addLintasan() {
    $('.tabelLintasan').hide();
    $('.tambahLintasan').fadeIn();
}

//NOTE : Lintasan - Input - Button Cancel Tambah
function addLintasanX() {
    $('.reset').click();
    $('.tambahLintasan').hide();
    $('.tabelLintasan').fadeIn();
}

//NOTE : Lintasan - Input - Fungsi Tambah Lintasan
function inputLintasan() {
    if (confirm('Apakah anda Yakin?')) {
        var pelabuhan_asal = $('#pelabuhan_asal').val();
        var pelabuhan_tujuan = $('#pelabuhan_tujuan').val();
        var jarak = $('#jarak').val();
        var poin = $('#poin').val();

        $('#btn_addLintasan').prop('disabled', true);
        $('#btn_addLintasan').val('Saving..');

        $.ajax({
            dataType: 'JSON',
            type: 'POST',
            url: 'setting/lintasan_input',
            data: {
                id_daerah_asal: pelabuhan_asal,
                id_daerah_tujuan: pelabuhan_tujuan,
                jarak: jarak,
                poin: poin
            },
            success: function (response) {
                notifSukses('Data lintasan berhasil ditambahkan');
                $('#tabelLintasan').dataTable().fnDestroy();
                tabelLintasan(null);
                $('#btn_addLintasan').prop('disabled', false);
                $('#btn_addLintasan').val('Tambah');
                addLintasanX();
                return false;
            },
            error: function () {
                notifGagal('Data lintasan gagal ditambahkan');
                $('#btn_addLintasan').prop('disabled', false);
                $('#btn_addLintasan').val('Tambah');
                $('.reset').click();
                return false;
            }
        });

    } else {
        return false; 
    }
}

//NOTE : Lintasan - Fungsi Del Lintasan
function delLintasan(id) {

    if (confirm('Apakah anda yakin menghapus data ini ?')) {
        $.ajax({
            type: 'POST',
            url: 'setting/lintasan_del',
            data: {
                id: id
            },
            success: function (response) {
                notifSukses('<strong>Sukses!</strong> Data berhasil dihapus');
                $('#tabelLintasan').dataTable().fnDestroy();
                tabelLintasan(null);

            },
            error: function (response) {
                notifGagal('<strong>Gagal!</strong> Data gagal dihapus ');
            }
        });
    } else {
        return false;
    }

}

//NOTE : Lintasan - Update - Funsgi edit Lintasan
function editLintasan(id, daerah_asal, daerah_tujuan, poin, jarak) {
    $('#id_lintasan').val(id);
    $('#pelabuhan_asal_u').val(daerah_asal);
    $('#pelabuhan_tujuan_u').val(daerah_tujuan);
    $('#poin_u').val(poin);
    $('#jarak_u').val(jarak);

    $('.tabelLintasan').hide();
    $('.updateLintasan').fadeIn();
}

//NOTE : Lintasan - Update - button cancel
function updateLintasanX() {
    $('.reset_u').click();
    $('.updateLintasan').hide();
    $('.tabelLintasan').fadeIn();
}

//NOTE : Lintasan - Update - fungsi Update Lintasan
function updateLintasan() {
    var id = $('#id_lintasan').val();
    var pelabuhan_asal = $('#pelabuhan_asal_u').val();
    var pelabuhan_tujuan = $('#pelabuhan_tujuan_u').val();
    var jarak = $('#jarak_u').val();
    var poin = $('#poin_u').val();

    $('#btn_updateLintasan').prop('disabled', true);
    $('#btn_updateLintasan').val('Saving..');

    $.ajax({
        dataType: 'JSON',
        type: 'POST',
        url: 'setting/lintasan_update',
        data: {
            id: id,
            id_daerah_asal: pelabuhan_asal,
            id_daerah_tujuan: pelabuhan_tujuan,
            jarak: jarak,
            poin: poin
        },
        success: function (response) {
            notifSukses('Data lintasan berhasil diupdate');
            $('#tabelLintasan').dataTable().fnDestroy();
            tabelLintasan(null);
            $('#btn_updateLintasan').prop('disabled', false);
            $('#btn_updateLintasan').val('Update');
            updateLintasanX();
            return false;
        },
        error: function () {
            notifGagal('Data lintasan gagal diupdate');
            $('#btn_updateLintasan').prop('disabled', false);
            $('#btn_updateLintasan').val('Update');
            $('.reset').click();
            return false;
        }
    });

}

//NOTE : Loyalty - Input - Button Tambah Loyalty
function addLoyalty() {
    $('.tabelLoyalty').hide();
    $('.tambahLoyalty').fadeIn();
}

//NOTE : Loyalty - Input - Button Cancel Tambah
function addLoyaltyX() {
    $('.reset').click();
    $('.tambahLoyalty').hide();
    $('.tabelLoyalty').fadeIn();
}

//NOTE : Loyalty - Input - Fungsi Tambah Loyalty
function inputLoyalty() {
    if (confirm('Apakah anda Yakin?')) {
        var tipe_loyalty = $('#tipe_loyalty').val();
        var nama_loyalty = $('#nama_loyalty').val();
        var max_loyalty = $('#max_loyalty').val();
        var keterangan_loyalty = $('#keterangan_loyalty').val();

        $('#btn_addLoyalty').prop('disabled', true);
        $('#btn_addLoyalty').val('Saving..');

        $.ajax({
            dataType: 'JSON',
            type: 'POST',
            url: 'setting2/loyalty_input',
            data: {
                tipe: tipe_loyalty,
                nama: nama_loyalty,
                max: max_loyalty,
                keterangan: keterangan_loyalty
            },
            success: function (response) {
                notifSukses('Data loyalty berhasil ditambahkan');
                $('#tabelLoyalty1').dataTable().fnDestroy();
                tabelLoyalty1(null);
                $('#tabelLoyalty2').dataTable().fnDestroy();
                tabelLoyalty2(null);
                $('#tabelLoyalty3').dataTable().fnDestroy();
                tabelLoyalty3(null);
                $('#btn_addLoyalty').prop('disabled', false);
                $('#btn_addLoyalty').val('Tambah');
                addLoyaltyX();
                return false;
            },
            error: function () {
                notifGagal('Data loyalty gagal ditambahkan');
                $('#btn_addLoyalty').prop('disabled', false);
                $('#btn_addLoyalty').val('Tambah');
                $('.reset').click();
                return false;
            }
        });

    } else {
        return false;
    }
}

//NOTE : Loyalty - Order up
function orderUp(tipe, id, order) {
    if (confirm('Apakah anda Yakin?')) {

        $.ajax({
            dataType: 'JSON',
            type: 'POST',
            url: 'setting2/loyalty_order_up',
            data: {
                tipe: tipe,
                id: id,
                order: order
            },
            success: function (response) {
                notifSukses('<strong>Sukses!</strong> Data loyalty berhasil di order');
                if (tipe == 'jarak') {
                    $('#tabelLoyalty1').dataTable().fnDestroy();
                    tabelLoyalty1(null);
                } else if (tipe == 'trip') {
                    $('#tabelLoyalty2').dataTable().fnDestroy();
                    tabelLoyalty2(null);
                } else if (tipe == 'poin') {
                    $('#tabelLoyalty3').dataTable().fnDestroy();
                    tabelLoyalty3(null);
                }
                return false;
            },
            error: function () {
                notifGagal('<strong>Gagal!</strong> Data loyalty gagal di order');
                return false;
            }
        });

    } else {
        return false;
    }
}

//NOTE : Loyalty - Order Down
function orderDown(tipe, id, order) {
    if (confirm('Apakah anda Yakin?')) {

        $.ajax({
            dataType: 'JSON',
            type: 'POST',
            url: 'setting2/loyalty_order_down',
            data: {
                tipe: tipe,
                id: id,
                order: order
            },
            success: function (response) {
                notifSukses('Data loyalty berhasil di order');
                if (tipe == 'jarak') {
                    $('#tabelLoyalty1').dataTable().fnDestroy();
                    tabelLoyalty1(null);
                } else if (tipe == 'trip') {
                    $('#tabelLoyalty2').dataTable().fnDestroy();
                    tabelLoyalty2(null);
                } else if (tipe == 'poin') {
                    $('#tabelLoyalty3').dataTable().fnDestroy();
                    tabelLoyalty3(null);
                }
                return false;
            },
            error: function () {
                notifGagal('Data loyalty gagal di order');
                return false;
            }
        });

    } else {
        return false;
    }
}

//NOTE : Loyalty - Loyalty del 
function delLoyalty(id, tipe) {

    if (confirm('Apakah anda yakin menghapus data ini ?')) {
        $.ajax({
            type: 'POST',
            url: 'setting2/loyalty_del',
            data: {
                id: id
            },
            success: function (response) {
                notifSukses('<strong>Sukses!</strong> Data berhasil dihapus');
                if (tipe == 'jarak') {
                    $('#tabelLoyalty1').dataTable().fnDestroy();
                    tabelLoyalty1(null);
                } else if (tipe == 'trip') {
                    $('#tabelLoyalty2').dataTable().fnDestroy();
                    tabelLoyalty2(null);
                } else if (tipe == 'poin') {
                    $('#tabelLoyalty3').dataTable().fnDestroy();
                    tabelLoyalty3(null);
                }

            },
            error: function (response) {
                notifGagal('<strong>Gagal!</strong> Data gagal dihapus ');
            }
        });
    } else {
        return false;
    }

}

//NOTE : Loyalty - Update - Funsgi edit Loyalty
function editLoyalty(id, tipe, max_poin, nama, keterangan) {
    $('#id_loyalty').val(id);
    $('#tipe_loyalty_u').val(tipe);
    $('#nama_loyalty_u').val(nama);
    $('#max_loyalty_u').val(max_poin);
    $('#keterangan_loyalty_u').val(keterangan);

    $('.tabelLoyalty').hide();
    $('.updateLoyalty').fadeIn();
}

//NOTE : Loyalty - Update - button cancel
function updateLoyaltyX() {
    $('.reset_u').click();
    $('.updateLoyalty').hide();
    $('.tabelLoyalty').fadeIn();
}

//NOTE : Loyalty- Update - fungsi Update Loyalty
function updateLoyalty() {
    var id = $('#id_loyalty').val();
    var tipe = $('#tipe_loyalty_u').val();
    var nama = $('#nama_loyalty_u').val();
    var max_poin = $('#max_loyalty_u').val();
    var keterangan = $('#keterangan_loyalty_u').val();

    $('#btn_updateLoyalty').prop('disabled', true);
    $('#btn_updateLoyalty').val('Saving..');

    $.ajax({
        dataType: 'JSON',
        type: 'POST',
        url: 'setting2/loyalty_update',
        data: {
            id: id,
            tipe: tipe,
            nama: nama,
            max: max_poin,
            keterangan: keterangan
        },
        success: function (response) {
            notifSukses('<strong>Sukses!</strong> Data loyalty berhasil diupdate');
            
            $('#tabelLoyalty1').dataTable().fnDestroy();
            tabelLoyalty1(null);
            $('#tabelLoyalty2').dataTable().fnDestroy();
            tabelLoyalty2(null);
            $('#tabelLoyalty3').dataTable().fnDestroy();
            tabelLoyalty3(null);
            
            $('#btn_updateLoyalty').prop('disabled', false);
            $('#btn_updateLoyalty').val('Update');
            updateLoyaltyX();
            return false;
        },
        error: function () {
            notifGagal('<strong>Gagal!</strong> Data loyalty gagal diupdate');
            $('#btn_updateLoyalty').prop('disabled', false);
            $('#btn_updateLoyalty').val('Update');
            $('.reset').click();
            return false;
        }
    });

}



//NOTE : Prevent Submit form
$("#formTambahLintasan").on("submit", function (e) {
    e.preventDefault();
});

$("#formUpdateLintasan").on("submit", function (e) {
    e.preventDefault();
});

$("#formTambahLoyalty").on("submit", function (e) {
    e.preventDefault();
});

$("#formUpdateLoyalty").on("submit", function (e) {
    e.preventDefault();
});
