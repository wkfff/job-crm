<div class="page-title">
    <div class="title_left">
        <h3 class="kepala">Informasi<small>- Customer Relation Management</small></h3>
    </div>
</div>

<div class="clearfix"></div>

<!-- Notification -->
<?php if ($this->session->flashdata('passChangedFailed')) { ?>
<div class="alert alert-danger alert-dismissable">
    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
    <strong>Gagal!</strong> Pastikan data yang anda isikan benar!
</div>
<?php } else if ($this->session->flashdata('passChangedFailed2')) { ?>
<div class="alert alert-danger alert-dismissable">
    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
    <strong>Gagal!</strong> Password yang anda masukkan salah.
</div>
<?php } else if ($this->session->flashdata('passChangedSuccess')) { ?>
<div class="alert alert-success alert-dismissable">
    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
    <strong>Sukses!</strong> Password berhasil diganti.
</div>
<?php } else if ($this->session->flashdata('fatalError')) { ?>
<div class="alert alert-danger alert-dismissable">
    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
    <strong>Gagal!</strong> Terjadi kesalahan.
</div>
<?php } ?>
<!-- Notification -->

<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_content">

                <?php if(!empty($this->session->flashdata('Failed'))) {?>
                <div class="alert alert-danger alert-dismissable">
                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                    <?= $this->session->flashdata('Failed') ?>
                </div>
                <?php }?>
                <?php if(!empty($this->session->flashdata('Success'))) {?>
                <div class="alert alert-success alert-dismissable">
                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                    <?= $this->session->flashdata('Success') ?>
                </div>
                <?php }?>

<!--                NOTE : Grafik 1-->
                <div class="">
                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <div class="x_panel main-panel">
                            <div class="x_title">
                                <h2 class="kepala col-md-12">
                                    <center><strong>Grafik Komplain <font id="chart_title">Tahun 
                                   <?php 
                                    if($this->m_complain_chart->complain_get_year()){
                                    echo $this->m_complain_chart->complain_get_year()->tahun;
                                    }else{
                                        echo date("Y");
                                    }?></font></strong></center>
                                </h2>
                                
                                <ul class="nav navbar-right panel_toolbox">
                                    <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                                    </li>
                                    <li><a class="close-link"><i class="fa fa-close"></i></a>
                                    </li>
                                </ul>
                                
                                <div class="clearfix"></div>
                            </div>
                            <div class="x_content">
                                <!-- Tahun -->
                                <div class="form-group">
                                    <label class="form-label col-md-1" style="width: 4%;margin-top: 5px;">Tahun</label>
                                    <div class="selectdiv col-md-2">
                                        <select id="grafik_tahun" class="form-control" onchange="return grafik()">
                                                <?php foreach($tahun as $row) {?>
                                                    <option value="<?= $row->tahun ?>"><?= $row->tahun ?></option>
                                                <?php }?>
                                            </select>
                                    </div>

                                    <!-- Tahun -->

                                    <!--Cabang-->

                                    <label class="form-label col-md-1" style="width: 5%;margin-top: 5px;">Cabang</label>
                                    <div class="selectdiv col-md-2">
                                        <select id="grafik_cabang" class="form-control" onchange="return grafik()">
                                                <option value="semua">Semua Cabang</option>
                                                <?php foreach($cabang as $row) {?>
                                                    <option value="<?= $row->id_cabang ?>"><?= $row->nama ?></option>
                                                <?php }?>
                                            </select>
                                    </div>
                                    <script>
                                        $('#grafik_cabang').selectize()

                                    </script>


                                    <label class="form-label col-md-1" style="width: 6%;margin-top: 5px;">Kategori</label>
                                    <div class="selectdiv col-md-2">
                                        <select id="grafik_kategori" class="form-control" onchange="return grafik()">
                                                <option value="semua">Semua kategori</option>
                                                <?php foreach($kategori as $row) {?>
                                                    <option value="<?= $row->kategori ?>"><?= $row->kategori ?></option>
                                                <?php }?>
                                            </select>
                                    </div>

                                </div>
                                <!--Cabang-->

                                <div id="chart-container" style="padding-top: 55px;">
                                    <canvas id="mychart" width="100" height="30"></canvas>
                                    
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
<!--                NOTE : Grafik 3-->
                <div class="">
                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <div class="x_panel main-panel">
                            <div class="x_title">
                                <h2 class="kepala col-md-12">
                                    <center><strong>Grafik Komplain <font id="chart_title3">Per Cabang Tahun 
                                   <?php 
                                    if($this->m_complain_chart->complain_get_year()){
                                    echo $this->m_complain_chart->complain_get_year()->tahun;
                                    }else{
                                        echo date("Y");
                                    }?></font></strong></center>
                                </h2>
                                
                                <ul class="nav navbar-right panel_toolbox">
                                    <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                                    </li>
                                    <li><a class="close-link"><i class="fa fa-close"></i></a>
                                    </li>
                                </ul>
                                
                                <div class="clearfix"></div>
                            </div>
                            <div class="x_content">
                                <!-- Tahun -->
                                <div class="form-group">
                                    <label class="form-label col-md-1" style="width: 4%;margin-top: 5px;">Tahun</label>
                                    <div class="selectdiv col-md-2">
                                        <select id="grafik_tahun3" class="form-control" onchange="return grafik3()">
                                                <?php foreach($tahun as $row) {?>
                                                    <option value="<?= $row->tahun ?>"><?= $row->tahun ?></option>
                                                <?php }?>
                                            </select>
                                    </div>

                                    <!-- Tahun -->


                                    <label class="form-label col-md-1" style="width: 6%;margin-top: 5px;">Kategori</label>
                                    <div class="selectdiv col-md-2">
                                            <select id="grafik_kategori3" class="form-control" onchange="return grafik3()">
                                                <option value="semua">Semua kategori</option>
                                                <?php foreach($kategori as $row) {?>
                                                    <option value="<?= $row->kategori ?>"><?= $row->kategori ?></option>
                                                <?php }?>
                                            </select>
                                    </div>

                                </div>
                                <!--Cabang-->

                                <div id="chart-container3" style="padding-top: 55px;">
                                    <canvas id="mychart3" width="100" height="30"></canvas>
                                    
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                
<!--                NOTE : Grafik 2-->
                <div class="">
                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <div class="x_panel main-panel">
                            <div class="x_title">
                                <h2 class="kepala col-md-12">
                                    <center><strong>Grafik Komplain <font id="chart_title2">Semua Kategori Tahun <?php 
                                    if($this->m_complain_chart->complain_get_year()){
                                    echo $this->m_complain_chart->complain_get_year()->tahun;
                                    }else{
                                        echo date("Y");
                                    }?></font></strong></center>
                                </h2>
                                
                                <ul class="nav navbar-right panel_toolbox">
                                    <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                                    </li>
                                    <li><a class="close-link"><i class="fa fa-close"></i></a>
                                    </li>
                                </ul>
                                
                                <div class="clearfix"></div>
                            </div>
                            <div class="x_content">
                                <!-- Tahun -->
                                <div class="form-group">
                                    <label class="form-label col-md-1" style="width: 4%;margin-top: 5px;">Tahun</label>
                                    <div class="selectdiv col-md-2">
                                        <select id="grafik_tahun2" class="form-control" onchange="return grafik2()">
                                                <?php foreach($tahun as $row) {?>
                                                    <option value="<?= $row->tahun ?>"><?= $row->tahun ?></option>
                                                <?php }?>
                                            </select>
                                    </div>

                                    <!-- Tahun -->


                                    <label class="form-label col-md-1" style="width: 6%;margin-top: 5px;">Kategori</label>
                                    <div class="selectdiv col-md-2">
                                        <select id="grafik_kategori2" class="form-control" onchange="return grafik2()">
                                                <option value="semua">Semua kategori</option>
                                                <?php foreach($kategori as $row) {?>
                                                    <option value="<?= $row->kategori ?>"><?= $row->kategori ?></option>
                                                <?php }?>
                                            </select>
                                    </div>

                                </div>
                                <!--Cabang-->

                                <div id="chart-container2" style="padding-top: 55px;">
                                    <canvas id="mychart2" width="100" height="30"></canvas>
                                    
                                    <script>
                                        window.onload = function() {
                                            var d = new Date();
                                            var n = d.getFullYear();
                                            chart_kategori_complain1(n);
                                            chart_cabang_complain1(n);
                                        }

                                    </script>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                
                <script src="<?= base_url(); ?>assets/js/customjs/graph.js"></script>

            </div>
        </div>
    </div>
</div>
