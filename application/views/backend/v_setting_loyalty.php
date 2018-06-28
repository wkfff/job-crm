<div class="page-title">
    <div class="title_left">
        <h3 class="kepala">Setting Loyalty dan Poin<small> - Customer Relationship Management</small></h3>
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
                                <h2 class="kepala">Daftar Loyalty poin <i class="fa fa-list"></i></h2>

                                <div class="clearfix"></div>
                            </div>

                            <!-- NOTE : Loyalty - Tambah-->
                            <div class="x_content tambahLoyalty sembunyi">
                                <form id="formTambahLoyalty" onsubmit="inputLoyalty()">
                                    <div class="row">
                                        <div class="form-group col-md-3">
                                            <label class="form-label" for="asal">Tipe</label>
                                            <div class="selectdiv">
                                                <select class="form-control" id="tipe_loyalty" name="tipe_loyalty">
                                                    <option value="jarak">Jarak</option>
                                                    <option value="trip">Trip</option>
                                                    <option value="poin">Poin</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group col-md-3">
                                            <label class="form-label" for="tujuan">Nama </label>
                                            <input type="text" name="nama_loyalty" id="nama_loyalty" class="form-control" required>
                                        </div>
                                        <div class="form-group col-md-3">
                                            <label class="form-label" for="jarak">Max</label>
                                            <input type="text" class="form-control" id="max_loyalty" required>
                                        </div>
                                        <div class="form-group col-md-3">
                                            <label class="form-label" for="poin">Keterangan</label>
                                            <input type="text" class="form-control" id="keterangan_loyalty" required>
                                        </div>
                                    </div>
                                    <div clas="row">
                                        <div class="col-md-3">
                                            <input type="submit" id="btn_addLoyalty" class="form-control btn btn-success" value="Tambah">
                                        </div>
                                        <div class="col-md-3">
                                            <input type="reset" class="form-control reset btn btn-info" value="Reset">
                                        </div>
                                        <div class="col-md-3">
                                            <button class="btn btn-danger form-control" onclick="return addLoyaltyX()">Cancel</button>
                                        </div>
                                    </div>
                                </form>
                            </div>

                            <!-- NOTE : Loyalty - Update-->
                            <div class="x_content updateLoyalty sembunyi">
                                <form id="formUpdateLoyalty" onsubmit="updateLoyalty()">
                                    <div class="row">
                                        <div class="form-group col-md-3">
                                            <label class="form-label" for="asal">Tipe</label>
                                            <div class="selectdiv">
                                                <input type="hidden" id="id_loyalty">
                                                <input type="hidden" id="tipe_loyalty_u">
<!--
                                                <select class="form-control" id="tipe_loyalty_u" name="tipe_loyalty">
                                                    <option value="jarak">Jarak</option>
                                                    <option value="trip">Trip</option>
                                                    <option value="poin">Poin</option>
                                                </select>
-->
                                            </div>
                                        </div>
                                        <div class="form-group col-md-3">
                                            <label class="form-label" for="tujuan">Nama </label>
                                            <input type="text" name="nama_loyalty" id="nama_loyalty_u" class="form-control" required>
                                        </div>
                                        <div class="form-group col-md-3">
                                            <label class="form-label" for="jarak">Max</label>
                                            <input type="text" class="form-control" id="max_loyalty_u" required>
                                        </div>
                                        <div class="form-group col-md-3">
                                            <label class="form-label" for="poin">Keterangan</label>
                                            <input type="text" class="form-control" id="keterangan_loyalty_u" required>
                                        </div>
                                    </div>
                                    <div clas="row">
                                        <div class="col-md-3">
                                            <input type="submit" id="btn_updateLoyalty" class="form-control btn btn-success" value="Update">
                                        </div>
                                        <div class="col-md-3">
                                            <input type="reset" class="form-control reset_u btn btn-info" value="Reset">
                                        </div>
                                        <div class="col-md-3">
                                            <button class="btn btn-danger form-control" onclick="return updateLoyaltyX()">Cancel</button>
                                        </div>
                                    </div>
                                </form>
                            </div>

                            <!-- NOTE : Loyalty - Tabel-->
                            <div class="x_content tabelLoyalty">
                                <!--  FUTURE : Loyalty - Buttons-->
                                <?php if($this->session->userdata('userlevel') == 0) {?>
                                <div class="row">
                                    <div class="col-md-3">
                                        <button class="btn btn-success form-control" style="margin-bottom: 20px" onclick="return addLoyalty()"><i class="fa fa-plus"> Tambah Loyalty</i>
                                        </button>
                                    </div>
                                </div>
                                <?php }?>
                                <!-- FUTURE : Loyalty - Cari-->
                                <div class="row" style="margin-bottom : 5px">
                                    <div class="form-group">
                                        <label class="form-label col-md-1">Cari :</label>
                                        <div class="col-md-11">
                                            <input class="form-control" id="cariLintasan">
                                        </div>
                                    </div>
                                </div>

                                <!--                               NOTE : Tabel Loyalty - Jarak-->
                                <div class="x_panel">
                                    <div class="x_title">
                                        <h2 class="kepala">Loyalty untuk jarak </h2>
                                        <div class="clearfix"></div>
                                    </div>
                                    <table id="tabelLoyalty1" class="table table-striped table-bordered dt-responsive nowrap" width="100%" cellspacing="0">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Nama</th>
                                                <th>Jumlah Jarak</th>
                                                <th>Keterangan</th>
                                                <?php if($this->session->userdata('userlevel') == 0) {?>
                                                <th>Ordering</th>
                                                <th>Action</th>
                                                <?php } ?>
                                            </tr>
                                        </thead>
                                    </table>
                                </div>

                                <!--                                NOTE : Tabel Loyalty - Trip-->
                                <div class="x_panel">
                                    <div class="x_title">
                                        <h2 class="kepala">Loyalty untuk <i>trip frequency</i></h2>
                                        <div class="clearfix"></div>
                                    </div>
                                    <table id="tabelLoyalty2" class="table table-striped table-bordered dt-responsive nowrap" width="100%" cellspacing="0">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Nama</th>
                                                <th>Jumlah Trip</th>
                                                <th>Keterangan</th>
                                                <?php if($this->session->userdata('userlevel') == 0) {?>
                                                <th>Ordering</th>
                                                <th>Action</th>
                                                <?php } ?>
                                            </tr>
                                        </thead>
                                    </table>
                                </div>

                                <!--                               NOTE : Tabel Loyalty - Poin-->
                                <div class="x_panel">
                                    <div class="x_title">
                                        <h2 class="kepala">Loyalty untuk poin </h2>
                                        <div class="clearfix"></div>
                                    </div>
                                    <table id="tabelLoyalty3" class="table table-striped table-bordered dt-responsive nowrap" width="100%" cellspacing="0">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Nama</th>
                                                <th>Jumlah Poin</th>
                                                <th>Keterangan</th>
                                                <?php if($this->session->userdata('userlevel') == 0) {?>
                                                <th>Ordering</th>
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
</div>

<script src="<?= base_url(); ?>assets/js/customjs/serverProcessing/v_setting_tabel_lintasan.js"></script>
<script src="<?= base_url(); ?>assets/js/customjs/serverProcessing/v_setting_tabel_loyalty.js"></script>
<script src="<?= base_url(); ?>assets/js/customjs/v_setting.js"></script>
<script>
    $('#pelabuhan_tujuan').selectize();
    $('#pelabuhan_asal').selectize();

</script>
