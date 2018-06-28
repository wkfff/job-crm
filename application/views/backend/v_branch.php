<div class="page-title">
    <div class="title_left">
        <h3 class="kepala">
            <?php if($this->session->userdata('divisi') != NULL) {?>
            <?= $this->session->userdata('divisi') ?><small> - Customer Relationship Management</small></h3>
        <?php } else {?>
        <?= $this->session->userdata('cabang') ?><small> - Customer Relationship Management</small></h3>
            <?php }?>
    </div>
</div>

<div class="clearfix"></div>

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
                                <?php if($this->session->userdata('divisi') != NULL) {?>
                                <h2 class="kepala">Data Komplain pelanggan -
                                    <?= $this->session->userdata('divisi') ?>
                                </h2>
                                <?php }else{?>
                                <h2 class="kepala">Data Komplain pelanggan -
                                    <?= $this->session->userdata('cabang') ?>
                                </h2>
                                <?php } ?>
                                <div class="clearfix"></div>
                            </div>
                            <div class="x_content">
                                <?php if(!empty($komplain)) { ?>
                                <table id="myTabel" class="table table-striped table-bordered dt-responsive nowrap" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>Tiket</th>
                                            <th>Nama</th>
                                            <th>Tanggal Komplain</th>
                                            <th>Area</th>
                                            <th>Kapal</th>
                                            <th>kategori</th>
                                            <th>Urgency</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($komplain as $row) : ?>
                                        <tr>
                                            <td>
                                                <?= $row->tiket ?>
                                            </td>
                                            <td>
                                                <?= $row->nama ?>
                                            </td>
                                            <td>
                                                <?= $row->tgl_komplain ?>
                                            </td>
                                            <td>
                                                <?= $row->area ?>
                                            </td>
                                            <td>
                                                <?= $row->kapal ?>
                                            </td>
                                            <td>
                                                <?= $row->kategori ?>
                                            </td>
                                            <?php

                                                $plus ='';
                                                $diff = $row->dif;
                                                $dif = $row->dif;
                                                if($diff < 0 ){
                                                    $diff = 1;
                                                    
                                                    $dif = $row->dif*-1;
                                                    $str = '+'.$dif.' hari';
                                                }else if ( $diff == 0){
                                                    $diff = 1;
                                                    $str = 'deadline';
                                                }else{
                                                    $str = $dif.' hari';
                                                }

                                                $batas = 100/$diff;

                                                if($batas <= 40){
                                                    $bar = 'progress-bar-info progress-bar-striped active';
                                                }else if ($batas <=70){
                                                    $bar = 'progress-bar-warning progress-bar-striped active';
                                                }else{
                                                    $bar = 'progress-bar-danger progress-bar-striped active';
                                                }

                                            ?>
                                                <td>
                                                    <div class="progress">
                                                        <div class="progress-bar <?= $bar ?>" role="progressbar" aria-valuemin="0" aria-valuemax="100" style="width:<?= $batas ?>%">
                                                            <?= $str ?>
                                                        </div>
                                                    </div>
                                                </td>

                                                <td>
                                                    <button class="btn btn-info" onclick="detail(<?= $row->id_komplain ?>)" title="Klik untuk detail">
                                                    <i class="fa fa-search"></i> Detail
                                                </button>
                                                </td>
                                        </tr>

                                        <?php endforeach; ?>
                                        <tbody>
                                </table>
                                <?php } else {?>
                                <div class="alert alert-success alert-dismissable">
                                    <center>
                                        <p>Masih belum ada komplain untuk saat ini.</p>
                                    </center>
                                </div>
                                <?php }?>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="">
                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <div class="x_panel main-panel">
                            <div class="x_title">
                                <h2 class="kepala">Detail Komplain pelanggan </h2>
                                <div class="clearfix"></div>
                            </div>
                            <div class="x_content" id="detailComplain">
                                <div id="info" class="alert alert-info">
                                    Silahkan pilih data komplain
                                </div>
                                <form class="detailComplain sembunyi" method="POST" action="<?= base_url()?>dashboard/complain_update" enctype="multipart/form-data" onsubmit="return confirm('Anda yakin dengan tindakan yang diambil?')" ;> 
                                    <div class="row">
                                        <!-- left content -->
                                        <div class="col-md-6 col-sm-12 col-xs-12">
                                            <div class="form-group">
                                                <label class="control-label col-md-2 col-sm-12 col-xs-12">Tiket</label>
                                                <input type="hidden" id="id_komplain_cabang" name="id_komplain_cabang" value="" />
                                                <input type='text' id="tiket_cabang" disabled class="form-control " />
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label col-md-2 col-sm-12 col-xs-12">Nama</label>
                                                <input type='text' id="nama_cabang" disabled class="form-control " />
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label col-md-2 col-sm-12 col-xs-12">Tanggal</label>

                                                <input type='text' id="tgl_cabang" disabled class="form-control " />
                                            </div>
                                        </div>
                                        <!-- left content -->

                                        <!-- right content -->
                                        <div class="col-md-6 col-sm-12 col-xs-12">
                                            <div class="form-group">
                                                <label class="control-label col-md-2 col-sm-12 col-xs-12">Area</label>
                                                <input type='text' id="area_cabang" disabled class="form-control " />
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label col-md-2 col-sm-12 col-xs-12">Kapal</label>
                                                <input type='text' id="kapal_cabang" disabled class="form-control " />
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label col-md-2 col-sm-12 col-xs-12">Kategori</label>
                                                <input type='text' id="kategori_cabang" disabled class="form-control " />
                                            </div>
                                        </div>
                                        <!-- right content -->
                                        <div class="col-md-6 col-sm-12 col-xs-12">
                                            <div class="form-group">
                                                <label class="control-label col-md-3 col-sm-12 col-xs-12">Isi Komplain</label>
                                                <textarea id="isi_cabang" name="isi_cabang" rows="8" cols="" class="form-control" disabled></textarea>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-sm-12 col-xs-12">
                                            <div class="form-group">
                                                <label class="control-label col-md-3 col-sm-12 col-xs-12">Tindakan</label>
                                                <textarea id="tindakan_cabang" name="tindakan_cabang" rows="4" cols="" class="form-control" required></textarea>
                                            </div>



                                            <div id="moreFileUpload" class="form-group">
                                                <label class="control-label">Lampiran (Dapat berupa file image(<i>jpeg,jpg,png</i>) atau file dokumen(<i>pdf,word,excel</i>) Max Size : <i>10MB</i></label>
                                                <input type="hidden" name="tiket" id="tiket" value="">
                                                <input class="form-control" type="file" id="userfile" name="userfile" readonly="true" />
                                            </div>
                                            <div id="moreFileUploadLink" style="display:none;">
                                                <div class="row">
                                                    <div class="form-group">
                                                        <label class="control-label col-sm-2" for="bukti"></label>
                                                        <div>
                                                            <a class="btn btn-info" style="margin-left: 60px" href="javascript:void(0);" id="attachMore">Tambah
                            Lampiran <span class="glyphicon glyphicon-plus-sign"></span></a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                        <div class="form-group">
                                            <div class="col-md-3 col-sm-12 col-xs-12" style="float:right">
                                                <button type="submit" class="btn btn-success form-control">Simpan</button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('#myTabel').DataTable({
            searching: false,
            ordering: false,
            lengthChange: false
        });
    });

    function detail(id) {
        $('#info').hide();
        $('.detailComplain').hide();

        $('html, body').animate({
            scrollTop: $('#detailComplain').offset().top
        }, 500);

        $('#detailComplain').addClass('loader');

        $.ajax({
            url: "dashboard/complain_find/" + id,
            type: "GET",
            dataType: "JSON",
            success: function(data) {
                $('#id_komplain_cabang').val(data.id_komplain);
                $('#tiket_cabang').val(data.tiket);
                $('#nama_cabang').val(data.nama);
                $('#tgl_cabang').val(data.tgl_komplain);
                $('#area_cabang').val(data.area);
                $('#kapal_cabang').val(data.kapal);
                $('#kategori_cabang').val(data.kategori);
                $('#isi_cabang').val(data.isi_komplain);
                $('#tiket').val(data.tiket);

            }

        });

        $.ajax({
            url: "dashboard/complain_status_update/" + id,
            type: "POST",
            dataType: "JSON",
            success: function(data) {

            }

        });

        $('#detailComplain').removeClass('loader');

        $('.detailComplain').fadeIn();
    }

</script>
