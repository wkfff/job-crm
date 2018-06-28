$(document).ready(function () {});

//NOTE : Recent Act
function recentAct(id) {
    $('.recent').fadeOut();
    $('.recent2').show();

    //    FUTURE : Tabel - Recent Ativity refresh
    $('#tabelRecent').dataTable().fnDestroy();
    $('#tabelRecent').DataTable({
        "processing": true,
        "serverSide": true,
        "searching": false,
        "order": [],
        "ajax": {
            url: "serverProcessing/tabelrecent/get_data/" + id,
            type: "POST"

        },
        "columnDefs": [

        ],
    });

    //    FUTURE : Detail Customer
    $.ajax({
        dataType: 'JSON',
        type: 'GET',
        url: 'dashboard/customer_get/' + id,

        success: function (data) {
            $('#nama_d2').text(data['nama']);
            $('#userid_d2').text(data['userid']);
            $('#email_d2').text(data['email']);
            $('#telp_d2').text(data['telp']);
            $('#poin_freq').text(data['trip_freq']);
            $('#poin_poin').text(data['trip_poin']);


            $.ajax({
                dataType: 'JSON',
                type: 'GET',
                url: 'dashboard/loyalty_get',
                success: function (loyalty) {



                    var i = 0;
                    $.each(loyalty, function (key, value) {

                        //TODO: Bar - Jarak
                        if (loyalty[i]['tipe'] == 'jarak') {

                            if (data['jarak_level'] == loyalty[i]['ordering']) {
                                $('#poin_jarak').text(data['trip_jarak'] + ' - ' + loyalty[i]['nama']);
                                if (loyalty[i - 1]['tipe'] == 'jarak') {
                                    $('#jarak_max').text(loyalty[i-1]['max'] + ' - ' + loyalty[i - 1]['nama']);
                                } else {
                                    $('#jarak_max').text('Maximum poin');
                                }
                                var bar1 = data['trip_jarak'] / loyalty[i-1]['max'];
                                bar1 = bar1 * 100;
                                $('.bar_jarak').css('width', bar1 + '%');
                            }
                        }

                        //TODO : Bar - Frequency
                        else if (loyalty[i]['tipe'] == 'trip') {

                            if (data['freq_level'] == loyalty[i]['ordering']) {
                                $('#poin_freq').text(data['trip_freq'] + ' - ' + loyalty[i]['nama']);
                                if (loyalty[i - 1]['tipe'] == 'trip') {
                                    $('#freq_max').text(loyalty[i-1]['max'] + ' - ' + loyalty[i - 1]['nama']);
                                } else {
                                    $('#freq_max').text('Maximum poin');
                                }
                                var bar1 = data['trip_freq'] / loyalty[i]['max'];
                                bar1 = bar1 * 100;
                                $('.bar_freq').css('width', bar1 + '%');
                            }
                        }

                        //TODO : Bar - Frequency
                        else if (loyalty[i]['tipe'] == 'poin') {

                            if (data['poin_level'] == loyalty[i]['ordering']) {
                                $('#poin_poin').text(data['trip_poin'] + '-' + loyalty[i]['nama']);
                                if (loyalty[i - 1]['tipe'] == 'poin') {
                                    $('#poin_max').text(loyalty[i-1]['max'] + '-' + loyalty[i - 1]['nama']);
                                } else {
                                    $('#poin_max').text('Maximum poin');
                                }
                                var bar1 = data['trip_poin'] / loyalty[i]['max'];
                                bar1 = bar1 * 100;
                                $('.bar_poin').css('width', bar1 + '%');
                            }
                        }



                        i++;
                    });
                    return false;
                }
            })

            $.ajax({
                dataType: 'JSON',
                type: 'GET',
                url: 'dashboard/customer_lastAct/' + id,
                success: function (data2) {
                    if (data2['tgl_berangkat'] == '0') {
                        $('#lastact_d2').text('Belum ada aktivitas');
                    } else {
                        $('#lastact_d2').text(data2['tgl_berangkat'] + '|| Perjalanan ' + data2['asal'] + ' - ' + data2['tujuan']);
                    }
                    return false;
                }
            });
        },
        error: function () {
            notifGagal('Data lintasan gagal ditambahkan');
            return false;
        }
    });

    //FUTURE : Detail Customer 2
    //TODO : Count perjalanan dan interaksi
    $.ajax({
        dataType: 'JSON',
        type: 'GET',
        url: 'dashboard/count_cp/' + id,

        success: function (data) {
            $('#count_perjalanan').text(data[0]['perjalanan'] + ' X');
            $('#count_customer').text(data[1]['komplain'] + ' X');
        },
        error: function () {
            notifGagal('<strong>Error!</strong> Terjadi kesalahan');
            return false;
        }
    });

    //TODO : Count Lintasan
    $.ajax({
        dataType: 'JSON',
        type: 'GET',
        url: 'dashboard/count_lintasan/' + id,

        success: function (data) {
            if (typeof data[0] !== 'undefined') {
                $('#top_lintasan1').text('1. ' + data[0]['asal'] + ' - ' + data[0]['tujuan']);
                $('#top_right1').text(data[0]['perjalanan'] + 'X Perjalanan');
            } else {
                $('#top_lintasan1').text('1.-');
                $('#top_right1').text(' '); 
            }
            
            if (typeof data[1] !== 'undefined') {
                $('#top_lintasan2').text('2. ' + data[1]['asal'] + ' - ' + data[1]['tujuan']);
                $('#top_right2').text(data[1]['perjalanan'] + 'X Perjalanan');
            } else {
                $('#top_lintasan2').text('2.-');
                $('#top_right2').text(' ');
            }
            
            if (typeof data[2] !== 'undefined') {
                $('#top_lintasan3').text('3. ' + data[2]['asal'] + ' - ' + data[2]['tujuan']);
                $('#top_right3').text(data[2]['perjalanan'] + 'X Perjalanan');
            } else {
                $('#top_lintasan3').text('3.-');
                $('#top_right3').text(' ');
            }
        },
        error: function () {
            notifGagal('<strong>Error!</strong> Terjadi kesalahan');
            return false;
        }
    });


    $('.recent').fadeIn();
    $('.recent2').hide();
    $('html, body').animate({
        scrollTop: $('.detail_recent').offset().top
    }, 500);
}
