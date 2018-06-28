<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
    <!doctype html>

    <html>


    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="CRM : ASDP Indonesia Ferry">
        <meta name="author" content="FZ: Divisi IT">
        <title>Laporan Keluhan</title>



        <!-- CSS load -->
        <link rel="shortcut icon" type="text/css" href="<?= base_url(); ?>assets/img/favicons.ico">
        <!--Favicon-->

    </head>

    <body>

        <img src='<?= base_url()?>assets/img/logo.png' />
        <center>
            <h2>Data
                <?= $laporan_title ?><small style="font-color:#eee"> - Customer Relationship Management</small></h2>
            <h4>
                Periode
                <?= $tgl_awal ?> -
                    <?= $tgl_akhir?>
            </h4>
        </center>

        <style>
            table,
            th,
            td {
                border: 1px solid black;
                border-collapse: collapse;
            }

            td {
                text-align: center;
                vertical-align: text-top;
            }


            tr:nth-child(even) {
                background: #EEE
            }

            tr:nth-child(odd) {
                background: #FFF
            }


            th {
                background-color: #888;
            }

        </style>

        <table id="myTabel" width="100%" cellspacing="0" border="1px" cellpadding="0">
            <thead>
                <tr>
                    <th style="width:2%">No</th>
                    <th style="width:12%">Tiket</th>
                    <?php if($opsi_laporan != 2){ ?>
                    <th style="width:10%">UserID</th>
                    <?php } ?>
                    <th style="width:15%">Nama</th>
                    <th style="width:15%">email</th>
                    <th style="width:10%">telp</th>
                    <th style="width:36%">Keluhan</th>
                    <!--                    <th style="width:55%">Keluhan</th>-->

                </tr>
            </thead>
            <tbody>
                <?php $i=1; foreach($keluhan as $row){ ?>

                <tr>
                    <td>
                        <?= $i ?>
                    </td>
                    <td>
                        <?= $row->tiket ?>
                    </td>
                    <?php if($opsi_laporan != 2){ ?>
                    <td>
                        <?= $row->userid ?>
                    </td>
                    <?php } ?>
                    <td>
                        <?= $row->nama ?>
                    </td>
                    <td>
                        <?= $row->email ?>
                    </td>
                    <td>
                        <?= $row->telp ?>
                    </td>

                    <td style="text-align: left;">
                        <ul>
                            <li>
                                Tanggal Keluhan :
                                <?= $row->tgl_komplain ?>
                            </li>
                            <li> Cabang :
                                <?= $row->cabang?>
                            </li>
                            <?php if($row->cabang =='Pusat'){ ?>
                            <li>
                                Divisi :
                                <?= $row->divisi ?>
                            </li>
                            <?php } else { ?>
                            <li>
                                Area :
                                <?= $row->area ?>
                                    <?php if($row->kapal != null) {?> -
                                    <?= $row->kapal ?>
                                        <?php } ?>
                            </li>
                            <?php } ?>
                            <li>
                                Kategori :
                                <?= $row->kategori ?>
                            </li>
                            <li>
                                Isi Keluhan :
                                <?php if($opsi_laporan == 2){ ?>
                                <?= $row->isi ?>
                                    <?php }else { ?>
                                    <?= $row->isi_komplain ?>
                                        <?php } ?>
                            </li>
                            <?php if($opsi_laporan == 2){ ?>
                            <li>
                                Tindakan :
                                <?= $row->tindakan ?>
                            </li>
                            <?php } ?>

                        </ul>
                    </td>
                </tr>
                <?php  $i++;}?>
            </tbody>
        </table>

    </body>

    </html>
