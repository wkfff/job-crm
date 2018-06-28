<?php
defined('BASEPATH') OR exit('No direct script access allowed');?>
    <!doctype html>

    <html lang="en" ng-app="app">

    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="CRM : ASDP Indonesia Ferry">
        <meta name="author" content="FZ: Divisi IT">

        <title>CRM-ASDP Indonesia Ferry</title>

        <!-- CSS load -->
        <link rel="shortcut icon" type="text/css" href="<?= base_url(); ?>assets/img/favicons.ico">
        <!--Favicon-->
        <link rel="stylesheet" type="text/css" href="<?= base_url(); ?>assets/css/bootstrap.min.css">
        <!--bootstrap-->
        <link rel="stylesheet" type="text/css" href="<?= base_url(); ?>assets/css/font-awesome.min.css">
        <!--font-awesome-->
        <link rel="stylesheet" type="text/css" href="<?= base_url(); ?>assets/css/dataTables.bootstrap.min.css">
        <!--Datatables-->

        <!-- JS Load -->
        <script src="<?= base_url(); ?>assets/js/jquery-3.2.1.min.js"></script>
        <!--jquery-->
        <script src="<?= base_url(); ?>assets/js/bootstrap.min.js"></script>
        <!--bootstrap-->
        <script src="<?= base_url(); ?>assets/js/angular.min.js"></script>
        <!--angular-->
        <script src="<?= base_url(); ?>assets/js/jquery.dataTables.min.js"></script>
        <!--datatables-->
        <script src="<?= base_url(); ?>assets/js/jquery.datetimepicker.full.js"></script>
        <!--datepicker-->
        <script src="<?= base_url(); ?>assets/js/dataTables.bootstrap.min.js"></script>
        <!--datatables-->
        <script src="<?= base_url(); ?>assets/js/pnotify.custom.js"></script>
        <!--pnotify-->
        <script src="<?= base_url(); ?>assets/js/chart.js"></script>
        <script src="<?= base_url(); ?>assets/js/selectize.js"></script>
        <!--selectize-->

    </head>

    <noscript>
    <center>This Site needs JavaScript activated to work! Thanks.</center>
    <center>Situs ini memerlukan javascript! Terima Kasih</center>  
    <style>div { display:none; }</style>
</noscript>

    <body>

        <div class="page-title">
            <div class="title_left">
                <h3 class="kepala">Arsip data complain<small> - Customer Relation Management</small></h3>
            </div>
        </div>

        <div class="clearfix"></div>

        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_content">
                        <table id="myTabel" class="table table-striped table-bordered dt-responsive nowrap" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>Tiket</th>
                                    <th>Nama</th>
                                    <th>Cabang</th>
                                    <th>Area</th>
                                    <th>Kapal</th>
                                    <th>kategori</th>
                                    <th>Tanggal</th>
                                    <th>telp</th>
                                    <th>email</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($arsip as $row) : ?>
                                <tr>
                                    <td>
                                        <?= $row->tiket ?>
                                    </td>
                                    <td>
                                        <?= $row->nama ?>
                                    </td>
                                    <td>
                                        <?= $row->cabang ?>
                                    </td>
                                    <td>
                                        <?= $row->area ?>
                                    </td>
                                    <?php
                                $kapal = "-";

                                if($row->kapal){
                                    $kapal = $row->kapal;
                                }
                            ?>
                                        <td>
                                            <?= $kapal ?>
                                        </td>
                                        <td>
                                            <?= $row->kategori ?>
                                        </td>
                                        <td>
                                            <?= $row->tgl_komplain ?>
                                        </td>
                                        <td>
                                            <?= $row->telp ?>
                                        </td>
                                        <td>
                                            <?= $row->email ?>
                                        </td>
                                        <td>
                                            <button class="btn btn-primary" onclick="return detail_arsip(<?= $row->id_arsip?>)">
                                    <i class="fa fa-search"></i> Detail
                                </button>
                                        </td>
                                </tr>
                                <?php endforeach; ?>
                                <tbody>
                        </table>
                        <div class="x_panel">
                            <h3 class="kepala">Detail arsip data complain :
                                <font id="tiket_archive">-</font>
                            </h3>
                        </div>

                        <div class="x_panel">
                            <div id="detail_archive" class="row">

                                <div>

                                    <table class="table table-bordered table_arsip" style="width:100%">
                                        <tr>
                                            <td class="td1" style="width:12%"><b>Nama</b></td>
                                            <td style="" colspan="5">
                                                <font id="nama_archive">-</font>
                                            </td>

                                        </tr>
                                        <tr>
                                            <td class="td2"><b>Telp</b></td>
                                            <td style="width:20%">
                                                <font id="telp_archive">-</font>
                                            </td>
                                            <td class="td2" style="width:12%"><b>Email</b></td>
                                            <td style="width:25%">
                                                <font id="mail_archive">-</font>
                                            </td>
                                            <td class="td2"><b>Prioritas</b></td>
                                            <td style="width:25%">
                                                <font id="prioritas_archive">-</font>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="td1"><b>Tanggal Komplain</b></td>
                                            <td style="">
                                                <font id="tgl_archive">-</font>
                                            </td>
                                            <td class="td1"><b>Lama Penindakan</b></td>
                                            <td style="">
                                                <font id="lama_archive">-</font>
                                            </td>
                                            <td class="td1"><b>Status</b></td>
                                            <td style="">
                                                <font id="status_archive">-</font>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="td2"><b>Cabang</b></td>
                                            <td style="">
                                                <font id="cabang_archive">-</font>
                                            </td>
                                            <td class="td2"><b>Area</b></td>
                                            <td style="">
                                                <font id="area_archive">-</font>
                                            </td>
                                            <td class="td2"><b>Kapal</b></td>
                                            <td style="">
                                                <font id="kapal_archive">-</font>
                                            </td>
                                        </tr>
                                    </table>
                                    <table class="table table-bordered" style="width:100%">
                                        <tr>
                                            <td colspan="4">
                                                <center>
                                                    <h2 class="kepala"><b>Tindakan</b></h2>
                                                </center>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="td1">
                                                <center><b>Tanggal Cabang</b></center>
                                            </td>
                                            <td class="td1">
                                                <center><b>Tanggal konfirmasi</b></center>
                                            </td>
                                            <td class="td1">
                                                <center><b>Tanggal Close Ticket</b></center>
                                            </td>
                                            <td class="td1">
                                                <center><b>Kategori</b></center>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="vertical-align: middle">
                                                <center>
                                                    <font id="tgl_cabang_archive">-</font>
                                                </center>
                                            </td>
                                            <td style="vertical-align: middle">
                                                <center>
                                                    <font id="tgl_konfirmasi_archive">-</font>
                                                </center>
                                            </td>
                                            <td style="vertical-align: middle">
                                                <center>
                                                    <font id="tgl_ticket_archive">-</font>
                                                </center>
                                            </td>
                                            <td style="vertical-align: middle">
                                                <center>
                                                    <font id="kategori_archive">-</font>
                                                </center>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="td2" colspan="2">
                                                <center><b>Isi Komplain</b></center>
                                            </td>
                                            <td class="td2" colspan="2">
                                                <center><b>Tindakan</b></center>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="2">
                                                <center>
                                                    <font id="isi_archive">-</font>
                                                </center>
                                            </td>
                                            <td colspan="2">
                                                <center>
                                                    <font id="tindakan_archive">-</font>
                                                </center>
                                            </td>
                                        </tr>
                                    </table>

                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </body>

    <script>
        $('#myTabel').dataTable();

    </script>

    <style>
        .td1 {
            width: 10%;
            background-color: #DAEFFB;

        }

        .td2 {
            width: 10%;
            background-color: mintcream;
        }

    </style>

    <script>
        function detail_arsip(id) {

            $('#detail_archive').addClass('loader');
            $('#table_arsip').hide();

            $.ajax({
                url: "dashboard/arsip_find/" + id,
                type: "GET",
                dataType: "JSON",
                success: function(data) {
                    $('#tiket_archive').text(data.tiket);
                    $('#nama_archive').text(data.nama);
                    $('#telp_archive').text(data.telp);
                    $('#mail_archive').text(data.email);

                    var prioritas = '';

                    switch (data.prioritas) {

                        case '1':
                            prioritas = 'Sangat penting (1 Hari)';
                            break;
                        case '2':
                            prioritas = 'Penting (2 Hari)';
                            break;
                        case '3':
                            prioritas = 'Normal (3 Hari)';
                            break;
                        default:
                            break;

                    }

                    $('#prioritas_archive').text(prioritas);
                    $('#tgl_archive').text(data.tgl_komplain);
                    $('#lama_archive').text(data.dif + ' hari');
                    $('#status_archive').text(data.status);
                    $('#cabang_archive').text(data.cabang);
                    $('#area_archive').text(data.area);

                    if (data.kapal) {
                        $('#kapal_archive').text(data.kapal);
                    } else {
                        $('#kapal_archive').text('-');
                    }

                    //TIndakan
                    $('#tgl_cabang_archive').text(data.tgl_cabang);
                    $('#tgl_konfirmasi_archive').text(data.tgl_confirm);
                    $('#tgl_ticket_archive').text(data.tgl_completed);
                    $('#kategori_archive').text(data.kategori);
                    $('#isi_archive').text(data.isi);
                    if (data.tindakan) {
                        $('#tindakan_archive').text(data.tindakan);
                    } else {
                        $('#tindakan_archive').text('-');
                    }





                    console.log(data.tiket);
                }
            });
            $('#detail_archive').removeClass('loader');
        }

    </script>
