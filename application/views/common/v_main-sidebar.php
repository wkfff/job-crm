<div class="col-md-3 left_col">
    <div class="left_col scroll-view" style="background : #348ECD">
        <div class="navbar nav_title" style="border: 0; background : #ADBDE1; height:80px">
            <a style="height:80px; padding:5px" href="<?= base_url('dashboard') ?>" class="site_title"> <img src="<?= base_url() ?>assets/img/logo-asdp-dashboard.png" class="img-responsive img-title" ></a>
        </div>

        <div class="clearfix"></div>

        <br />

        <!-- sidebar menu -->
        <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
            <div class="menu_section" style="color:white"> 
                <h3 style="font-size:30px; margin-left: 30px">Main</h3>
                <ul class="nav side-menu">
                    <li><a href="<?= base_url()?>dashboard"><i class="fa fa-home"></i> Dashboard</a></li>
                    <?php if($this->session->userdata('userlevel') == 0) {?>
                    <li><a href="<?= base_url()?>user"><i class="fa fa-user"></i> Administrasi User</a></li>
                    <li><a href="<?= base_url()?>graph"><i class="fa fa-bar-chart"></i> Grafik</a></li>
                    <?php }; ?>
                    <li><a href="<?= base_url()?>archive"><i class="fa fa-archive"></i> Arsip</a></li>
                    <?php if($this->session->userdata('userlevel') == 0) {?>
                    <li><a data-toggle="modal" data-target="#modalLaporan"><i class="fa fa-file"></i> Laporan</a></li>
                    <!--                    <li><a href="<?= base_url()?>laporan"><i class="fa fa-file"></i> Laporan</a></li>-->
                    <li>
                        <a ><i class="fa fa-cogs"></i> Setting <span class="fa fa-chevron-down"></span></a>
                        <ul class="nav " style="display :none">
                            <li><a href="<?= base_url() ?>setting" style="color:white">Lintasan Poin</a></li>
                            <li><a href="<?= base_url() ?>setting2" style="color:white">Loyalty Poin</a></li>
                        </ul>
                    </li>
                    <?php }; ?>


                </ul>
            </div>


        </div>
        <!-- /sidebar menu -->

        <!-- Todo :  Modal Laporan -->
        <div id="modalLaporan" class="modal fade" role="dialog">
            <div class="modal-dialog">

                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Cetak Laporan</h4>
                    </div>
                    <form method="POST" action="<?= base_url() ?>laporan/laporan">
                        <div class="modal-body">

                            <div class="container">
                                <div class="row" style="margin-bottom: 15px;">
                                    <label class="form-label col-md-2" style="margin-top: 5px;">Laporan</label>
                                    <div class="col-md-5">
                                        <select class="form-control" name="laporan_keluhan" id="laporan_keluhan">
                                           <option value="1">Semua Keluhan</option>
                                           <option value="2">Keluhan Selesai</option>
                                           <option value="3">Keluhan Belum Selesai</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="row">

                                    <label for="tgl" class="form-label col-md-6">Tanggal Awal</label>
                                    <label for="tgl" class="form-label col-md-6">Tanggal Akhir</label>

                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="input-group">
                                            <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                            <input id="tgl_awal" name="tgl_awal" type="text" class="form-control" readonly required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="input-group">
                                            <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                            <input id="tgl_akhir" name="tgl_akhir" type="text" class="form-control" readonly required>
                                        </div>
                                    </div>
                                </div>
                            </div>


                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-success"><i class="fa fa-print"></i> Cetak</button>
                            <button type="reset" class="btn btn-info">Reset</button>
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                        </div>
                    </form>
                </div>

            </div>
        </div>

        <!--TODO : Modal Ganti Password -->
        <div id="passModal" class="modal fade" role="dialog">
            <div class="modal-dialog">

                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Password Change</h4>
                    </div>
                    <form class="form-horizontal form-label-left" method="POST" action="<?=base_url()?>dashboard/userPassChange">
                        <div class="modal-body">
                            <!-- Modal Form -->
                            <div class="form-group">
                                <label class="control-label col-md-5 col-sm-5 col-xs-12" for="oldpass">Password Lama</label>
                                <div class="col-md-7 col-sm-7 col-xs-12">
                                    <input type="hidden" id="uri" name="uri" value="<?= $this->uri->uri_string() ?>" />
                                    <input type="password" id="oldpass" name="oldpass" class="form-control" required />
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-5 col-sm-5 col-xs-12" for="newpass">Password Baru (min 8 karakter)</label>
                                <div class="col-md-7 col-sm-7 col-xs-12">
                                    <input type="password" id="newpass" name="newpass" onkeyup="passCheck()" minlength="8" class="form-control" required/>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-5 col-sm-5 col-xs-12" for="repass">Ulang Password</label>
                                <div class="col-md-7 col-sm-7 col-xs-12">
                                    <input type="password" id="repass" name="repass" onkeyup="passCheck()" class="form-control" required/>
                                </div>
                            </div>

                            <!-- Modal Form -->
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-success">Simpan</button>
                            <button class="btn btn-primary" type="reset">Reset</button>
                            <button class="btn btn-primary" data-dismiss="modal" onclick="return reset()">Close</button>
                        </div>
                    </form>
                </div>

            </div>
        </div>


        <!-- Footer -->

    </div>
</div>
