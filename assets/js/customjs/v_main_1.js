$(document).ready(function () {

    // NOTE : Customer Add Form - init kewarganegaraan
    $("#warga1").prop("checked", true);

    // NOTE : Customer Add Form - Cancel
    $('#addXCustomer_btn').click(function () {
        $('#content1tab1').hide();
        $('#addCustomer_btn').fadeIn();
        $('#uploadCustomer_btn').fadeIn();
        $('#downloadCustomer_btn').fadeIn();
    });


    // NOTE : Customer Add Form - Change Job
    $('#pekerjaan').change(function () {
        var select = $('#pekerjaan').val();

        if (select === '1') {
            $('#pekerjaan2').fadeIn();
            $('#pekerjaan2').attr('required', 'TRUE');
        } else {
            $('#pekerjaan2').fadeOut();
            $('#pekerjaan2').val('-');
        }
    });

    //NOTE : Trip Add - datepicker
    jQuery.datetimepicker.setLocale('id');

    jQuery('#tgl_berangkat').datetimepicker({
        format: 'Y-m-d',
        timepicker: false, // use timepicker
        setDate: new Date(),
        maxDate: 0,
        scrollInput: false

    });

    $('#tgl_berangkat').val(formatDate());
    console.log($('#tgl_berangkat').val());

});

// NOTE : Customer Add Form - Change NIK or Pass
function noID(opsi) {
    var nik = $('#nik');
    var pass = $('#passport');
    var wni = $('.warga1');
    var wna = $('.warga2');

    if (opsi == 1) {
        pass.hide();
        pass.val('0');
        nik.val('');
        nik.fadeIn();
        wna.removeClass('active');
        $("#warga1").prop("checked", true);
        wni.addClass('active');
        console.log(pass.val());
    } else {
        nik.hide();
        nik.val('0');
        pass.val('');
        pass.fadeIn();
        wni.removeClass('active');
        $("#warga2").prop("checked", true);
        wna.addClass('active');
        console.log(pass.val());
    }
}

// NOTE : Customer Add Form - Change WNI or WNA
function noIDre(opsi) {
    var nik = $('#nik');
    var pass = $('#passport');
    var wni = $('.labelNik');
    var wna = $('.labelPass');

    if (opsi == 'WNI') {
        pass.hide();
        pass.val('0');
        nik.val('');
        nik.fadeIn();
        wna.removeClass('active');
        $("#opsiNik").prop("checked", true);
        wni.addClass('active');

    } else {
        nik.hide();
        nik.val('0');
        pass.val('');
        pass.fadeIn();
        wni.removeClass('active');
        $("#opsiPass").prop("checked", true);
        wna.addClass('active');
    }
}

// NOTE : Customer Detail - Update nik or pass
function noID2(opsi) {
    var nik = $('#d_nik');
    var pass = $('#d_passport');
    var wni = $('.d_warga1');
    var wna = $('.d_warga2');

    if (opsi == 1) {
        $('.formPass2').hide();
        $('.formNik2').fadeIn();
        pass.hide();
        pass.val('');
        nik.val('');
        nik.fadeIn();
        wna.removeClass('active');
        $("#d_warga1").prop("checked", true);
        wni.addClass('active');
    } else {
        $('.formPass2').fadeIn();
        $('.formNik2').hide();
        nik.hide();
        nik.val('0');
        pass.val('');
        pass.fadeIn();
        wni.removeClass('active');
        $("#d_warga2").prop("checked", true);
        wna.addClass('active');
    }
}

// NOTE : Customer Detail Update - Change WNI or WNA
function noIDre2(opsi) {
    var nik = $('#d_nik');
    var pass = $('#d_passport');
    var wni = $('.d_warga1');
    var wna = $('.d_warga2');

    if (opsi == 'WNI') {
        pass.hide();
        pass.val('');
        nik.val('');
        nik.fadeIn();
        wna.removeClass('active');
        $("#d_nik").prop("checked", true);
        wni.addClass('active');

    } else {
        nik.hide();
        nik.val('');
        pass.val('');
        pass.fadeIn();
        wni.removeClass('active');
        $("#opsiPass").prop("checked", true);
        wna.addClass('active');
    }
}

// NOTE : Check email
function check_email() {
    var email = $('#email').val();
    if (validateEmail(email)) {
        if (email != '') {
            $.ajax({
                type: "POST",
                url: "dashboard/check_email",
                data: "email=" + email,
                success: function (data) {
                    if (data == 0) {
                        notifSukses('Alamat email ' + email + ' belum terdaftar');
                        $('#email').removeClass('form-error');
                    } else {
                        notifGagal('Alamat email ' + email + ' sudah terdaftar!');
                        $('#email').addClass('form-error');
                    }

                }
            });
        }
    } else {
        notifGagal(email + ' bukan alamat email!');
        $('#email').val('');
    }
}

//NOTE : Validate Email
function validateEmail(sEmail) {
    var filter = /^([\w-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([\w-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$/;
    if (filter.test(sEmail)) {
        return true;
    } else {
        return false;
    }
}

// NOTE : Check NIK
function check_nik() {
    var nik = $('#nik').val();
    if (nik != '') {
        $.ajax({
            type: "POST",
            url: "dashboard/check_nik",
            data: "nik=" + nik,
            success: function (data) {
                if (data == 0) {
                    notifSukses('NIK : ' + nik + ' belum terdaftar');
                    $('#nik').removeClass('form-error');
                } else {
                    notifGagal('NIK : ' + nik + ' sudah terdaftar!');
                    $('#nik').addClass('form-error');
                }

            }
        });
    }
}

//NOTE : Check passport
function check_passport() {
    var pass = $('#passport').val();
    console.log(pass);
    if (pass != '') {
        $.ajax({
            type: "POST",
            url: "dashboard/check_pass",
            data: "passport=" + pass,
            success: function (data) {
                if (data == 0) {
                    notifSukses('No Passport : ' + pass + ' belum terdaftar');
                    $('#passport').removeClass('form-error');
                } else {
                    notifGagal('No Passport : ' + pass + ' sudah terdaftar!');
                    $('#passport').addClass('form-error');
                }

            }
        });
    }
}

// NOTE : Check No Telp
function check_telp() {
    var telp = $('#notelp').val();
    if (telp != '') {
        $.ajax({
            type: "POST",
            url: "dashboard/check_telp",
            data: "telp=" + telp,
            success: function (data) {
                if (data == 0) {
                    notifSukses('No telp : ' + telp + ' belum terdaftar');
                    $('#telp').removeClass('form-error');
                } else {
                    notifGagal('No telp : ' + telp + ' sudah terdaftar!');
                    $('#telp').addClass('form-error');
                }

            }
        });
    }
}

// NOTE : job 
function job() {
    var select = $('#d_job').val();

    if (select === '1') {
        $('#d_job2').fadeIn();
        $('#d_job2').attr('required', 'TRUE');
    } else {
        $('#d_job2').fadeOut();
        $('#d_job2').val('-');
    }
}



// NOTE : fungsi untuk menyembunyikan golongan ketika tidak berkendara
function golAnimate() {
    kendaraan = $('#kendaraan').val();
    gol = $('.golongan');
    if (kendaraan == "Tidak Berkendara") {
        gol.hide();
        $('#golongan').val('-');
    } else {
        gol.fadeIn();
    }
}





// NOTE : Customer Detail
function detailCustomer(id) {

    tripCustomer(id);

    $('#historyCustomerTrip').dataTable().fnDestroy();
    history_table(id);

    $('#info1').hide();
    $('#info2').hide();
    $('#formPerjalanan').fadeIn();
    $('#tabel_perjalanan').fadeIn();
    $('.fourth4').addClass('tinggi');

    $('.detailCustomer').hide();
    $('.formUpdate').hide();
    $('.detailCustomerBtn2').hide();
    $('.d_namamedsos').hide();

    $('.formDetail').fadeIn();

    $('html, body').animate({
        scrollTop: $('#detailCustomer').offset().top
    }, 500);

    $('#detailCustomer').addClass('loader');

    $.ajax({
        url: "dashboard/customer_get/" + id,
        type: "GET",
        dataType: "JSON",
        success: function (data) {

            //FUTURE : Reset Data for init
            $('#d_nik').val('');
            $('#d_passport').val('');

            $('#d_id').val(data.id);
            $('#d_userid').text(data.userid);

            nik = data.nik;
            pass = data.passport;

            if (nik != null && pass == null) {
                $('#d_niktext').text(data.nik);
                $('#d_nik').val(data.nik);
                $('.formPass1').hide();
                $('#d_nik_radio').prop("checked", true);
                $('.d_nik_radio').addClass("active");
                $('.d_pass_radio').removeClass("active");
            } else if (nik == null && pass != null) {
                $('#d_passtext').text(data.passport);
                $('#d_passport').val(data.passport);
                $('.formNik1').hide();
                $('#d_pass_radio').prop("checked", true);
                $('.d_pass_radio').addClass("active");
                $('.d_nik_radio').removeClass("active");
            } else {
                if (data.warga == 'WNI') {
                    $('.formPass1').hide();
                    $('#d_nik').val('');
                    $('#d_niktext').text("-");
                } else {
                    $('.formNik1').hide();
                    $('#d_passport').val('');
                    $('.d_passtext').text('-');
                }
            }

            $('#d_nama').val(data.nama);
            $('#d_namatext').text(data.nama);

            $('#d_telp').val(data.telp);
            $('#d_telptext').text(data.telp);

            $('#d_email').val(data.email);
            $('#d_emailtext').text(data.email);

            //tgl lahir
            var ttl = data.tgl_lahir.split("-");
            var hari = ttl[2];
            var bulan = ttl[1];
            var bulantext = bulanCheck(bulan);
            var tahun = ttl[0];
            var tempatLahir = data.tempat_lahir;
            hari = hariCheck(hari);
            $('#d_tglhari').val(hari);
            $('#d_tglbulan').val(bulan);
            $('#d_tgltahun').val(tahun);
            $('#d_tmplahir').val(tempatLahir);
            $('#d_tgltext').text(tempatLahir + ', ' + ttl[2] + '-' + bulan + '-' + tahun);
            //tgl lahir

            //Gender
            if (data.gender == 'L') {
                $('#d_gendertext').text("Laki-laki");
                $('#d_gender1').prop("checked", true);
                $('.d_gender1').addClass("active");
                $('.d_gender2').removeClass("active");
            } else {
                $('#d_gendertext').text("Perempuan");
                $('#d_gender2').prop("checked", true);
                $('.d_gender2').addClass("active");
                $('.d_gender1').removeClass("active");
            }
            //Gender

            //warga
            if (data.warga == 'WNI') {
                $('#d_wargatext').text("WNI");
                $('#d_warga1').prop("checked", true);
                $('.d_warga1').addClass("active");
                $('.d_warga2').removeClass("active");
            } else {
                $('#d_wargatext').text("WNA");
                $('#d_warga2').prop("checked", true);
                $('.d_warga2').addClass("active");
                $('.d_warga1').removeClass("active");
            }
            //warga

            $('#d_jobtext').text(data.job);
            if (jobCheck(data.job) == '0') {
                $('#d_job').prepend('<option value="' + data.job + '">' + data.job + '</option>');
            }
            $('#d_job').val(data.job);
            $('#d_companytext').text(data.perusahaan);
            $('#d_company').val(data.perusahaan);

            $('#d_alamattext').text(data.alamat);
            $('#d_alamat').val(data.alamat);

            $('#d_medsostext').text(data.sosmed);
            $('#d_namamedsostext').text(data.nama_sosmed);
            if (data.sosmed == 'Facebook') {
                $('#d_sosmed1').prop("checked", true);
                $('.d_sosmed1').addClass("active");
                $('.d_sosmed2').removeClass("active");
                $('.d_sosmed3').removeClass("active");
                $('#d_namamedsos').val(data.nama_sosmed);
                $('.d_namamedsos').fadeIn();
            } else if (data.sosmed == 'Twitter') {
                $('#d_sosmed2').prop("checked", true);
                $('.d_sosmed2').addClass("active");
                $('.d_sosmed1').removeClass("active");
                $('.d_sosmed3').removeClass("active");
                $('#d_namamedsos').val(data.nama_sosmed);
                $('.d_namamedsos').fadeIn();
            } else if (data.sosmed == 'Instagram') {
                $('#d_sosmed3').prop("checked", true);
                $('.d_sosmed3').addClass("active");
                $('.d_sosmed2').removeClass("active");
                $('.d_sosmed1').removeClass("active");
                $('#d_namamedsos').val(data.nama_sosmed);
                $('.d_namamedsos').fadeIn();
            } else {
                $('#d_sosmed1').prop("checked", false);
                $('#d_sosmed2').prop("checked", false);
                $('#d_sosmed3').prop("checked", false);
                $('.d_sosmed1').removeClass("active");
                $('.d_sosmed2').removeClass("active");
                $('.d_sosmed3').removeClass("active");
                $('#d_namamedsos').val(data.nama_sosmed);
                $('.d_namamedsos').fadeOut();
            }
            $('.detailCustomerBtn1').show();

            $('#detailCustomer').removeClass('loader');
            $('.detailCustomer').fadeIn();

        }
    });

}

// NOTE : Customer Detail - Update
function detailCustomerEdit() {

    $('.formUpdate').fadeIn();
    $('.formDetail').hide();
    $('.detailCustomerBtn1').hide();
    $('.detailCustomerBtn2').fadeIn();

    nik = $('#d_nik').val();
    pass = $('#d_passport').val();


    if (nik != '' && pass == '') {
        $('.formPass2').hide();
    } else if (nik == '' && pass != '') {
        $('.formNik2').hide();
    } else if (nik == '' && pass == '') {
        $('.formPass2').hide();
    }
}

// NOTE : Customer Detail - Cancel
function detailCustomerCancel() {
    nik = $('#d_nik').val();
    pass = $('#d_passport').val();

    $('.formUpdate').hide();
    $('.formDetail').fadeIn();
    $('.detailCustomerBtn1').fadeIn();
    $('.detailCustomerBtn2').hide();
    $('.d_namamedsos').hide();
    if (nik != '' && pass == '') {
        $('.formPass1').hide();
    } else if (nik == '' && pass != '') {
        $('.formNik1').hide();
    } else if (nik == '' && pass == '') {
        $('.formPass1').hide();
    }
}


// NOTE : Customer - Add
function addCustomer() {
    $('#content1tab1').fadeIn();
    $('html, body').animate({
        scrollTop: $("#content1tab1").offset().top
    }, 500);
    $('#addCustomer_btn').fadeOut();
    $('#uploadCustomer_btn').fadeOut();
    $('#downloadCustomer_btn').fadeOut();
}

// NOTE : Customer - Upload Data
function upload_data() {
    $('#content0tab1').fadeIn();
    $('html, body').animate({
        scrollTop: $("#content0tab1").offset().top
    }, 500);
    $('#addCustomer_btn').fadeOut();
    $('#uploadCustomer_btn').fadeOut();
    $('#downloadCustomer_btn').fadeOut();
}

// NOTE : Customer - Upload Data cancel
function uploadX() {
    $('#content0tab1').hide();
    $('#addCustomer_btn').fadeIn();
    $('#uploadCustomer_btn').fadeIn();
    $('#downloadCustomer_btn').fadeIn();
}

// NOTE : Perjalanan Add
function perjalanan_add() {

    if (confirm('Apakah anda Yakin?')) {
        var id_customer = $('#id_customer').val();
        var id_pelabuhan_asal = $('#daerah_asal').val();
        var id_pelabuhan_tujuan = $('#daerah_tujuan').val();
        //    var tgl_berangkat = $('#tahun_perjalanan').val() + '-' + $('#bulan_perjalanan').val() + '-' + $('#hari_perjalanan').val();
        var tgl_berangkat = $('#tgl_berangkat').val();
        var kendaraan = $('#kendaraan').val();
        var golongan = $('#golongan').val();
        if (kendaraan == 'Tidak Berkendara') {
            golongan = '-';
        }
        var penumpang = $('#penumpang').val();
        var penumpang_bayi = $('#penumpang2').val();

        if (id_pelabuhan_asal && id_pelabuhan_tujuan) {
            $('#btnadd_perjalanan').prop('disabled', true);
            $('#btnadd_perjalanan').val('saving..');

            $.ajax({
                dataType: 'JSON',
                type: 'POST',
                url: 'dashboard/perjalanan_input/' + id_customer,
                data: {
                    id_customer: id_customer,
                    id_pelabuhan_asal: id_pelabuhan_asal,
                    id_pelabuhan_tujuan: id_pelabuhan_tujuan,
                    tgl_berangkat: tgl_berangkat,
                    kendaraan: kendaraan,
                    golongan: golongan,
                    penumpang: penumpang,
                    penumpang_bayi: penumpang_bayi
                },
                success: function (response) {
                    console.log(response);
                    notifSukses('Data perjalanan berhasil ditambahkan');
                    $('#historyCustomerTrip').dataTable().fnDestroy();
                    history_table(id_customer);
                    $('#btnadd_perjalanan').prop('disabled', false);
                    $('#btnadd_perjalanan').val('Add');

                    var $select = $('#daerah_asal').selectize();
                    var control = $select[0].selectize;
                    control.clear();
                    tripCustomer(id_customer);
                    $('#daerah_tujuan').empty();
                    $('#daerah_tujuan').append('<option disabled selected>Pilih Pelabuhan Tujuan ...</option>');

                    $('#tgl_berangkat').val('');
                    $('#penumpang').val('1');
                    $('#penumpang2').val('0');
                    $('#tgl_berangkat').val(formatDate());
                    return false;


                },
                error: function () {
                    notifGagal('Data perjalanan berhasil ditambahkan');
                    return false;
                }
            });
        } else {
            notifGagal('<strong>Gagal!</strong> Pastikan anda mengisi semua data');
            return false;
        }
    } else {
        return false;
    }

}

// NOTE : Perjalanan Del
function perjalanan_del(id, id_customer,id_asal,id_tujuan) {
    var check = confirm("Apakah anda yakin menghapus data tersebut?");

    if (check === true) {
        var id = id;
        $.ajax({
            type: 'POST',
            url: 'dashboard/perjalanan_del',
            data: {id : id,
                  id_customer : id_customer,
                  id_pelabuhan_asal : id_asal,
                  id_pelabuhan_tujuan : id_tujuan
                  },
            success: function (html) {

                $('#historyCustomerTrip').dataTable().fnDestroy();
                history_table(id_customer);

            }
        });
        notifSukses('<strong>Sukses!</strong> Data perjalanan berhasil dihapus');
    } else {
        return false;
    }
}

//NOTE : Trip Perjalanan
function tripCustomer2(id) {
    select = $('#daerah_tujuan');

    $.ajax({
        url: "dashboard/port_find/" + id,
        type: "GET",
        dataType: "JSON",
        success: function (data) {
            var len = data.length;

            for (var i = 0; i < len; i++) {
                var id = data[i]['id'];
                var name = data[i]['nama_asal'];
                select.append('<option value=' + id + '>' + name + '</option>');
            }

        }
    });
}



// NOTE : job check
function jobCheck(val) {
    var job;
    switch (val) {
        case 'Belum/Tidak bekerja':
            job = '1';
            break;
        case 'Karyawan Swasta':
            job = '1';
            break;
        case 'Karyawan BUMN/BUMD':
            job = '1';
            break;
        case 'Pelajar/Mahasiswa':
            job = '1';
            break;
        case 'Guru':
            job = '1';
            break;
        case 'PNS':
            job = '1';
            break;
        case 'Wiraswasta':
            job = '1';
            break;
        default:
            job = '0';
            break;
    }

    return job;
}

//NOTE : curDate
function formatDate() {
    var d = new Date(),
        month = '' + (d.getMonth() + 1),
        day = '' + d.getDate(),
        year = d.getFullYear();

    if (month.length < 2) month = '0' + month;
    if (day.length < 2) day = '0' + day;

    return [year, month, day].join('-');
}

//NOTE : formPerjalanan preventDefault
$("#formPerjalanan").on("submit", function (e) {
    e.preventDefault();
});


$("#addComplainForm").on("submit", function (e) {
    e.preventDefault();
});
