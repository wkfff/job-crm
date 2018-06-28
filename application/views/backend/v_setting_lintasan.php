<div class="page-title">
    <div class="title_left">
        <h3 class="kepala">Setting Lintasan dan Poin<small> - Customer Relationship Management</small></h3>
    </div>
</div>

<div class="clearfix"></div>

<!-- NOTE : Notification -->
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

                <div class="">
                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <div class="x_panel main-panel">
                            <div class="x_title">
                                <h2 class="kepala">Daftar Lintasan <i class="fa fa-list"></i></h2>
                                <ul class="nav navbar-right panel_toolbox">
                                    <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                                    </li>
                                </ul>
                                <div class="clearfix"></div>
                            </div>

                            <!-- NOTE : Lintasan - Tambah-->
                            <div class="x_content tambahLintasan sembunyi">
                                <form id="formTambahLintasan" onsubmit="inputLintasan()">
                                    <div class="row">
                                        <div class="form-group col-md-3">
                                            <label class="form-label" for="asal">Pelabuhan Asal</label>
                                            <div class="selectdiv">
                                                <select class="form-control" id="pelabuhan_asal">
                                                    <?php foreach($lintasan as $row) {?>
                                                    <option value="<?= $row->id ?>"><?= $row->nama_asal ?></option>
                                                    <?php }?> 
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group col-md-3">
                                            <label class="form-label" for="tujuan">Pelabuhan Tujuan</label>
                                            <div class="selectdiv">
                                                <select class="form-control" id="pelabuhan_tujuan">
                                                    <?php foreach($lintasan as $row) {?>
                                                    <option value="<?= $row->id ?>"><?= $row->nama_asal ?></option>
                                                    <?php }?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group col-md-3">
                                            <label class="form-label" for="jarak">Jarak</label>
                                            <input type="text" class="form-control" id="jarak" placeholder="Jarak Lintasan"  required>
                                        </div>
                                        <div class="form-group col-md-3">
                                            <label class="form-label" for="poin">Poin</label>
                                            <input type="text" class="form-control" id="poin" placeholder="Poin Perjalanan"  required>
                                        </div>
                                    </div>
                                    <div clas="row">
                                       <div class="col-md-3">
                                        <input type="submit" id="btn_addLintasan" class="form-control btn btn-success" value="Tambah">
                                        </div>
                                        <div class="col-md-3">
                                        <input type="reset" class="form-control reset btn btn-info" value="Reset">
                                        </div>
                                        <div class="col-md-3">
                                        <button class="btn btn-danger form-control" onclick="return addLintasanX()">Cancel</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            
                            <!-- NOTE : Lintasan - Update-->
                            <div class="x_content updateLintasan sembunyi">
                                <form id="formUpdateLintasan" onsubmit="updateLintasan()">
                                    <div class="row">
                                        <div class="form-group col-md-3">
                                            <label class="form-label" for="asal">Pelabuhan Asal</label>
                                            <div class="selectdiv">
                                                <input type="hidden" id="id_lintasan">
                                                <select class="form-control" id="pelabuhan_asal_u">
                                                    <?php foreach($lintasan as $row) {?>
                                                    <option value="<?= $row->id ?>"><?= $row->nama_asal ?></option>
                                                    <?php }?> 
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group col-md-3">
                                            <label class="form-label" for="tujuan">Pelabuhan Tujuan</label>
                                            <div class="selectdiv">
                                                <select class="form-control" id="pelabuhan_tujuan_u">
                                                    <?php foreach($lintasan as $row) {?>
                                                    <option value="<?= $row->id ?>"><?= $row->nama_asal ?></option>
                                                    <?php }?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group col-md-3">
                                            <label class="form-label" for="jarak">Jarak</label>
                                            <input type="text" class="form-control" id="jarak_u" placeholder="Jarak Lintasan"  required>
                                        </div>
                                        <div class="form-group col-md-3">
                                            <label class="form-label" for="poin">Poin</label>
                                            <input type="text" class="form-control" id="poin_u" placeholder="Poin Perjalanan"  required>
                                        </div>
                                    </div>
                                    <div clas="row">
                                       <div class="col-md-3">
                                        <input type="submit" id="btn_updateLintasan" class="form-control btn btn-success" value="Update">
                                        </div>
                                        <div class="col-md-3">
                                        <input type="reset" class="form-control reset_u btn btn-info" value="Reset">
                                        </div>
                                        <div class="col-md-3">
                                        <button class="btn btn-danger form-control" onclick="return updateLintasanX()">Cancel</button>
                                        </div>
                                    </div>
                                </form>
                            </div>

                            <!-- NOTE : Lintasan - Tabel-->
                            <div class="x_content tabelLintasan">
                                <!--  FUTURE : Lintasan - Buttons-->
                                <?php if($this->session->userdata('userlevel') == 0) {?>
                                <div class="row">
                                    <div class="col-md-3">
                                        <button type="submit" class="btn btn-danger disabled form-control" style="margin-bottom: 20px" id="delLintasan_btn"><i class="fa fa-trash-o"> Delete Selected</i>
                                        </button>
                                    </div>
                                    <div class="col-md-3">
                                        <button class="btn btn-success form-control" style="margin-bottom: 20px" onclick="return addLintasan()"><i class="fa fa-plus"> Tambah Lintasan</i>
                                        </button>
                                    </div>
                                </div>
                                <?php }?>
                                <!-- FUTURE : Lintasan - Cari-->
                                <div class="row" style="margin-bottom : 5px">
                                    <div class="form-group">
                                        <label class="form-label col-md-1">Cari :</label>
                                        <div class="col-md-11">
                                            <input class="form-control" id="cariLintasan">
                                        </div>
                                    </div>
                                </div>
                                
                                <table id="tabelLintasan" class="table table-striped table-bordered dt-responsive nowrap" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th><input type="checkbox" name="select_all" id="bulkDelete" /></th>
                                            <th>Pelabuhan Asal</th>
                                            <th>Pelabuhan Tujuan</th>
                                            <th>Jarak</th>
                                            <th>Poin</th>
                                            <?php if($this->session->userdata('userlevel') == 0) {?>
                                            <th>Action</th>
                                            <?php } ?>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>


            </div>
        </div>
    </div>
</div>

<script src="<?= base_url(); ?>assets/js/customjs/serverProcessing/v_setting_tabel_lintasan.js"></script>
<script src="<?= base_url(); ?>assets/js/customjs/v_setting.js"></script>
<script>
    $('#pelabuhan_tujuan').selectize();
    $('#pelabuhan_asal').selectize();

</script>
