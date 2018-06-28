PNotify.prototype.options.styling = "bootstrap3";

/*--------------------------       v_main      --------------------------*/



// NOTE : tripCustomer() Fungsi mengambil nama pelabuhan
function tripCustomer(id) {
    $('#id_customer').val(id);
    select = $('#daerah_asal');

    $.ajax({
        url: "dashboard/port_get",
        type: "GET",
        dataType: "JSON",
        success: function (data) {
            var len = data.length;

            select.empty();
            select.append('<option disabled selected value="">Pilih Pelabuhan Asal ...</option>');
            for (var i = 0; i < len; i++) {
                var id = data[i]['id'];
                var name = data[i]['nama_asal'];
                select.append('<option value=' + id + '>' + name + '</option>');
            }
            select.selectize({

                dropdownParent: 'body'
            });
            // $('#daerah_tujuan').selectize();    

        }
    });
}

// NOTE : findJadwal() fungsi untuk mengambil jadwal atau rute perjalanan
function findJadwal() {
    id = $('#daerah_asal').val();
    select = $('#daerah_tujuan');
    $.ajax({
        url: "dashboard/port_jadwal/" + id,
        type: "GET",
        dataType: "JSON",
        success: function (data) {
            var len = data.length;

            select.empty();
            select.append('<option disabled selected>Pilih Pelabuhan Tujuan ...</option>');
            for (var i = 0; i < len; i++) {
                var id = data[i]['id_daerah_tujuan'];
                tripCustomer2(id);
            }

        }
    });
}

// NOTE : isNumberKey() keyboard aplha disabled
function isNumberKey(evt) {
    var charCode = (evt.which) ? evt.which : event.keyCode;

    if (charCode > 31 && (charCode < 48 || charCode > 57))
        return false;
    return true;
}



// NOTE : hari check
function hariCheck(val) {
    var hari;
    switch (val) {
        case '01':
            hari = '1';
            break;
        case '02':
            hari = '2';
            break;
        case '03':
            hari = '3';
            break;
        case '04':
            hari = '4';
            break;
        case '05':
            hari = '5';
            break;
        case '06':
            hari = '6';
            break;
        case '07':
            hari = '7';
            break;
        case '08':
            hari = '8';
            break;
        case '09':
            hari = '9';
            break;
        default:
            hari = val;
            break;
    }

    return hari;
}

// NOTE : menentukan bulan
function bulanCheck(val) {
    var bulan;
    switch (val) {
        case '01':
            bulan = 'Januari';
            break;
        case '02':
            bulan = 'Februari';
            break;
        case '03':
            bulan = 'Maret';
            break;
        case '04':
            bulan = 'April';
            break;
        case '05':
            bulan = 'Mei';
            break;
        case '06':
            bulan = 'Juni';
            break;
        case '07':
            bulan = 'Juli';
            break;
        case '08':
            bulan = 'Agustus';
            break;
        case '09':
            bulan = 'September';
            break;
        case '10':
            bulan = 'Oktober';
            break;
        case '11':
            bulan = 'November';
            break;
        case '12':
            bulan = 'Desember';
            break;
    }

    return bulan;
}

// NOTE : Menampilkan medsos
function showMedsosName() {
    $(".d_namamedsos").fadeIn();
}

/*--------------------------       v_main      --------------------------*/


/*--------------------------       v_useradm      --------------------------*/

// NOTE : del user
function delUser(id) {
    var check = confirm("Apakah anda yakin menghapus data tersebut?");

    if (check === true) {
        var id = id;
        $.ajax({
            type: 'POST',
            url: 'dashboard/user_del/' + id,
            data: 'id=' + id,
            success: function (html) {
                $(".del_" + id).fadeOut('slow');

            }
        });
        notifSukses('<strong>Sukses!</strong> Data user berhasil dihapus');
    } else {
        return false;
    }

}
/*--------------------------       v_useradm      --------------------------*/


/*--------------------------       v_main - content2      --------------------------*/


// NOTE : Area Kapal
function areaKapal() {
    var area = $('#area_complain1').val();
    var element = $('.nama_kapal_complain1');

    if (area == 'Kapal') {
        element.fadeIn();
    } else {
        element.fadeOut();
    }
}

// NOTE : Divisi - cek cabang pusat atau bukan
function cabangDivisi() {
    var cabang = $('#cabang_complain1').val();
    var ele1 = $('.area');
    var ele2 = $('.divisi');

    if (cabang == 110) {
        ele1.hide();
        ele2.fadeIn();
    } else {
        ele2.hide();
        ele1.fadeIn();
    }
}

// NOTE : Complain
function complain(id, nama, userid) {
    var element = $('.complain1');

    element.fadeIn();

    $('html, body').animate({
        scrollTop: $('.complain1').offset().top
    }, 500);

    $('#loading1').addClass('loader');
    $('#nama_complain1').text(nama);
    $('#idCustomer_complain1').val(id);
    $('#useridCustomer_complain1').val(userid);
    $('#v_idCustomer_complain1').text(userid);
    $('#loading1').removeClass('loader');
}

// NOTE : fungsi get date
function tanggal() {
    var today = new Date();
    var dd = today.getDate();
    var mm = today.getMonth() + 1; //January is 0!

    var yyyy = today.getFullYear();
    if (dd < 10) {
        dd = '0' + dd;
    }
    if (mm < 10) {
        mm = '0' + mm;
    }
    today = dd + '' + mm + '' + yyyy;

    return today;
}
//fungsi get date

//NOTE : fungsi plus date
function addDays(days) {
    var result = new Date();
    result.setDate(result.getDate() + days);
    return result;
}
//fungsi plus date

//NOTE : Complain Add
function complain_add() {
    var now = new Date();

    $('#addComplainForm').hide();
    $('#loading1').addClass('loader');
    var id_customer = $('#idCustomer_complain1').val();
    var userid = $('#useridCustomer_complain1').val();
    //  var tgl = tanggal();

    var id_cabang = $('#cabang_complain1').val();
    var prioritas = $('#prioritas_complain1').val();

    var tgl = now.getFullYear() + '-' + now.getMonth() + '-' + now.getDate();
    var tgl_batas = "DATE_ADD('" + tgl + "', INTERVAL " + prioritas + " DAY)";
    
//    console.log(tgl_batas);
    var divisi = null;
    if (id_cabang == 110) {
        divisi = $('#divisi_complain1').val();
    } else {
        divisi = 0;
    }

    var area = $('#area_complain1').val();
    var kapal = '-';
    if (area == "Kapal") {
        kapal = $('#nama_kapal_complain1').val();
    }

    var kategori = $('#kategori_complain1').val();
    var isi = $('#isi_complain1').val();

    var creator = $('#creator_complain1').val();

    var tiket = userid.substring(0, 6) + now.getHours() + now.getMinutes() + now.getSeconds() + kategori.substring(0, 1) + area.substring(0, 1) + creator.substring(0, 1);
    try {
        $.ajax({
            dataType: 'JSON',
            type: 'POST',
            url: 'dashboard/complain_input/' + id_cabang + '/' + tiket + '/' + divisi,
            data: {
                id_customer: id_customer, 
                tiket: tiket,
                id_cabang: id_cabang,
                area: area,
                id_kapal: kapal,
                kategori: kategori,
                prioritas: prioritas,
                isi_komplain: isi,
                id_divisi: divisi,
                created_by: creator
            },

            success: function (res) {
//                console.log(data);
                notifSukses('Data complain berhasil ditambahkan');
                
                $('#isi_complain1').val("");
                $('#loading1').removeClass('loader');
                $('#addComplainForm').show();
                $('#tabelComplain').dataTable().fnDestroy();
                complain_table();
            },
            error: function (xhr, ajaxOptions, thrownError) {
                alert(xhr.status);
                alert(thrownError);
            }
        });
    } catch (err) {
        notifGagal('<strong>Gagal!</strong> Terjadi Kesalahan!');
    }


}


//NOTE : Complain - detail
function complain_detail(id) {

    $('#info_complain2').hide();
    $('.detailComplain').hide();
    $('#info_konfirm').hide();
    $('#info_konfirm2').hide();
    $('#info_konfirm3').hide();
    $('.keterangan').fadeIn();
    $('#info_keterangan').fadeIn();
    $('#detailComplain').addClass('loader');
    $('html, body').animate({
        scrollTop: $('#detailComplain').offset().top
    }, 500);


    $.ajax({
        url: "dashboard/complain_find/" + id, 
        type: "GET",
        dataType: "JSON",
        success: function (data) {

            $('#userid_complain2').text(data.userid);
            $('#tiket_complain2').val(data.tiket);
            $('#nama_complain2').val(data.nama);
            $('#tgl_complain2').val(data.tgl_komplain);
            $('#cabang_complain2').val(data.cabang);
            $('#area_complain2').val(data.area);
            $('#kapal_complain2').val(data.kapal);
            $('#kategori_complain2').val(data.kategori);

            $('#isi_complain2').val(data.isi_komplain);
            $('#confirm').val(data.id_komplain);
            $('#confirm_tiket').val(data.tiket);
            $('#arsip').val(data.id_komplain);
            
            // TODO : Link Lampiran
            $('.link_lampiran').show();
            $('.link_lampiran').attr("action",'././upload/footage_branch/' + data.footage_cabang);
            $('.text_lampiran').text(data.footage_cabang);
            var str = data.footage_cabang;
            if(str != null){
                var split = str.split(".");

                if(split[1] == "JPG" || split[1] == "PNG" || split[1] == "png" || split[1] == "jpg" | split[1] == "JPEG" || split[1] == "jpeg"){
                    $('.img_lampiran').show();
                    $('.img_lampiran').attr("src",'././upload/footage_branch/'+ data.footage_cabang);
                }else{
                    $('.img_lampiran').hide();
                }
            }else{
                $('.text_lampiran').text('Tidak ada');
                 $('.link_lampiran').hide();
                $('.img_lampiran').hide();
            }

            // TODO : Link Bukti Konfirmasi
            $('.cs_name').text(data.updated_by);
            $('.text_bukti').text(data.footage_confirm);
            $('.link_bukti').attr("action",'././upload/footage_confirm/'+ data.footage_confirm);
            var str = data.footage_confirm;
            if(str != null){
                var split = str.split(".");
                if(split[1] == "JPG" || split[1] == "PNG" || split[1] == "png" || split[1] == "jpg" | split[1] == "JPEG" || split[1] == "jpeg"){
                    $('.img_bukti').show();
                    $('#audio_bukti').hide();
                    $('.img_bukti').attr("src",'././upload/footage_confirm/'+ data.footage_confirm);
                }else if(split[1] == "mp3" || split[1] == "MP3" || split[1] == "wav" || split[1] == "WAV" || split[1] == "ogg" || split[1] == "OGG" || split[1] == "aiff" || split[1] == "AIFF"){
                    $('.img_bukti').hide();
                    $('#audio_bukti').show();
                    $('.audio_bukti').attr("src",'././upload/footage_confirm/'+ data.footage_confirm);
                    document.getElementById("audio_bukti").load(); 
//                    $('.audio_bukti').attr("type",'audio/'+split[1]);
                }else{
                    $('.img_bukti').hide();
                    $('#audio_bukti').hide();
                }
            }


            //arsip section
            $('#id_komplain_arsip').val(data.id_komplain);
            $('#tiket_arsip').val(data.tiket);
            $('#nama_arsip').val(data.nama);
            $('#cabang_arsip').val(data.cabang);
            $('#area_arsip').val(data.area);
            $('#kategori_arsip').val(data.kategori);
            $('#kapal_arsip').val(data.kapal);
            $('#prioritas_arsip').val(data.prioritas);
            $('#created_by_arsip').val(data.created_by);
            $('#finished_by_arsip').val(data.updated_by);
            $('#dif_arsip').val(data.dif * -1);
            $('#isi_arsip').val(data.isi_komplain);
            $('#tindakan_arsip').val(data.keterangan);
            $('#telp_arsip').val(data.telp);
            $('#email_arsip').val(data.email);
            $('#tgl_komplain_arsip').val(data.tgl_komplain);
            $('#tgl_cabang_arsip').val(data.branch_date);
            $('#tgl_confirm_arsip').val(data.confirm_date);
            //arsip section

            if (data.status == 2) {
                $('#info_confirm').hide();
                $('.konfirm').fadeIn();
                $('.keterangan').hide();
            } else if (data.status == 3) {
                $('.konfirm').hide();
                $('#info_confirm').fadeIn();
                $('.keterangan').fadeIn();
            } else {
                $('#info_confirm').hide();
                $('.konfirm').hide();
                $('.keterangan').hide();
            }

            //konfirm
            if (data.status == 3) {
                $('#info_konfirm2').fadeIn();
                $('#info_konfirm3').fadeIn();
                $('.keterangan').fadeIn();
            } else if (data.status == 2) {

                $('#info_konfirm').fadeIn();
                $('.keterangan').hide();
            }
            //konfirm
            
            

            if (data.status >= 2) {
                $('#info_keterangan').hide();
                $('.keterangan2').fadeIn();
                $('#keterangan_complain2').val(data.keterangan);

                //arsip section
                $('#id_komplain_arsip').val(data.id_komplain);
                $('#tiket_arsip').val(data.tiket);
                $('#nama_arsip').val(data.nama);
                $('#cabang_arsip').val(data.cabang);
                $('#area_arsip').val(data.area);
                $('#kategori_arsip').val(data.kategori);
                $('#kapal_arsip').val(data.kapal);
                $('#prioritas_arsip').val(data.prioritas);
                $('#created_by_arsip').val(data.created_by);
                $('#finished_by_arsip').val(data.updated_by);
                $('#dif_arsip').val(data.dif * -1);
                $('#isi_arsip').val(data.isi_komplain);
                $('#tindakan_arsip').val(data.keterangan);
                $('#telp_arsip').val(data.telp);
                $('#email_arsip').val(data.email);
                $('#tgl_komplain_arsip').val(data.tgl_komplain);
                $('#tgl_cabang_arsip').val(data.branch_date);
                $('#tgl_confirm_arsip').val(data.confirm_date);
                //arsip section

            } else {
                $('.keterangan2').hide();
                $('#info_keterangan').fadeIn();
                $('#keterangan_complain2').val('');
            }

            // progress bar
            var str = '';
            var diff = data.dif;
            var dif = data.dif;
            if (diff < 0) {
                diff = 1;

                dif = data.dif * -1;
                str = '+' + dif + ' hari';
            } else if (diff == 0) {
                diff = 1;
                str = 'deadline';
            } else {
                str = dif + ' hari';
            }

            var batas = 100 / diff;

            var bar = '';

            if (batas <= 40) {
                bar = 'progress-bar-info';
            } else if (batas <= 70) {
                bar = 'progress-bar-warning';
            } else {
                bar = 'progress-bar-danger';
            }



            $('#progress_complain2').text(str);
            $('#progress_complain2').removeClass('progress-bar-info');
            $('#progress_complain2').removeClass('progress-bar-warning');
            $('#progress_complain2').removeClass('progress-bar-danger');
            $('#progress_complain2').addClass(bar);
            $('#progress_complain2').css('width', batas + '%');
            // progress bar
            $('#detailComplain').removeClass('loader');
            $('.detailComplain').fadeIn();
        }



    });



}


// NOTE : Del Komplain
function complain_del(id) {
    var check = confirm("Apakah anda yakin menghapus data tersebut?");

    if (check === true) {
        var id = id;
        $.ajax({
            type: 'POST',
            url: 'dashboard/complain_del/' + id,
            data: 'id=' + id,
            success: function (html) {

                $('#complain_table').dataTable().fnDestroy();
                complain_table();
                str = '<strong>Sukses!</strong> Data komplain berhasil dihapus';

            },
            error: function (textStatus, errorThrown) {
                str = '<strong>Gagal!</strong> Terjadi Kesalahan!';
            }
        });
        notifSukses(str);
    } else {
        notifGagal('<strong>Gagal!</strong> Terjadi Kesalahan!');
    }
}
/*--------------------------       v_main - content2      --------------------------*/


//NOTE : Notification Area
function notifSukses(str) {
    new PNotify({
        title: 'Sukses!',
        text: str,
        type: 'success'
    });
}

function notifGagal(str) {
    new PNotify({
        title: 'Gagal!',
        text: str,
        type: 'error'
    });
}


//NOTE : Modal change pass - reset
function reset(){
    $('#oldpass').val('');
    $('#newpass').val('');
    $('#repass').val('');
}

function passCheck(){
    var oldpass = $('#oldpass').val();
    var newpass = $('#newpass').val();
    var repass = $('#repass').val();
    
    if(newpass == repass && newpass != ''){
        $('#repass').removeClass('form-error');
        $('#repass').addClass('form-success');
    }else if(newpass != repass && newpass != ''){
        $('#repass').removeClass('form-success');
        $('#repass').addClass('form-error');
    }else{
        $('#repass').removeClass('form-success');
        $('#repass').removeClass('form-error');
    }
}