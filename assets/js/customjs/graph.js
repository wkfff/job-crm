var semuaData = [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0]; //Semua data komplain
var doneData = [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0]; //data komplain yang sudah selesai
var notData = [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0]; //data komplain yang belum selesai
//var total =[0,0,0,0,0,0,0,0,0,0,0,0];
//var total2 =[0,0,0,0,0,0,0,0,0,0,0,0];

$(document).ready(function () {
    var tahun = $('#grafik_tahun').val();
    chart_complain_all(tahun);
});

//NOTE : CHART  - BY TAHUN
function chart_complain_all(tahun) {
    $.ajax({
        url: "dashboard/chart_complain_all/" + tahun, //FUTURE : get data - total komplain
        method: "GET",
        success: function (data) {
            semuaData = [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0];
            var bulan = [];

            for (var i in data) {

                var u = data[i].bulan - 1;

                semuaData[u] = data[i].total;
            }

            $.ajax({
                url: "dashboard/chart_complain_done_all/" + tahun, // FUTURE : get data - komplain selesai
                method: "GET",
                success: function (data) {
                    doneData = [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0];
                    var bulan = [];

                    for (var i in data) {

                        var u = data[i].bulan - 1;

                        doneData[u] = data[i].total;
                    }

                    $.ajax({
                        url: "dashboard/chart_complain_belum_all/" + tahun, // FUTURE : get data - komplain belum
                        method: "GET",
                        success: function (data) {
                            notData = [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0];
                            var bulan = [];

                            for (var i in data) {

                                var u = data[i].bulan - 1;

                                notData[u] = data[i].total;
                            }

                            var chartdata = {
                                // labels: bulan,
                                labels: ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'],
                                datasets: [{
                                    label: 'Total',
                                    backgroundColor: 'rgba(21, 122, 232, 0.8)',
                                    data: semuaData,
                                    scaleStartValue: 0,
                                    borderWidth: 0
                                }, {
                                    label: 'Selesai',
                                    backgroundColor: 'rgba(13, 255, 116, 0.8)',
                                    data: doneData,
                                    scaleStartValue: 0,
                                    borderWidth: 0
                                }, {
                                    label: 'Proses',
                                    backgroundColor: 'rgba(232, 60, 58, 0.8)',
                                    data: notData,
                                    scaleStartValue: 0,
                                    borderWidth: 0
                                }]
                            };

                            var ctx = $("#mychart");

                            var barGraph = new Chart(ctx, {
                                type: 'bar',
                                data: chartdata,
                                options: {
                                    scales: {
                                        yAxes: [{
                                            ticks: {
                                                beginAtZero: true,
                                            }
                                        }]
                                    }
                                }
                            });

                        },
                        error: function (data) {
                            console.log(data);
                        }
                    });



                },
                error: function (data) {
                    console.log(data);
                }
            });
        },
        error: function (data) {
            console.log(data);
        }
    });

}

//SEMUA

//NOTE : CHART  - BY TAHUN & CABANG
function chart_complain_cabang(tahun, cabang) {
    $.ajax({
        url: "dashboard/chart_complain_cabang/" + tahun + "/" + cabang, // FUTURE : get data - total komplain
        method: "GET",
        success: function (data) {
            console.log(data);
            var bulan = [];
            semuaData = [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0];

            for (var i in data) {

                var nama_bulan = bulanNama(data[i].bulan);

                var u = data[i].bulan - 1;

                semuaData[u] = data[i].total;
            }

            $.ajax({
                url: "dashboard/chart_complain_done_cabang/" + tahun + "/" + cabang, // FUTURE : get data - komplain selesai
                method: "GET",
                success: function (data) {
                    console.log(data);
                    var bulan = [];
                    doneData = [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0];

                    for (var i in data) {

                        var nama_bulan = bulanNama(data[i].bulan);

                        var u = data[i].bulan - 1;

                        doneData[u] = data[i].total;
                    }

                    $.ajax({
                        url: "dashboard/chart_complain_belum_cabang/" + tahun + "/" + cabang, // FUTURE : get data - komplain belum
                        method: "GET",
                        success: function (data) {
                            console.log(data);
                            var bulan = [];
                            notData = [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0];

                            for (var i in data) {

                                var nama_bulan = bulanNama(data[i].bulan);

                                var u = data[i].bulan - 1;

                                notData[u] = data[i].total;
                            }

                            var chartdata = {
                                labels: ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'],
                                datasets: [
                                    {
                                        label: 'Total',
                                        backgroundColor: 'rgba(21, 122, 232, 0.8)',
                                        data: semuaData,
                                        scaleStartValue: 0,
                                        borderWidth: 0
                                }, {
                                        label: 'Selesai',
                                        backgroundColor: 'rgba(13, 255, 116, 0.8)',
                                        data: doneData,
                                        scaleStartValue: 0,
                                        borderWidth: 0
                                }, {
                                        label: 'Proses',
                                        backgroundColor: 'rgba(232, 60, 58, 0.8)',
                                        data: notData,
                                        scaleStartValue: 0,
                                        borderWidth: 0
                                }
				                    ]
                            };

                            var ctx = $("#mychart");

                            var barGraph = new Chart(ctx, {
                                type: 'bar',
                                data: chartdata,
                                options: {
                                    scales: {
                                        yAxes: [{
                                            ticks: {
                                                beginAtZero: true
                                            }
						}]
                                    }
                                }
                            });



                        },
                        error: function (data) {
                            console.log(data);
                        }
                    });
                },
                error: function (data) {
                    console.log(data);
                }
            });






        },
        error: function (data) {
            console.log(data);
        }
    });
}
//PER CABANG

//NOTE : CHART - BY TAHUN & CABANG & KATEGORI
function chart_complain_kategori(tahun, cabang, kategori) {

    $.ajax({
        url: "dashboard/chart_complain_kategori/" + tahun + "/" + cabang + "/" + kategori, //FUTURE : get data - total komplain
        method: "GET",
        success: function (data) {
            console.log(data);
            var bulan = [];
            semuaData = [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0];

            for (var i in data) {

                var nama_bulan = bulanNama(data[i].bulan);

                var u = data[i].bulan - 1;

                semuaData[u] = data[i].total;
            }

            $.ajax({
                url: "dashboard/chart_complain_done_kategori/" + tahun + "/" + cabang + "/" + kategori, //FUTURE : get data - komplain selesai
                method: "GET",
                success: function (data) {
                    console.log(data);
                    var bulan = [];
                    doneData = [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0];

                    for (var i in data) {

                        var nama_bulan = bulanNama(data[i].bulan);

                        var u = data[i].bulan - 1;

                        doneData[u] = data[i].total;
                    }

                    $.ajax({
                        url: "dashboard/chart_complain_belum_kategori/" + tahun + "/" + cabang + "/" + kategori, //FUTURE : get data - komplain belum
                        method: "GET",
                        success: function (data) {
                            console.log(data);
                            var bulan = [];
                            notData = [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0];

                            for (var i in data) {

                                var nama_bulan = bulanNama(data[i].bulan);

                                var u = data[i].bulan - 1;

                                notData[u] = data[i].total;
                            }


                            var chartdata = {
                                labels: ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'],
                                datasets: [
                                    {
                                        label: 'Total',
                                        backgroundColor: 'rgba(21, 122, 232, 0.8)',
                                        data: semuaData,
                                        scaleStartValue: 0,
                                        borderWidth: 0
                                }, {
                                        label: 'Selesai',
                                        backgroundColor: 'rgba(13, 255, 116, 0.8)',
                                        data: doneData,
                                        scaleStartValue: 0,
                                        borderWidth: 0
                                }, {
                                        label: 'Proses',
                                        backgroundColor: 'rgba(232, 60, 58, 0.8)',
                                        data: notData,
                                        scaleStartValue: 0,
                                        borderWidth: 0
                                }
				            ]
                            };

                            var ctx = $("#mychart");

                            var barGraph = new Chart(ctx, {
                                type: 'bar',
                                data: chartdata,
                                options: {
                                    scales: {
                                        yAxes: [{
                                            ticks: {
                                                beginAtZero: true
                                            }
						}]
                                    }
                                }
                            });



                        },
                        error: function (data) {
                            console.log(data);
                        }
                    });

                },
                error: function (data) {
                    console.log(data);
                }
            });



        },
        error: function (data) {
            console.log(data);
        }
    });
}

//NOTE : CHART - BY TAHUN & KATEGORI
function chart_complain_kategori2(tahun, kategori) {

    $.ajax({
        url: "dashboard/chart_complain_kategori2/" + tahun + "/" + kategori, //FUTURE : get data - total Komplain
        method: "GET",
        success: function (data) {
            var bulan = [];
            semuaData = [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0];

            for (var i in data) {

                var nama_bulan = bulanNama(data[i].bulan);

                var u = data[i].bulan - 1;

                semuaData[u] = data[i].total;
            }

            $.ajax({
                url: "dashboard/chart_complain_done_kategori2/" + tahun + "/" + kategori, //FUTURE : get data - komplain selesai
                method: "GET",
                success: function (data) {
                    var bulan = [];
                    doneData = [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0];

                    for (var i in data) {

                        var nama_bulan = bulanNama(data[i].bulan);

                        var u = data[i].bulan - 1;

                        doneData[u] = data[i].total;
                    }

                    $.ajax({
                        url: "dashboard/chart_complain_belum_kategori2/" + tahun + "/" + kategori, //FUTURE : get data - komplain belum
                        method: "GET",
                        success: function (data) {
                            var bulan = [];
                            notData = [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0];

                            for (var i in data) {

                                var nama_bulan = bulanNama(data[i].bulan);

                                var u = data[i].bulan - 1;


                                notData[u] = data[i].total;
                            }


                            var chartdata = {
                                labels: ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'],
                                datasets: [{
                                        label: 'Total',
                                        backgroundColor: 'rgba(21, 122, 232, 0.8)',
                                        data: semuaData,
                                        scaleStartValue: 0,
                                        borderWidth: 0
                                }, {
                                        label: 'Selesai',
                                        backgroundColor: 'rgba(13, 255, 116, 0.8)',
                                        data: doneData,
                                        scaleStartValue: 0,
                                        borderWidth: 0
                                }, {
                                        label: 'Proses',
                                        backgroundColor: 'rgba(232, 60, 58, 0.8)',
                                        data: notData,
                                        scaleStartValue: 0,
                                        borderWidth: 0
                                }
				                ]
                            };

                            var ctx = $("#mychart");

                            var barGraph = new Chart(ctx, {
                                type: 'bar',
                                data: chartdata,
                                options: {
                                    scales: {
                                        yAxes: [{
                                            ticks: {
                                                beginAtZero: true
                                            }
						}]
                                    }
                                }
                            });



                        },
                        error: function (data) {
                            console.log(data);
                        }
                    });

                },
                error: function (data) {
                    console.log(data);
                }
            });



        },
        error: function (data) {
            console.log(data);
        }
    });
}

//NOTE : CHART KATEGORI - BY TAHUN
function chart_kategori_complain1(tahun) {

    $.ajax({
        url: "dashboard/kategori_chart_complain1/" + tahun,
        method: "GET",
        success: function (data) {
            console.log(data);
            var bulan = [];
            var total = [];
            var kebersihan = [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0];
            var kenyamanan = [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0];
            var keamanan = [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0];
            var pelayanan = [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0];
            var fasilitas = [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0];
            var petugas = [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0];
            var kesetaraan = [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0];
            var kemudahan = [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0];
            var kehandalan = [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0];
            var keselamatan = [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0];
            var tiket = [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0];

            for (var i in data) {

                var nama_bulan = bulanNama(data[i].bulan);

                bulan.push(nama_bulan);

                switch (data[i].kategori) {
                    case 'Kebersihan':
                        kebersihan[data[i].bulan - 1] = data[i].total;
                        kenyamanan.push(0);
                        keamanan.push(0);
                        pelayanan.push(0);
                        fasilitas.push(0);
                        petugas.push(0);
                        kesetaraan.push(0);
                        kemudahan.push(0);
                        kehandalan.push(0);
                        keselamatan.push(0);
                        tiket.push(0);
                        break;
                    case 'Kenyamanan':
                        kebersihan.push(0);
                        kenyamanan[data[i].bulan - 1] = data[i].total;
                        keamanan.push(0);
                        pelayanan.push(0);
                        fasilitas.push(0);
                        petugas.push(0);
                        kesetaraan.push(0);
                        kemudahan.push(0);
                        kehandalan.push(0);
                        keselamatan.push(0);
                        tiket.push(0);
                        break;
                    case 'Keamanan':
                        kebersihan.push(0);
                        kenyamanan.push(0);
                        keamanan[data[i].bulan - 1] = data[i].total;
                        pelayanan.push(0);
                        fasilitas.push(0);
                        petugas.push(0);
                        kesetaraan.push(0);
                        kemudahan.push(0);
                        kehandalan.push(0);
                        keselamatan.push(0);
                        tiket.push(0);
                        break;
                    case 'Pelayanan':
                        kebersihan.push(0);
                        kenyamanan.push(0);
                        keamanan.push(0);
                        pelayanan[data[i].bulan - 1] = data[i].total;
                        fasilitas.push(0);
                        petugas.push(0);
                        kesetaraan.push(0);
                        kemudahan.push(0);
                        kehandalan.push(0);
                        keselamatan.push(0);
                        tiket.push(0);
                        break;
                    case 'Fasilitas':
                        kebersihan.push(0);
                        kenyamanan.push(0);
                        keamanan.push(0);
                        pelayanan.push(0);
                        fasilitas[data[i].bulan - 1] = data[i].total;
                        petugas.push(0);
                        kesetaraan.push(0);
                        kemudahan.push(0);
                        kehandalan.push(0);
                        keselamatan.push(0);
                        tiket.push(0);
                        break;
                    case 'Petugas':
                        kebersihan.push(0);
                        kenyamanan.push(0);
                        keamanan.push(0);
                        pelayanan.push(0);
                        fasilitas.push(0);
                        petugas[data[i].bulan - 1] = data[i].total;
                        kesetaraan.push(0);
                        kemudahan.push(0);
                        kehandalan.push(0);
                        keselamatan.push(0);
                        tiket.push(0);
                        break;
                    case 'Kesetaraan':
                        kebersihan.push(0);
                        kenyamanan.push(0);
                        keamanan.push(0);
                        pelayanan.push(0);
                        fasilitas.push(0);
                        petugas.push(0);
                        kesetaraan[data[i].bulan - 1] = data[i].total;
                        kemudahan.push(0);
                        kehandalan.push(0);
                        keselamatan.push(0);
                        tiket.push(0);
                        break;
                    case 'Kemudahan/Keterjangkauan':
                        kebersihan.push(0);
                        kenyamanan.push(0);
                        keamanan.push(0);
                        pelayanan.push(0);
                        fasilitas.push(0);
                        petugas.push(0);
                        kesetaraan.push(0);
                        kemudahan[data[i].bulan - 1] = data[i].total;
                        kehandalan.push(0);
                        keselamatan.push(0);
                        tiket.push(0);
                        break;
                    case 'Kehandalan/Keteraturan':
                        kebersihan.push(0);
                        kenyamanan.push(0);
                        keamanan.push(0);
                        pelayanan.push(0);
                        fasilitas.push(0);
                        petugas.push(0);
                        kesetaraan.push(0);
                        kemudahan.push(0);
                        kehandalan[data[i].bulan - 1] = data[i].total;
                        keselamatan.push(0);
                        tiket.push(0);
                        break;
                    case 'Keselamatan, Kesehatan dan Lingkungan':
                        kebersihan.push(0);
                        kenyamanan.push(0);
                        keamanan.push(0);
                        pelayanan.push(0);
                        fasilitas.push(0);
                        petugas.push(0);
                        kesetaraan.push(0);
                        kemudahan.push(0);
                        kehandalan.push(0);
                        keselamatan[data[i].bulan - 1] = data[i].total;
                        tiket.push(0);
                        break;
                    case 'Tiket Online':
                        kebersihan.push(0);
                        kenyamanan.push(0);
                        keamanan.push(0);
                        pelayanan.push(0);
                        fasilitas.push(0);
                        petugas.push(0);
                        kesetaraan.push(0);
                        kemudahan.push(0);
                        kehandalan.push(0);
                        keselamatan.push(0);
                        tiket[data[i].bulan - 1] = data[i].total;
                        break;
                    default:
                        break;
                }
            }

            var chartdata = {
                labels: ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'],
                datasets: [
                    {
                        label: 'Kebersihan',
                        backgroundColor: 'rgba(34, 129, 255, 0.8)',
                        borderWidth: 0,
                        scalesOverride: true,
                        scaleStartValue: 0,
                        data: kebersihan
					},
                    {
                        label: 'Kenyamanan',
                        backgroundColor: 'rgba(255, 58, 34, 0.8)',
                        scalesOverride: true,
                        scaleStartValue: 0,
                        data: kenyamanan
					},
                    {
                        label: 'Keamanan',
                        backgroundColor: 'rgba(129, 255, 137, 0.8)',
                        scalesOverride: true,
                        scaleStartValue: 0,
                        data: keamanan
					},
                    {
                        label: 'Pelayanan',
                        backgroundColor: 'rgba(232, 190, 32, 0.8)',
                        scalesOverride: true,
                        scaleStartValue: 0,
                        data: pelayanan
					},
                    {
                        label: 'Fasilitas',
                        backgroundColor: 'rgba(133, 88, 232, 0.8)',
                        scalesOverride: true,
                        scaleStartValue: 0,
                        data: fasilitas
					},
                    {
                        label: 'Petugas',
                        backgroundColor: 'rgba(139, 242, 255, 0.8)',
                        scalesOverride: true,
                        scaleStartValue: 0,
                        data: petugas
					},
                    {
                        label: 'Kesetaraan',
                        backgroundColor: 'rgba(255, 101, 99, 0.8)',
                        stack: 'Stack 4',
                        scalesOverride: true,
                        scaleStartValue: 0,
                        data: kesetaraan
					},
                    {
                        label: 'Kemudahan',
                        backgroundColor: 'rgba(232, 255, 32, 0.8)',
                        scalesOverride: true,
                        scaleStartValue: 0,
                        data: kemudahan
					},
                    {
                        label: 'Kehandalan',
                        backgroundColor: 'rgba(232, 190, 255, 0.8)',
                        scalesOverride: true,
                        scaleStartValue: 0,
                        data: kehandalan
					},
                    {
                        label: 'Keselamatan',
                        backgroundColor: 'rgba(32, 190, 32, 0.8)',
                        scalesOverride: true,
                        scaleStartValue: 0,
                        data: keselamatan
					},
                    {
                        label: 'Tiket',
                        backgroundColor: 'rgba(232, 190, 190, 0.8)',
                        scalesOverride: true,
                        scaleStartValue: 0,
                        data: tiket
					}
				]
            };

            var ctx = $("#mychart2");

            var barGraph = new Chart(ctx, {
                type: 'bar',
                data: chartdata,
                options: {
                    scales: {
                        yAxes: [{
                            ticks: {
                                beginAtZero: true

                            }
						}]
                    }
                }
            });

        },
        error: function (data) {
            console.log(data);
        }
    });
}
//NOTE : CHART KATEGORI - BY TAHUN & KATEGORI
function chart_kategori_complain2(tahun, kategori) {

    $.ajax({
        url: "dashboard/kategori_chart_complain2/" + tahun + "/" + kategori,
        method: "GET",
        success: function (data) {
            console.log(data);
            var bulan = [];
            var total = [];
            var kebersihan = [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0];
            var kenyamanan = [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0];
            var keamanan = [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0];
            var pelayanan = [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0];
            var fasilitas = [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0];
            var petugas = [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0];
            var kesetaraan = [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0];
            var kemudahan = [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0];
            var kehandalan = [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0];
            var keselamatan = [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0];
            var tiket = [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0];

            for (var i in data) {

                var nama_bulan = bulanNama(data[i].bulan);

                bulan.push(nama_bulan);

                switch (data[i].kategori) {
                    case 'Kebersihan':
                        kebersihan[data[i].bulan - 1] = data[i].total;
                        kenyamanan.push(0);
                        keamanan.push(0);
                        pelayanan.push(0);
                        fasilitas.push(0);
                        petugas.push(0);
                        kesetaraan.push(0);
                        kemudahan.push(0);
                        kehandalan.push(0);
                        keselamatan.push(0);
                        tiket.push(0);
                        break;
                    case 'Kenyamanan':
                        kebersihan.push(0);
                        kenyamanan[data[i].bulan - 1] = data[i].total;
                        keamanan.push(0);
                        pelayanan.push(0);
                        fasilitas.push(0);
                        petugas.push(0);
                        kesetaraan.push(0);
                        kemudahan.push(0);
                        kehandalan.push(0);
                        keselamatan.push(0);
                        tiket.push(0);
                        break;
                    case 'Keamanan':
                        kebersihan.push(0);
                        kenyamanan.push(0);
                        keamanan[data[i].bulan - 1] = data[i].total;
                        pelayanan.push(0);
                        fasilitas.push(0);
                        petugas.push(0);
                        kesetaraan.push(0);
                        kemudahan.push(0);
                        kehandalan.push(0);
                        keselamatan.push(0);
                        tiket.push(0);
                        break;
                    case 'Pelayanan':
                        kebersihan.push(0);
                        kenyamanan.push(0);
                        keamanan.push(0);
                        pelayanan[data[i].bulan - 1] = data[i].total;
                        fasilitas.push(0);
                        petugas.push(0);
                        kesetaraan.push(0);
                        kemudahan.push(0);
                        kehandalan.push(0);
                        keselamatan.push(0);
                        tiket.push(0);
                        break;
                    case 'Fasilitas':
                        kebersihan.push(0);
                        kenyamanan.push(0);
                        keamanan.push(0);
                        pelayanan.push(0);
                        fasilitas[data[i].bulan - 1] = data[i].total;
                        petugas.push(0);
                        kesetaraan.push(0);
                        kemudahan.push(0);
                        kehandalan.push(0);
                        keselamatan.push(0);
                        tiket.push(0);
                        break;
                    case 'Petugas':
                        kebersihan.push(0);
                        kenyamanan.push(0);
                        keamanan.push(0);
                        pelayanan.push(0);
                        fasilitas.push(0);
                        petugas[data[i].bulan - 1] = data[i].total;
                        kesetaraan.push(0);
                        kemudahan.push(0);
                        kehandalan.push(0);
                        keselamatan.push(0);
                        tiket.push(0);
                        break;
                    case 'Kesetaraan':
                        kebersihan.push(0);
                        kenyamanan.push(0);
                        keamanan.push(0);
                        pelayanan.push(0);
                        fasilitas.push(0);
                        petugas.push(0);
                        kesetaraan[data[i].bulan - 1] = data[i].total;
                        kemudahan.push(0);
                        kehandalan.push(0);
                        keselamatan.push(0);
                        tiket.push(0);
                        break;
                    case 'Kemudahan/Keterjangkauan':
                        kebersihan.push(0);
                        kenyamanan.push(0);
                        keamanan.push(0);
                        pelayanan.push(0);
                        fasilitas.push(0);
                        petugas.push(0);
                        kesetaraan.push(0);
                        kemudahan[data[i].bulan - 1] = data[i].total;
                        kehandalan.push(0);
                        keselamatan.push(0);
                        tiket.push(0);
                        break;
                    case 'Kehandalan/Keteraturan':
                        kebersihan.push(0);
                        kenyamanan.push(0);
                        keamanan.push(0);
                        pelayanan.push(0);
                        fasilitas.push(0);
                        petugas.push(0);
                        kesetaraan.push(0);
                        kemudahan.push(0);
                        kehandalan[data[i].bulan - 1] = data[i].total;
                        keselamatan.push(0);
                        tiket.push(0);
                        break;
                    case 'Keselamatan, Kesehatan dan Lingkungan':
                        kebersihan.push(0);
                        kenyamanan.push(0);
                        keamanan.push(0);
                        pelayanan.push(0);
                        fasilitas.push(0);
                        petugas.push(0);
                        kesetaraan.push(0);
                        kemudahan.push(0);
                        kehandalan.push(0);
                        keselamatan[data[i].bulan - 1] = data[i].total;
                        tiket.push(0);
                        break;
                    case 'Tiket Online':
                        kebersihan.push(0);
                        kenyamanan.push(0);
                        keamanan.push(0);
                        pelayanan.push(0);
                        fasilitas.push(0);
                        petugas.push(0);
                        kesetaraan.push(0);
                        kemudahan.push(0);
                        kehandalan.push(0);
                        keselamatan.push(0);
                        tiket[data[i].bulan - 1] = data[i].total;
                        break;
                    default:
                        break;
                }
            }

            var chartdata = {
                labels: ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'],
                datasets: [
                    {
                        label: 'Kebersihan',
                        backgroundColor: 'rgba(34, 129, 255, 0.8)',
                        borderWidth: 0,
                        scalesOverride: true,
                        scaleStartValue: 0,
                        data: kebersihan
					},
                    {
                        label: 'Kenyamanan',
                        backgroundColor: 'rgba(255, 58, 34, 0.8)',
                        scalesOverride: true,
                        scaleStartValue: 0,
                        data: kenyamanan
					},
                    {
                        label: 'Keamanan',
                        backgroundColor: 'rgba(129, 255, 137, 0.8)',
                        scalesOverride: true,
                        scaleStartValue: 0,
                        data: keamanan
					},
                    {
                        label: 'Pelayanan',
                        backgroundColor: 'rgba(232, 190, 32, 0.8)',
                        scalesOverride: true,
                        scaleStartValue: 0,
                        data: pelayanan
					},
                    {
                        label: 'Fasilitas',
                        backgroundColor: 'rgba(133, 88, 232, 0.8)',
                        scalesOverride: true,
                        scaleStartValue: 0,
                        data: fasilitas
					},
                    {
                        label: 'Petugas',
                        backgroundColor: 'rgba(139, 242, 255, 0.8)',
                        scalesOverride: true,
                        scaleStartValue: 0,
                        data: petugas
					},
                    {
                        label: 'Kesetaraan',
                        backgroundColor: 'rgba(255, 101, 99, 0.8)',
                        stack: 'Stack 4',
                        scalesOverride: true,
                        scaleStartValue: 0,
                        data: kesetaraan
					},
                    {
                        label: 'Kemudahan',
                        backgroundColor: 'rgba(232, 255, 32, 0.8)',
                        scalesOverride: true,
                        scaleStartValue: 0,
                        data: kemudahan
					},
                    {
                        label: 'Kehandalan',
                        backgroundColor: 'rgba(232, 190, 255, 0.8)',
                        scalesOverride: true,
                        scaleStartValue: 0,
                        data: kehandalan
					},
                    {
                        label: 'Keselamatan',
                        backgroundColor: 'rgba(32, 190, 32, 0.8)',
                        scalesOverride: true,
                        scaleStartValue: 0,
                        data: keselamatan
					},
                    {
                        label: 'Tiket',
                        backgroundColor: 'rgba(232, 190, 190, 0.8)',
                        scalesOverride: true,
                        scaleStartValue: 0,
                        data: tiket
					}
				]
            };

            var ctx = $("#mychart2");

            var barGraph = new Chart(ctx, {
                type: 'bar',
                data: chartdata,
                options: {
                    scales: {
                        yAxes: [{
                            ticks: {
                                beginAtZero: true

                            }
						}]
                    }
                }
            });

        },
        error: function (data) {
            console.log(data);
        }
    });
}

//NOTE : CHART CABANG - BY TAHUN
function chart_cabang_complain1(tahun) {
    $.ajax({
        url: "dashboard/branch_get2/",
        method: "GET",
        success: function (data) {
            var cabang = [];
            var cabangTemp = [];
            var valTemp = [];
            var total = [];
            var belum = [];
            var selesai = [];
            for (var i in data) {
                cabang.push(data[i].nama);
                
            }
            
            for (var i = 0; i < cabang.length; i++) {
                total.push(0);
                selesai.push(0);
                belum.push(0);
            }

            //FUTURE : get data - komplain cabang 
            $.ajax({
                url: "dashboard/cabang_chart_complain1/" + tahun,
                method: "GET",
                success: function (data) {
                    cabangTemp = [];
                    valTemp = [];

                    for (var i in data) {
                        cabangTemp.push(data[i].nama);
                        valTemp.push(data[i].total);
                    }

                    for (var i = 0; i < cabang.length; i++) {
                        for (var j = 0; j < cabang.length; j++) {
                            if (cabangTemp[j] == cabang[i]) {
                                total.push(valTemp[j]);
                                break;
                            } else {
                                total.push(0);
                            }
                        }

                    }
                    console.log(total);

                    //FUTURE : get data - komplain cabang done
                    $.ajax({
                        url: "dashboard/cabang_done_chart_complain1/" + tahun,
                        method: "GET",
                        success: function (data) {
                            cabangTemp = [];
                            valTemp = [];

                            for (var i in data) {
                                cabangTemp.push(data[i].nama);
                                valTemp.push(data[i].total);
                            }

                            for (var i = 0; i < cabang.length; i++) {
                                for (var j = 0; j < cabang.length; j++) {
                                    if (cabangTemp[j] == cabang[i]) {

                                        selesai.push(valTemp[j]);
                                        break;
                                    } else {
                                        selesai.push(0);
                                    }
                                }

                            }

                            //FUTURE : get data - komplain cabang belum
                            $.ajax({
                                url: "dashboard/cabang_belum_chart_complain1/" + tahun,
                                method: "GET",
                                success: function (data) {
                                    cabangTemp = [];
                                    valTemp = [];

                                    for (var i in data) {
                                        cabangTemp.push(data[i].nama);
                                        valTemp.push(data[i].total);
                                    }

                                    for (var i = 0; i < cabang.length; i++) {
                                        for (var j = 0; j < cabang.length; j++) {
                                            if (cabangTemp[j] == cabang[i]) {

                                                belum.push(valTemp[j]);
                                                break;
                                            } else {
                                                belum.push(0);
                                            }
                                        }

                                    }

                                    //FUTURE : Start of Chart
                                    var chartdata = {
                                        labels: cabang,
                                        datasets: [
                                            {
                                                label: 'Total',
                                                backgroundColor: 'rgba(21, 122, 232, 0.8)',
                                                data: total,
                                                scaleStartValue: 0,
                                                borderWidth: 0
                                            }, {
                                                label: 'Selesai',
                                                backgroundColor: 'rgba(13, 255, 116, 0.8)',
                                                data: selesai,
                                                scaleStartValue: 0,
                                                borderWidth: 0
                                            }, {
                                                label: 'Proses',
                                                backgroundColor: 'rgba(232, 60, 58, 0.8)',
                                                data: belum,
                                                scaleStartValue: 0,
                                                borderWidth: 0
                                            }
				                        ]
                                    };

                                    var ctx = $("#mychart3");

                                    var barGraph = new Chart(ctx, {
                                        type: 'bar',
                                        data: chartdata,
                                        options: {
                                            scales: {
                                                yAxes: [{
                                                    ticks: {
                                                        beginAtZero: true

                                                    }
						}]
                                            }
                                        }
                                    });


                                },
                                error: function (data) {
                                    console.log(data);
                                }
                            });



                        },
                        error: function (data) {
                            console.log(data);
                        }
                    });


                },
                error: function (data) {
                    console.log(data);
                }
            });




        },
        error: function (data) {
            console.log(data);
        }
    });
}

//NOTE : CHART CABANG - BY TAHUN & KATEGORI
function chart_cabang_complain2(tahun,kategori) {
    $.ajax({
        url: "dashboard/branch_get2/",
        method: "GET",
        success: function (data) {
            var jumlah = 0;
            var cabang = [];
            var cabangTemp = [];
            var valTemp = [];
            var jumlahTemp = 0;
            var total = [];
            var belum = [];
            var selesai = [];
            for (var i in data) {
                cabang.push(data[i].nama);
                jumlah++;
            }
            total = [jumlah];
            selesai = [jumlah];
            belum = [jumlah];
            for (var step = 0; step < jumlah; step++) {
                total[step] = 0;
                selesai[step] = 0;
                belum[step] = 0;
            }

            //FUTURE : get data - komplain cabang 
            $.ajax({
                url: "dashboard/cabang_chart_complain2/" + tahun +"/"+kategori,
                method: "GET",
                success: function (data) {
                    cabangTemp = [];
                    valTemp = [];
                    jumlahTemp = 0;

                    for (var i in data) {
                        cabangTemp.push(data[i].nama);
                        valTemp.push(data[i].total);
                        jumlahTemp++;
                    }

                    for (var step = 0; step < jumlah; step++) {
                        for (var step2 = 0; step2 < jumlahTemp; step2++) {
                            if (cabangTemp[step2] == cabang[step]) {

                                total[step] = valTemp[step2];
                                break;
                            } else {
                                total[step] = 0;
                            }
                        }

                    }

                    //FUTURE : get data - komplain cabang done
                    $.ajax({
                        url: "dashboard/cabang_done_chart_complain2/" + tahun +"/"+kategori,
                        method: "GET",
                        success: function (data) {
                            cabangTemp = [];
                            valTemp = [];
                            jumlahTemp = 0;

                            for (var i in data) {
                                cabangTemp.push(data[i].nama);
                                valTemp.push(data[i].total);
                                jumlahTemp++;
                            }

                            for (var step = 0; step < jumlah; step++) {
                                for (var step2 = 0; step2 < jumlahTemp; step2++) {
                                    if (cabangTemp[step2] == cabang[step]) {

                                        selesai[step] = valTemp[step2];
                                        break;
                                    } else {
                                        selesai[step] = 0;
                                    }
                                }

                            }

                            //FUTURE : get data - komplain cabang belum
                            $.ajax({
                                url: "dashboard/cabang_belum_chart_complain2/" + tahun +"/"+kategori,
                                method: "GET",
                                success: function (data) {
                                    cabangTemp = [];
                                    valTemp = [];
                                    jumlahTemp = 0;

                                    for (var i in data) {
                                        cabangTemp.push(data[i].nama);
                                        valTemp.push(data[i].total);
                                        jumlahTemp++;
                                    }

                                    for (var step = 0; step < jumlah; step++) {
                                        for (var step2 = 0; step2 < jumlahTemp; step2++) {
                                            if (cabangTemp[step2] == cabang[step]) {

                                                belum[step] = valTemp[step2];
                                                break;
                                            } else {
                                                belum[step] = 0;
                                            }
                                        }

                                    }
                                    console.log(cabang);


                                    //FUTURE : Start of Chart

                                    var chartdata = {
                                        labels: cabang,
                                        datasets: [
                                            {
                                                label: 'Total',
                                                backgroundColor: 'rgba(21, 122, 232, 0.8)',
                                                data: total,
                                                scaleStartValue: 0,
                                                borderWidth: 0
                                            }, {
                                                label: 'Selesai',
                                                backgroundColor: 'rgba(13, 255, 116, 0.8)',
                                                data: selesai,
                                                scaleStartValue: 0,
                                                borderWidth: 0
                                            }, {
                                                label: 'Proses',
                                                backgroundColor: 'rgba(232, 60, 58, 0.8)',
                                                data: belum,
                                                scaleStartValue: 0,
                                                borderWidth: 0
                                            }
				                        ]
                                    };

                                    var ctx = $("#mychart3");

                                    var barGraph = new Chart(ctx, {
                                        type: 'bar',
                                        data: chartdata,
                                        options: {
                                            scales: {
                                                yAxes: [{
                                                    ticks: {
                                                        beginAtZero: true

                                                    }
						}]
                                            }
                                        }
                                    });


                                },
                                error: function (data) {
                                    console.log(data);
                                }
                            });



                        },
                        error: function (data) {
                            console.log(data);
                        }
                    });


                },
                error: function (data) {
                    console.log(data);
                }
            });




        },
        error: function (data) {
            console.log(data);
        }
    });
}

// NOTE : Filter Graph 1
function grafik() {
    var cabang = $('#grafik_cabang').val();
    var kategori = $('#grafik_kategori').val();
    var nama_cabang = $('#grafik_cabang').text();
    var tahun = $('#grafik_tahun').val();


    if (kategori != 'semua' && cabang != 'semua') {
        $('#chart-container').fadeOut();
        $('#mychart').replaceWith('<canvas id="mychart" width="100" height="30"></canvas>');
        chart_complain_kategori(tahun, cabang, kategori);
        $('#chart_title').text('Kategori ' + kategori + ' Cabang ' + nama_cabang + ' Tahun ' + tahun);
        $('#chart-container').fadeIn();

    } else if (cabang != 'semua') {
        $('#chart-container').fadeOut();
        $('#mychart').replaceWith('<canvas id="mychart" width="100" height="30"></canvas>');
        chart_complain_cabang(tahun, cabang);
        $('#chart_title').text('Cabang ' + nama_cabang + ' Tahun ' + tahun);
        $('#chart-container').fadeIn();
    } else if (kategori != 'semua') {
        $('#chart-container').fadeOut();
        $('#mychart').replaceWith('<canvas id="mychart" width="100" height="30"></canvas>');
        chart_complain_kategori2(tahun, kategori);
        $('#chart_title').text('Kategori ' + kategori + ' Tahun ' + tahun);
        $('#chart-container').fadeIn();
    } else {
        $('#chart-container').fadeOut();
        $('#mychart').replaceWith('<canvas id="mychart" width="100" height="30"></canvas>');
        chart_complain_all(tahun);

        $('#chart_title').text('Tahun ' + tahun);
        $('#chart-container').fadeIn();
    }
}

//NOTE : Filter Graph 2
function grafik2() {
    var tahun = $('#grafik_tahun2').val();
    var kategori = $('#grafik_kategori2').val();

    $('#mychart2').replaceWith('<canvas id="mychart2" width="100" height="30"></canvas>');

    if (kategori != 'semua') {
        $('#chart-container2').fadeOut();
        chart_kategori_complain2(tahun, kategori);
        $('#chart_title2').text('Kategori ' + kategori + ' Tahun ' + tahun);
        $('#chart-container2').fadeIn();
    } else {
        $('#chart-container2').fadeOut();
        chart_kategori_complain1(tahun);
        $('#chart_title2').text('Semua Kategori Tahun ' + tahun);
        $('#chart-container2').fadeIn();
    }

}

//NOTE : Filter Graph 3
function grafik3() {
    var tahun = $('#grafik_tahun3').val();
    var kategori = $('#grafik_kategori3').val();

    $('#mychart3').replaceWith('<canvas id="mychart3" width="100" height="30"></canvas>');

    if (kategori != 'semua') {
        $('#chart-container3').fadeOut();
        chart_cabang_complain2(tahun, kategori);
        $('#chart_title3').text('Semua Cabang Kategori ' + kategori + ' Tahun ' + tahun);
        $('#chart-container3').fadeIn();
    } else {
        $('#chart-container3').fadeOut();
        chart_cabang_complain1(tahun);
        $('#chart_title3').text('Semua Cabang Tahun ' + tahun);
        $('#chart-container3').fadeIn();
    }
}

//Button Section

function bulanNama(bulan) {
    var result = 'tes';

    switch (bulan) {
        case '1':
            result = 'Januari';
            break;
        case '2':
            result = 'Februari';
            break;
        case '3':
            result = 'Maret';
            break;
        case '4':
            result = 'April';
            break;
        case '5':
            result = 'Mei';
            break;
        case '6':
            result = 'Juni';
            break;
        case '7':
            result = 'Juli';
            break;
        case '8':
            result = 'Agustus';
            break;
        case '9':
            result = 'September';
            break;
        case '10':
            result = 'Oktober';
            break;
        case '11':
            result = 'November';
            break;
        case '12':
            result = 'Desember';
            break;
        default:
            break;

    }

    return result;

}

//NOTE : Random color
function getRandomColor() {
    var letters = '0123456789ABCDEF'.split('');
    var color = '#';
    for (var i = 0; i < 6; i++) {
        color += letters[Math.floor(Math.random() * 16)];
    }
    return color;
}
