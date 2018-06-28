<script>
    $(document).ready(function() {
        //grabs the hash tag from the url
        var hash = window.location.hash;
        var res = hash.split("-");
        console.log(res[0]);

        //checks whether or not the hash tag is set
        if (hash != "") {
            //removes all active classes from tabs
            $('#myTab li').each(function() {
                $(this).removeClass('active');
            });
            $('#myTabContent div').each(function() {
                $(this).removeClass('active');
            });
            //this will add the active class on the hashtagged value
            var link = "";
            $('#myTab li').each(function() {
                link = $(this).find('a').attr('href');
                if (link == res[0]) {
                    $(this).addClass('active');
                }
            });
            $('#myTabContent div').each(function() {
                link = $(this).attr('id');
                if ('#' + link == res[0]) {
                    $(this).addClass('active');
                }
            });

            if (res[1] == 'confirm') {

            } else if (res[1] == 'detailUser') {

                detailCustomer(res[2]);

            } else if (res[1] == 'detail') {

                complain_detail(res[2]);

            } else if (res[1] == 'add') {

                addCustomer();

            } else {
                complain(res[1], decodeURI(res[2]), res[3]);
            }
        }
    });

</script>


<div class="clearfix"></div>
<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_content">

                <!-- NOTE : Notifikasi - umum -->
                <?php if(!empty($this->session->flashdata('Failed'))) {?>
                <div class="alert alert-danger alert-dismissable">
                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                    <?= $this->session->flashdata('Failed') ?>
                </div>
                <?php } else if(!empty($this->session->flashdata('Success'))) {?>
                <div class="alert alert-success alert-dismissable">
                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                    <?= $this->session->flashdata('Success') ?>
                </div>
                <?php }else if(!empty($this->session->flashdata('Info'))) {?>
                <div class="alert alert-info alert-dismissable">
                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                    <?= $this->session->flashdata('Info') ?>
                </div>
                <?php }?>

                <!-- NOTE : Notifikasi - password -->
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

                <div class="" role="tabpanel" data-example-id="togglable-tabs">
                    <ul id="myTab" class="nav nav-tabs bar_tabs" role="tablist">
                        <li role="presentation" class="active"><a href="#tab_content1" id="home-tab" role="tab" data-toggle="tab" aria-expanded="true"><b class="kepala">DATABASE AND PROFILING</b></a>
                        </li>
                        <li role="presentation" class=""><a href="#tab_content2" role="tab" id="profile-tab" data-toggle="tab" aria-expanded="false"><b class="kepala">COMPLAIN HANDLING MANAGEMENT</b></a>
                        </li>
                        <li role="presentation" class=""><a href="#tab_content3" role="tab" id="profile-tab2" data-toggle="tab" aria-expanded="false"><b class="kepala">LOYALTY CUSTOMER</b></a>
                        </li>
                    </ul>
                    <div id="myTabContent" class="tab-content">

                        <!-- NOTE : TAB 1 - start -->
                        <div role="tabpanel" class="tab-pane active " id="tab_content1" aria-labelledby="home-tab">
                            <!-- NOTE : TAB 1 - Content 1 -->

                            <div id='content0tab1' class="x_content sembunyi">
                                <div class="">
                                    <div class="col-md-12">
                                        <div class="x_panel main-panel">
                                            <div class="x_title">
                                                <!-- NOTE : TAB 1 - Content 1 - Upload Data Pelanggan-->
                                                <h2 class="kepala"><strong>UPLOAD DATA PELANGGAN</strong></h2>
                                                <div class="clearfix"></div>
                                            </div>
                                            <div class="x_content">
                                                <div class="row">
                                                    <div class="alert alert-info">
                                                        <strong>Perhatian !</strong>
                                                        <ol>
                                                            <li>Pastikan file yang di upload berekstensi .xls, .xlsx, .csv. Selain ekstensi tersebut data tidak dapat di upload</li>
                                                            <li>Pastikan format (urutan nama kolom) data excel sesuai dengan contoh. <a href="<?= base_url() ?>doc/example.xlsx" class="fa fa-download btn btn-success btn-normal"> Contoh Format</a></li>
                                                        </ol>
                                                    </div>

                                                    <div class="progress sembunyi">
                                                        <div id="progressBar" class="progress-bar progress-bar-striped active" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%">
                                                            <span class="sr-only">0%</span>
                                                        </div>
                                                    </div>

                                                    <?php echo form_open_multipart(base_url().'dashboard/customer_upload');?>
                                                    <div class="form-group">
                                                        <label class="control-label">Excel File:</label>
                                                        <input class="form-control" type="file" name="userfile" required/>
                                                    </div>
                                                    <div class="form-group">
                                                        <button class="btn btn-primary fa fa-upload btn-normal" type="submit" name="upload">Upload</button>
                                                        <button type="button" class="btn btn-danger fa fa-close btn-normal" onclick="uploadX()">Batal</button>
                                                    </div>
                                                    <?php echo form_close() ?>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- NOTE : TAB 1 - Content 1 - Tambah pelanggan-->
                            <div id='content1tab1' class="x_content sembunyi">
                                <div class="">
                                    <div class="col-md-12">
                                        <div class="x_panel main-panel">
                                            <div class="x_title">
                                                <h2 class="kepala"><strong>TAMBAH PELANGGAN</strong></h2>
                                                <div class="clearfix"></div>
                                            </div>
                                            <div class="x_content">
                                                <div class="row">
                                                    <!-- Start of form 1 -->
                                                    <form method="POST" action="<?= base_url() ?>dashboard/customer_input">

                                                        <!-- Left Content -->
                                                        <div class="col-md-6 form-group">
                                                            <div class="col-md-12 form-group">

                                                                <div id="noID" class="btn-group" data-toggle="buttons">
                                                                    <label class="btn btn-default btn-normal active labelNik" data-toggle-class="btn-primary" data-toggle-passive-class="btn-primary" onclick="noID(1)">
                                                                            <input  class="form-control noID1" id="opsiNIK" type="radio" name="noID" value="NIK"> NIK </label>
                                                                    <label class="btn btn-default btn-normal labelPass" data-toggle-class="btn-primary" data-toggle-passive-class="btn-primary" onclick="noID(2)">
                                                                            <input  class="form-control noID2" id="opsiPass" type="radio" name="noID" value="Pass"> Passport </label>
                                                                </div>
                                                            </div>
                                                            <!-- <label for="nik">NIK/PASSPORT</label>-->
                                                            <!-- <input type="text" id="nik" class="form-control" name="nik" placeholder="NIK" minlength="16" maxlength="16" onkeypress="return isNumberKey(event)" onchange="check_nik()" />-->
                                                            <div class="col-md-12 form-group">
                                                                <input type="text" id="passport" class="form-control sembunyi" name="passport" placeholder="Passport" onchange="check_passport()" />
                                                                <input type="text" id="nik" class="form-control" name="nik" placeholder="NIK" minlength="16" maxlength="16" onkeypress="return isNumberKey(event)" onchange="check_nik()" />
                                                            </div>

                                                            <div class="col-md-12 form-group">
                                                                <label for="nama">Nama <span>*</span></label>
                                                                <input type="text" id="nama" class="form-control" name="nama" required placeholder="Nama Lengkap" minlength="4" />
                                                            </div>
                                                            <div class="col-md-12 form-group">
                                                                <label for="notelp">No Telp <span>*</span></label>
                                                                <input type="text" id="notelp" class="form-control" name="notelp" onkeypress="return isNumberKey(event)" onchange="check_telp()" maxlength="13" minlength="8" required placeholder="No Telp/HP" />
                                                            </div>
                                                            <div class="col-md-12 form-group">
                                                                <label for="email">Email <span>*</span></label>
                                                                <input type="email" id="email" class="form-control" name="email" required placeholder="Alamat email" onchange="check_email()" />
                                                            </div>

                                                            <div class="col-md-12 form-group">
                                                                <label for="hari">Tempat Lahir <span>*</span></label>
                                                            </div>

                                                            <div class="col-md-12 form-group">
                                                                <input type="text" id="tmp_lahir" class="form-control" name="tmp_lahir" required placeholder="Tempat Lahir" />
                                                            </div>

                                                            <div class="col-md-12 form-group">
                                                                <label for="hari">Tanggal Lahir</label>
                                                            </div>

                                                            <div class="selectdiv col-md-3 col-sm-6 col-xs-12">
                                                                <select id="hari" name="hari" class="form-control" required>
                                                            <?php for($i=1;$i<=31;$i++) {?>
                                                                <option value="<?= $i ?>"><?= $i ?></option>
                                                            <?php } ?>         
                                                        </select>

                                                                <script>
                                                                    $('#hari').selectize();

                                                                </script>
                                                            </div>

                                                            <div class="selectdiv col-md-4">
                                                                <select id="bulan" name="bulan" class="form-control" required>
                                                            <option value="1">Januari</option>
                                                            <option value="2">Februari</option>
                                                            <option value="3">Maret</option>
                                                            <option value="4">April</option>
                                                            <option value="5">Mei</option>
                                                            <option value="6">Juni</option>
                                                            <option value="7">Juli</option>
                                                            <option value="8">Augustus</option>
                                                            <option value="9">September</option>
                                                            <option value="10">Oktober</option>
                                                            <option value="11">November</option>
                                                            <option value="12">Desember</option>        
                                                        </select>
                                                            </div>
                                                            <div class="selectdiv col-md-4 col-sm-12 col-xs-12">
                                                                <select id="tahun" name="tahun" class="form-control" required>
                                                            <?php $yearNow = date("Y"); for($i=$yearNow;$i>=($yearNow-100);$i--) {?>
                                                                <option value="<?= $i ?>"><?= $i ?></option>
                                                            <?php } ?> 
                                                        </select>

                                                                <script>
                                                                    $('#tahun').selectize();

                                                                </script>
                                                            </div>
                                                        </div>
                                                        <!-- Left Content -->
                                                        <!-- Right Content -->
                                                        <div class="col-md-6 form-group">
                                                            <div class="col-md-12 form-group">
                                                                <label class="warga" for="warga">Kewarganegaraan <span>*</span></label>
                                                            </div>
                                                            <div class="col-md-12 col-sm-12 col-xs-12 form-group">
                                                                <div id="warga" class="btn-group" data-toggle="buttons">
                                                                    <label class="btn btn-default btn-normal active warga1" data-toggle-class="btn-primary" data-toggle-passive-class="btn-primary" onclick="noIDre('WNI')">
                                                                <input  class="form-control" id="warga1" type="radio" name="warga" value="WNI" required > WNI
                                                            </label>
                                                                    <label class="btn btn-default btn-normal warga2" data-toggle-class="btn-primary" data-toggle-passive-class="btn-primary" onclick="noIDre('WNA')">
                                                                <input  class="form-control" id="warga2" type="radio" name="warga" value="WNA" required > WNA
                                                            </label>
                                                                </div>
                                                            </div>

                                                            <div class="col-md-12 col-sm-12 col-xs-12 form-group">
                                                                <label class="jarak" for="gender">Jenis Kelamin <span>*</span></label>
                                                            </div>
                                                            <div class="col-md-12 col-sm-12 col-xs-12 form-group">
                                                                <div id="gender" class="btn-group" data-toggle="buttons">
                                                                    <label class="btn btn-default btn-normal" data-toggle-class="btn-primary" data-toggle-passive-class="btn-primary">
                                                                <input  class="form-control" type="radio" name="gender" value="L" required> Laki-laki
                                                            </label>
                                                                    <label class="btn btn-default btn-normal" data-toggle-class="btn-primary" data-toggle-passive-class="btn-primary">
                                                                <input  class="form-control" type="radio" name="gender" value="P" required> Perempuan
                                                            </label>
                                                                </div>
                                                            </div>

                                                            <div class="col-md-12 col-sm-12 col-xs-12 form-group">
                                                                <label class="jarak" for="pekerjaan">Pekerjaan <span>*</span></label>
                                                            </div>
                                                            <div class="selectdiv col-md-6 col-sm-12 col-xs-12">
                                                                <select id="pekerjaan" name="pekerjaan" class="form-control" required>
                                                            <option value="" disabled selected>Pilih Pekerjaan...</option>
                                                            <option value="Belum/Tidak bekerja">Belum/Tidak Bekerja</option>
                                                            <option value="Karyawan Swasta">Karyawan Swasta</option>
                                                            <option value="Karyawan BUMN/BUMD">Karyawan BUMN/BUMD</option>
                                                            <option value="Pelajar/Mahasiswa">Pelajar/Mahasiswa</option>
                                                            <option value="Guru">Guru</option>
                                                            <option value="PNS">PNS</option>
                                                            <option value="Wiraswasta">Wiraswasta</option>
                                                            <option value="1">Lainya...</option>
                                                        </select>
                                                                <input type="text" name="pekerjaan2" id="pekerjaan2" class="form-control sembunyi" placeholder="Pekerjaan" style="margin-top:5px" required="False">
                                                            </div>
                                                            <div class=" col-md-6 col-sm-12 col-xs-12">
                                                                <input type="text" name="perusahaan" id="perusahaan" class="form-control" placeholder="Perusahaan/instansi...." />
                                                            </div>
                                                            <div class="col-md-12 col-sm-12 col-xs-12 form-group">
                                                                <label class="jarak" for="alamat">Alamat <span>*</span></label>
                                                                <textarea id="alamat" class="form-control" name="alamat" rows="1" cols="" style="border-bottom-right-radius: 0px" required placeholder="Alamat"></textarea>
                                                            </div>
                                                            <div class="col-md-12 col-sm-12 col-xs-12 form-group">
                                                                <label for="sosmed">Media Sosial <small style="color:888">(jika ada)</small></label>
                                                                <div id="sosmed" class="btn-group sosmed" data-toggle="buttons">
                                                                    <label class="btn btn-default btn-normal" data-toggle-class="btn-primary" data-toggle-passive-class="btn-primary">
                                                                <input  class="form-control" type="radio" onclick="radio(this)" name="sosmed" value="Facebook"> &nbsp;Facebook
                                                            </label>
                                                                    <label class="btn btn-default btn-normal" data-toggle-class="btn-primary" data-toggle-passive-class="btn-primary">
                                                                <input  class="form-control" type="radio" onclick="radio(this)" name="sosmed" value="Twitter"> &nbsp;Twitter&nbsp;
                                                            </label>
                                                                    <label class="btn btn-default btn-normal" data-toggle-class="btn-primary" data-toggle-passive-class="btn-primary">
                                                                <input  class="form-control" type="radio" onclick="radio(this)" name="sosmed" value="Instagram"> Instagram
                                                            </label>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-12 col-sm-12 col-xs-12 form-group" style="{{disp}}">
                                                                <input type="text" name="nama_medsos" id="nama_medsos" class="form-control" placeholder="Nama Medsos" />
                                                            </div>
                                                            <div class="col-md-12 col-sm-12 col-xs-12 form-group">
                                                                <div style="border-bottom: 2px solid #E6E9ED;margin: 10px;padding: 1px 5px 6px;"></div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3 col-sm-12 col-xs-12 form-group" style="float:right">
                                                            <a id="addXCustomer_btn" class="form-control btn btn-danger">Batal</a>
                                                        </div>
                                                        <div class="col-md-3 col-sm-12 col-xs-12 form-group" style="float:right">
                                                            <button type="submit" class="form-control btn btn-primary">Submit</button>
                                                        </div>
                                                    </form>
                                                    <!-- End of form 1 -->

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <!-- End of first content -->
                            <!-- NOTE : TAB 1 - Content 2 -->
                            <div class="">
                                <div class="col-md-12 col-sm-12 col-xs-12">
                                    <div class="x_panel main-panel">
                                        <div class="x_title">
                                            <!-- NOTE : TAB 1 - Content 2 - Tabel pelanggan-->
                                            <h2 class="kepala"><strong>TABEL DATABASE PELANGGAN</strong></h2>
                                            <div class="clearfix"></div>
                                        </div>
                                        <div class="x_content">
                                            <?php if($this->session->userdata('userlevel') == 0) {?>
                                            <div class="col-md-3">
                                                <button type="submit" class="btn btn-danger disabled form-control" style="margin-bottom: 20px" id="delCustomer_btn"><i class="fa fa-trash-o"> Delete Selected</i>
                                        </button>
                                            </div>
                                            <?php }?>
                                            <div class="col-md-3">
                                                <a class="btn btn-primary form-control" style="margin-bottom: 20px" id="addCustomer_btn" onclick="return addCustomer()">
                                            <i class="fa fa-plus-circle"> Tambah Pelanggan</i>
                                        </a>
                                            </div>

                                            <div class="col-md-3">
                                                <a class="btn btn-primary form-control" style="margin-bottom: 20px" id="uploadCustomer_btn" onclick="return upload_data()">
                                            <i class="fa fa-upload"> Upload Data </i>
                                        </a>
                                            </div>

                                            <div class="col-md-3">
                                                <a class="btn btn-primary form-control" style="margin-bottom: 20px" id="downloadCustomer_btn" href="<?= base_url()?>dashboard/download_excel">
                                            <i class="fa fa-download"> Download Data </i>
                                        </a>
                                            </div>

                                            <table id="tabelCustomer" class="table table-striped table-bordered dt-responsive nowrap" width="100%" cellspacing="0">
                                                <thead>
                                                    <tr>
                                                        <th><input type="checkbox" name="select_all" id="bulkDelete" /></th>
                                                        <th>ID Customer</th>
                                                        <th>NIK/Passport</th>
                                                        <th>Nama</th>
                                                        <th>No telp</th>
                                                        <th>Gender</th>
                                                        <th>TTL</th>
                                                        <th>Email</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                            </table>

                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- end of second content -->

                            <div>
                                <!-- NOTE : TAB 1 - Content 3 -->
                                <div class="">
                                    <div class="col-md-6 col-sm-12 col-xs-12">
                                        <div class="x_panel main-panel" id="thirdContent">
                                            <div class="x_title">
                                                <!--NOTE : TAB 1 - Content 3 - Detail Pelanggan-->
                                                <h2 class="kepala"><strong>DETAIL PELANGGAN : <font id="d_userid">-</font></strong></h2>
                                                <div class="clearfix"></div>
                                            </div>
                                            <div class="x_content" id="detailCustomer">

                                                <div id="info1" class="alert alert-info">
                                                    Silahkan pilih data pelanggan
                                                </div>
                                                <!-- Detail Left Content -->
                                                <form class="form-horizontal detailCustomer sembunyi" method="POST" action="<?= base_url()?>dashboard/customer_update">

                                                    <!-- FUTURE : Passport or NIK-->
                                                    <div class="col-md-12 form-group formUpdate">
                                                        <div id="noID2" class="btn-group" data-toggle="buttons">
                                                            <label class="btn btn-default btn-normal active d_nik_radio" data-toggle-class="btn-primary" data-toggle-passive-class="btn-primary" onclick="noID2(1)">
                                                                    <input  class="form-control " type="radio" id="d_nik_radio" name="d_nik_radio" value="NIK"> NIK </label>
                                                            <label class="btn btn-default btn-normal d_pass_radio" data-toggle-class="btn-primary" data-toggle-passive-class="btn-primary" onclick="noID2(2)">
                                                                    <input  class="form-control " type="radio" id="d_pass_radio" name="d_pass_radio" value="Pass"> Passport </label>
                                                        </div>
                                                    </div>

                                                    <!-- FUTURE : Passport -->
                                                    <div class="form-group formDetail formPass1">
                                                        <label class="control-label col-md-3 col-sm-12 col-xs-12" for="passport">Passport</label>
                                                        <label class="control-label col-md-1 col-sm-12 col-xs-12" for="nama">:</label>
                                                        <div id="d_passtext" class="col-md-8 col-sm-6 col-xs-12" style="padding-top: 10px;">
                                                            -
                                                        </div>
                                                    </div>
                                                    <div class="form-group sembunyi formUpdate formPass2">
                                                        <label class="control-label col-md-12 col-sm-12 col-xs-12" for="nama">Passport</label>
                                                    </div>
                                                    <div class="form-group sembunyi formUpdate formPass2">
                                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                                            <input type="hidden" id="d_passport_old" name="d_passport_old">
                                                            <input type="text" name="d_passport" class="form-control" id="d_passport" placeholder="Passport">
                                                        </div>
                                                    </div>

                                                    <!-- FUTURE : NIK -->
                                                    <div class="form-group formDetail formNik1">
                                                        <label class="control-label col-md-3 col-sm-12 col-xs-12" for="nik">NIK</label>
                                                        <label class="control-label col-md-1 col-sm-12 col-xs-12" for="nama">:</label>
                                                        <div id="d_niktext" class="col-md-8 col-sm-6 col-xs-12" style="padding-top: 10px;">
                                                            -
                                                        </div>
                                                    </div>
                                                    <div class="form-group sembunyi formUpdate formNik2">
                                                        <label class="control-label col-md-12 col-sm-12 col-xs-12" for="nama">NIK</label>
                                                    </div>
                                                    <div class="form-group sembunyi formUpdate formNik2">
                                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                                            <input type="hidden" id="d_nik_old" name="d_nik_old">
                                                            <input type="text" name="d_nik" class="form-control" id="d_nik" placeholder="Nik" maxlenght="16" minlenght="16">
                                                        </div>
                                                    </div>
                                                    <!-- </nik> -->

                                                    <!-- <nama> -->
                                                    <div class="form-group formDetail">
                                                        <label class="control-label col-md-3 col-sm-12 col-xs-12" for="nama">Nama</label>
                                                        <label class="control-label col-md-1 col-sm-12 col-xs-12" for="nama">:</label>
                                                        <div id="d_namatext" class="col-md-8 col-sm-6 col-xs-12" style="padding-top: 10px;">
                                                            -
                                                        </div>
                                                    </div>
                                                    <div class="form-group sembunyi formUpdate">
                                                        <label class="control-label col-md-12 col-sm-12 col-xs-12" for="nama">Nama</label>
                                                    </div>
                                                    <div class="form-group sembunyi formUpdate">
                                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                                            <input type="hidden" name="d_id" class="form-control" id="d_id">
                                                            <input type="text" name="d_nama" class="form-control" id="d_nama" placeholder="Nama" required>
                                                        </div>
                                                    </div>
                                                    <!-- </nama> -->

                                                    <!-- <TTLahir> -->
                                                    <div class="form-group formDetail">
                                                        <label class="control-label col-md-3 col-sm-12 col-xs-12" for="tgl">TTL</label>
                                                        <label class="control-label col-md-1 col-sm-12 col-xs-12" for="tgl">:</label>
                                                        <div id="d_tgltext" class="col-md-8 col-sm-6 col-xs-12" style="padding-top: 10px;">
                                                            -
                                                        </div>
                                                    </div>
                                                    <div class="form-group sembunyi formUpdate">
                                                        <label class="control-label col-md-12 col-sm-12 col-xs-12" for="tgl">TTL</label>
                                                    </div>
                                                    <div class="form-group sembunyi formUpdate">
                                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                                            <input type="text" name="d_tmplahir" class="form-control" id="d_tmplahir" placeholder="Tempat Lahir" required style="margin-bottom:5px">
                                                        </div>
                                                        <div class="selectdiv col-md-3 col-sm-6 col-xs-12 ">
                                                            <select id="d_tglhari" name="d_hari" class="form-control" required>
                                                        <?php for($i=1;$i<=31;$i++) {?>
                                                            <option value="<?= $i ?>"><?= $i ?></option>
                                                        <?php } ?>         
                                                    </select>
                                                        </div>
                                                        <div class="selectdiv col-md-4 col-sm-12 col-xs-12">
                                                            <select id="d_tglbulan" name="d_bulan" class="form-control" required>
                                                        <option value="01">Januari</option>
                                                        <option value="02">Februari</option>
                                                        <option value="03">Maret</option>
                                                        <option value="04">April</option>
                                                        <option value="05">Mei</option>
                                                        <option value="06">Juni</option>
                                                        <option value="07">Juli</option>
                                                        <option value="08">Augustus</option>
                                                        <option value="09">September</option>
                                                        <option value="10">Oktober</option>
                                                        <option value="11">November</option>
                                                        <option value="12">Desember</option>        
                                                    </select>
                                                        </div>
                                                        <div class="selectdiv col-md-4 col-sm-12 col-xs-12">
                                                            <select id="d_tgltahun" name="d_tahun" class="form-control" required>
                                                        <?php $yearNow = date("Y"); for($i=$yearNow;$i>=($yearNow-100);$i--) {?>
                                                            <option value="<?= $i ?>"><?= $i ?></option>
                                                        <?php } ?> 
                                                    </select>
                                                        </div>
                                                    </div>
                                                    <!-- </TTLahir> -->

                                                    <!-- <Warga> -->
                                                    <div class="form-group formDetail">
                                                        <label class="control-label col-md-3 col-sm-12 col-xs-12" for="gender"><small>Kewarganegaraan</small></label>
                                                        <label class="control-label col-md-1 col-sm-12 col-xs-12" for="gender">:</label>
                                                        <div id="d_wargatext" class="col-md-8 col-sm-6 col-xs-12" style="padding-top: 10px;">
                                                            -
                                                        </div>
                                                    </div>
                                                    <div class="form-group sembunyi formUpdate">
                                                        <label class="control-label col-md-12 col-sm-12 col-xs-12" for="gender"><small>Kewarganegaraan</small></label>
                                                    </div>
                                                    <div class="form-group sembunyi formUpdate">
                                                        <div id="warga" class="btn-group" data-toggle="buttons">
                                                            <label class="btn btn-default btn-normal d_warga1" data-toggle-class="btn-primary" data-toggle-passive-class="btn-primary">
                                                        <input id="d_warga1"  class="form-control" type="radio" name="d_warga" value="WNA" required> WNI
                                                    </label>
                                                            <label class="btn btn-default btn-normal d_warga2" data-toggle-class="btn-primary" data-toggle-passive-class="btn-primary">
                                                        <input id="d_warga2"  class="form-control" type="radio" name="d_warga" value="WNI" required> WNA
                                                    </label>
                                                        </div>
                                                    </div>
                                                    <!-- </warga> -->

                                                    <!-- <gender> -->
                                                    <div class="form-group formDetail">
                                                        <label class="control-label col-md-3 col-sm-12 col-xs-12" for="gender"><small>Jenis Kelamin</small></label>
                                                        <label class="control-label col-md-1 col-sm-12 col-xs-12" for="gender">:</label>
                                                        <div id="d_gendertext" class="col-md-8 col-sm-6 col-xs-12" style="padding-top: 10px;">
                                                            -
                                                        </div>
                                                    </div>
                                                    <div class="form-group sembunyi formUpdate">
                                                        <label class="control-label col-md-12 col-sm-12 col-xs-12" for="gender"><small>Jenis Kelamin</small></label>
                                                    </div>
                                                    <div class="form-group sembunyi formUpdate">
                                                        <div id="gender" class="btn-group" data-toggle="buttons">
                                                            <label class="btn btn-default btn-normal d_gender1" data-toggle-class="btn-primary" data-toggle-passive-class="btn-primary">
                                                        <input id="d_gender1"  class="form-control" type="radio" name="d_gender" value="L" required> Laki-laki
                                                    </label>
                                                            <label class="btn btn-default btn-normal d_gender2" data-toggle-class="btn-primary" data-toggle-passive-class="btn-primary">
                                                        <input id="d_gender2"  class="form-control" type="radio" name="d_gender" value="P" required> Perempuan
                                                    </label>
                                                        </div>
                                                    </div>
                                                    <!-- </gender> -->

                                                    <!-- <alamat>-->
                                                    <div class="form-group formDetail">
                                                        <label class="control-label col-md-3 col-sm-12 col-xs-12" for="job">Alamat</label>
                                                        <label class="control-label col-md-1 col-sm-12 col-xs-12" for="job">:</label>
                                                        <div id="d_alamattext" class="col-md-8 col-sm-12 col-xs-12" style="padding-top: 10px;">
                                                            -
                                                        </div>
                                                    </div>
                                                    <div class="form-group sembunyi formUpdate">
                                                        <label class="control-label col-md-12 col-sm-12 col-xs-12" for="nama">Alamat</label>
                                                    </div>
                                                    <div class="form-group sembunyi formUpdate">
                                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                                            <textarea id="d_alamat" class="form-control" name="d_alamat" rows="1" cols="" style="border-bottom-right-radius: 0px" required placeholder="Alamat"></textarea>
                                                        </div>
                                                    </div>
                                                    <!-- </alamat> -->

                                                    <!-- <telp> -->
                                                    <div class="form-group formDetail">
                                                        <label class="control-label col-md-3 col-sm-12 col-xs-12" for="telp">Telp</label>
                                                        <label class="control-label col-md-1 col-sm-12 col-xs-12" for="telp">:</label>
                                                        <div id="d_telptext" class="col-md-8 col-sm-6 col-xs-12" style="padding-top: 10px;">
                                                            -
                                                        </div>
                                                    </div>
                                                    <div class="form-group sembunyi formUpdate">
                                                        <label class="control-label col-md-12 col-sm-12 col-xs-12" for="telp">Telp</label>
                                                    </div>
                                                    <div class="form-group sembunyi formUpdate">
                                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                                            <input type="text" name="d_telp" class="form-control" id="d_telp" placeholder="Telp" onkeypress="return isNumberKey(event)" required>
                                                        </div>
                                                    </div>
                                                    <!-- </telp> -->

                                                    <!-- <email> -->
                                                    <div class="form-group formDetail">
                                                        <label class="control-label col-md-3 col-sm-12 col-xs-12" for="email">Email</label>
                                                        <label class="control-label col-md-1 col-sm-12 col-xs-12" for="email">:</label>
                                                        <div id="d_emailtext" class="col-md-8 col-sm-6 col-xs-12" style="padding-top: 10px;">
                                                            -
                                                        </div>
                                                    </div>
                                                    <div class="form-group sembunyi formUpdate">
                                                        <label class="control-label col-md-12 col-sm-12 col-xs-12" for="email">Email</label>
                                                    </div>
                                                    <div class="form-group sembunyi formUpdate">
                                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                                            <input type="email" name="d_email" class="form-control" id="d_email" placeholder="Email" value="-">
                                                        </div>
                                                    </div>
                                                    <!-- </email> -->

                                                    <!-- <job> -->
                                                    <div class="form-group formDetail">
                                                        <label class="control-label col-md-3 col-sm-12 col-xs-12" for="job">Pekerjaan</label>
                                                        <label class="control-label col-md-1 col-sm-12 col-xs-12" for="job">:</label>
                                                        <div id="d_jobtext" class="col-md-8 col-sm-12 col-xs-12" style="padding-top: 10px;">
                                                            -
                                                        </div>
                                                        <label class="control-label col-md-3 col-sm-12 col-xs-12" for="job">&nbsp;&nbsp;<small>Perusahan</small></label>
                                                        <label class="control-label col-md-1 col-sm-12 col-xs-12" for="job">:</label>
                                                        <div id="d_companytext" class="col-md-8 col-sm-12 col-xs-12" style="padding-top: 10px;">
                                                            -
                                                        </div>
                                                    </div>
                                                    <div class="form-group sembunyi formUpdate">
                                                        <label class="control-label col-md-12 col-sm-12 col-xs-12" for="job">Pekerjaan</label>
                                                    </div>
                                                    <div class="form-group sembunyi formUpdate">
                                                        <div class="selectdiv col-md-6 col-sm-12 col-xs-12">
                                                            <select id="d_job" name="d_job" class="form-control" onchange="job()" required>
                                                        <option value="Belum/Tidak bekerja">Belum/Tidak Bekerja</option>
                                                        <option value="Karyawan Swasta">Karyawan Swasta</option>
                                                        <option value="Karyawan BUMN/BUMD">Karyawan BUMN/BUMD</option>
                                                        <option value="Pelajar/Mahasiswa">Pelajar/Mahasiswa</option>
                                                        <option value="Guru">Guru</option>
                                                        <option value="PNS">PNS</option>
                                                        <option value="Wiraswasta">Wiraswasta</option>
                                                        <option value="1">Lainya...</option>
                                                    </select>
                                                            <input type="text" name="d_job2" id="d_job2" class="form-control sembunyi" placeholder="Pekerjaan" style="margin-top:5px">
                                                        </div>
                                                        <div class=" col-md-6 col-sm-12 col-xs-12">
                                                            <input type="text" name="d_company" id="d_company" class="form-control" placeholder="Perusahaan/instansi...." />
                                                        </div>
                                                    </div>
                                                    <!-- </job> -->

                                                    <!-- <medsos> -->
                                                    <div class="form-group formDetail">
                                                        <label class="control-label col-md-3 col-sm-12 col-xs-12" for="medsos">Medsos</label>
                                                        <label class="control-label col-md-1 col-sm-12 col-xs-12" for="medsos">:</label>
                                                        <div id="d_medsostext" class="col-md-8 col-sm-12 col-xs-12" style="padding-top: 10px;">
                                                            -
                                                        </div>
                                                        <label class="control-label col-md-3 col-sm-12 col-xs-12" for="medsos">&nbsp;&nbsp;<small>Nama Medsos</small></label>
                                                        <label class="control-label col-md-1 col-sm-12 col-xs-12" for="medsos">:</label>
                                                        <div id="d_namamedsostext" class="col-md-8 col-sm-12 col-xs-12" style="padding-top: 10px;">
                                                            -
                                                        </div>
                                                    </div>
                                                    <div class="form-group sembunyi formUpdate">
                                                        <label class="control-label col-md-12 col-sm-12 col-xs-12" for="medsos">Medsos</label>
                                                    </div>
                                                    <div class="form-group sembunyi formUpdate">
                                                        <div class=" col-md-12 col-sm-12 col-xs-12">
                                                            <div id="d_sosmed" class="btn-group" data-toggle="buttons">
                                                                <label class="btn btn-default btn-normal d_sosmed1" data-toggle-class="btn-primary" onclick="showMedsosName()" data-toggle-passive-class="btn-primary">
                                                            <input id="d_sosmed1"  class="form-control" type="radio" name="d_sosmed"  value="Facebook"> &nbsp;Facebook
                                                        </label>
                                                                <label class="btn btn-default btn-normal d_sosmed2" data-toggle-class="btn-primary" onclick="showMedsosName()" data-toggle-passive-class="btn-primary">
                                                            <input id="d_sosmed2"  class="form-control" type="radio" name="d_sosmed"  value="Twitter"> &nbsp;Twitter&nbsp;
                                                        </label>
                                                                <label class="btn btn-default btn-normal d_sosmed3" data-toggle-class="btn-primary" onclick="showMedsosName()" data-toggle-passive-class="btn-primary">
                                                            <input id="d_sosmed3"  class="form-control" type="radio" name="d_sosmed"  value="Instagram"> Instagram
                                                        </label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group sembunyi formUpdate">
                                                        <div class="col-md-12 col-sm-12 col-xs-12 d_namamedsos sembunyi">
                                                            <input type="text" name="d_namassosmed" id="d_namamedsos" class="form-control" placeholder="Nama Medsos" />
                                                        </div>
                                                    </div>
                                                    <!-- </medsos> -->

                                                    <div class="col-md-12 col-sm-12 col-xs-12 form-group">
                                                        <div style="border-bottom: 2px solid #E6E9ED;margin: 10px;padding: 1px 5px 6px;"></div>
                                                    </div>

                                                    <div class="form-group detailCustomerBtn1 sembunyi">
                                                        <button id="detailCustomerBtn1" type="button" class="form-control btn btn-primary" onclick="detailCustomerEdit()"><i class="fa fa-edit"></i> edit</button>
                                                    </div>

                                                    <div class="form-group detailCustomerBtn2 sembunyi">
                                                        <div class="col-md-6 col-sm-12 col-xs-12">
                                                            <button id="detailCustomerBtn2" type="button" class="form-control btn btn-danger" onclick="detailCustomerCancel()">Cancel</button>
                                                        </div>
                                                        <div class="col-md-6 col-sm-12 col-xs-12">
                                                            <button id="detailCustomerBtn3" type="submit" class="form-control btn btn-success col-md-6 col-sm-12 col-xs-12"><i class="fa fa-save"></i> Simpan</button>
                                                        </div>
                                                    </div>

                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- end of thrird content -->


                                <div class="">
                                    <div class="col-md-6 col-sm-12 col-xs-12">
                                        <div class="x_panel main-panel" id="fourthContent">
                                            <div class="x_title">
                                                <!--NOTE : TAB 1 - Content 3 - Tambah Perjalanan-->
                                                <h2 class="kepala"><strong>TAMBAH PERJALANAN</strong></h2>
                                                <div class="clearfix"></div>
                                            </div>
                                            <div class="x_content fourth4">
                                                <div id="info2" class="alert alert-info">
                                                    Silahkan pilih data pelanggan
                                                </div>
                                                <!--                                                    -->
                                                <form id="formPerjalanan" class="sembunyi" onsubmit="perjalanan_add()">
                                                    <div class=" form-group">
                                                        <label for="pelabuhan asal" class="form-label">Pelabuhan Asal</label>
                                                        <div class="selectdiv ">
                                                            <input type="hidden" name="id_perjalanan" id="id_perjalanan">
                                                            <input type="hidden" name="id_customer" id="id_customer">
                                                            <select id="daerah_asal" name="pelabuhan_asal" class="form-control" onchange="findJadwal()" required placeholder="Pilih Pelabuhan Asal ...">
                                                    </select>
                                                        </div>
                                                    </div>
                                                    <div class=" form-group">
                                                        <label for="pelabuhan tujuan" class="form-label">Pelabuhan Tujuan</label>
                                                        <div class="selectdiv ">
                                                            <select id="daerah_tujuan" name="pelabuhan_tujuan" class="form-control" required placeholder="Pilih Pelabuhan Tujuan ...">
                                                            <option disabled selected>Pilih Pelabuhan Tujuan ...</option>
                                                    </select>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="tgl" class="form-label">Tanggal Berangkat</label>
                                                        <div>
                                                            <input id="tgl_berangkat" name="tgl_berangkat" type="text" class="form-control" readonly required>
                                                        </div>

                                                    </div>
                                                    <div class="form-group">
                                                        <label for="jenis kendaraan" class="form-label">Jenis Layanan</label>
                                                        <div class="row">
                                                            <div class="selectdiv col-md-5 col-sm-12 col-xs-12">
                                                                <select id="kendaraan" class="form-control col-md-3 col-sm-12 col-xs-12" name="kendaraan" onchange="golAnimate()">
                                                            <option value="Tidak Berkendara">Tidak Berkendara</option>
                                                            <option value="Berkendaraan">Berkendara</option>
                                                        </select>
                                                            </div>
                                                            <div class="selectdiv col-md-5 col-sm-12 col-xs-12 golongan" style="display:none">
                                                                <select class="form-control col-md-2 col-sm-12 col-xs-12" id="golongan" name="golongan">
                                                            <option value="-" selected>-</option>
                                                        </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <div class="row">
                                                            <div class="col-md-12 col-sm-12 col-xs-12">
                                                                <label class="form-label">Jumlah Penumpang</label>
                                                            </div>
                                                            <div class="selectdiv col-md-3 col-sm-8 col-xs-12">
                                                                <select id="penumpang" name="penumpang" class="form-control" required>
                                                                    <?php for($i=1;$i<=99;$i++) {?>
                                                                        <option value="<?= $i ?>"><?= $i ?></option>
                                                                    <?php } ?>         
                                                                </select>
                                                            </div>
                                                            <div class="col-md-3 col-sm-4 col-xs-12">
                                                                <label class="form-label" style="margin-top:5px"><small>&gt; 3 Tahun</small></label>
                                                            </div>
                                                            <div class="selectdiv col-md-3 col-sm-8 col-xs-12">
                                                                <select id="penumpang2" name="penumpang2" class="form-control" required>
                                                                    <?php for($i=0;$i<=99;$i++) {?>
                                                                        <option value="<?= $i ?>"><?= $i ?></option>
                                                                    <?php } ?>         
                                                                </select>
                                                            </div>
                                                            <div class="col-md-3 col-sm-4 col-xs-12">
                                                                <label class="form-label" style="margin-top:5px"><small>&lt; 3 Tahun <b>(Infant)</b></small></label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <div style="border-bottom: 2px solid #E6E9ED;margin: 10px;padding: 1px 5px 6px;"></div>
                                                    </div>
                                                    <div class="form-group">
                                                        <div class="col-md-6 col-sm-12 col-xs-12">
                                                            <input type="submit" class="form-control btn btn-primary" id="btnadd_perjalanan" value="Add" />
                                                        </div>
                                                        <div class="col-md-6 col-sm-12 col-xs-12">
                                                            <button type="reset" class="form-control btn btn-info">Reset</button>
                                                        </div>
                                                    </div>
                                                </form>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- last of fourth content -->

                            <!-- NOTE : TAB 1 - Content 4 -->
                            <div class="">
                                <div class="col-md-12 col-sm-12 col-xs-12">
                                    <div class="x_panel main-panel " id="tabel_perjalanan" style="display:none">
                                        <div class="x_title">
                                            <!-- NOTE :   TAB 1 - Content 4 - Tabel Perjalanan Pelanggan-->
                                            <h2 class="kepala"><strong>TABEL PERJALANAN PELANGGAN</strong></h2>
                                            <div class="clearfix"></div>
                                        </div>
                                        <div class="x_content">

                                            <table id="historyCustomerTrip" class="table table-bordered table-striped">
                                                <thead>
                                                    <tr>
                                                        <th>No</th>
                                                        <th>Pelabuhan Asal</th>
                                                        <th>Pelabuhan Tujuan</th>
                                                        <th>Tanggal Berangkat</th>
                                                        <th>Kendaraan</th>
                                                        <th>Golongan</th>
                                                        <th>Penumpang > 3Th</th>
                                                        <th>Penumpang
                                                            < 3Th</th>
                                                                <th>Action</th>
                                                    </tr>
                                                </thead>
                                            </table>

                                            <script src="<?= base_url(); ?>assets/js/customjs/serverProcessing/v_main_tabel_history_trip.js"></script>
                                            <!-- tabel History Perjalanan -->

                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- last of fifth content -->
                        </div>
                        <!-- END OF TAB1 -->




                        <!-- NOTE :  TAB 2 -->
                        <div role="tabpanel" class="tab-pane" id="tab_content2" aria-labelledby="profile-tab">
                            <!-- NOTE : TAB 2 - Content 1 -->
                            <div class="">
                                <div class="col-md-12 col-sm-12 col-xs-12">
                                    <div class="x_panel main-panel">
                                        <div class="x_title">
                                            <!-- NOTE : TAB 2 - Content 1 - Tabel Pelanggan -->
                                            <h2 class="kepala"><strong>TABEL PELANGGAN</strong></h2>
                                            <div class="clearfix"></div>
                                        </div>
                                        <div class="x_content">
                                            <table id="tabelCustomer2" class="table table-striped table-bordered dt-responsive nowrap" width="100%" cellspacing="0">
                                                <thead>
                                                    <tr>
                                                        <th>ID Customer</th>
                                                        <th>Nama</th>
                                                        <th>Umur</th>
                                                        <th>Gender</th>
                                                        <th>TTL</th>
                                                        <th>Telp</th>
                                                        <th>email</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>

                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- end of first content -->
                            <!-- NOTE : TAB 2 - Content 2 -->
                            <div class="">
                                <div class="complain1 col-md-12 col-sm-12 col-xs-12 sembunyi">
                                    <div class="x_panel main-panel">
                                        <div class="x_title">
                                            <!-- NOTE : TAB 2 - Content 2  - Tambah Komplain -->
                                            <h2 class="kepala"><strong>Tambah Komplain</strong></h2>
                                            <ul class="nav navbar-right panel_toolbox">
                                                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                                                </li>
                                            </ul>
                                            <div class="clearfix"></div>
                                        </div>
                                        <div class="x_content" id="loading1">
                                            <form id="addComplainForm" onsubmit="complain_add()">
                                                <div class="row">
                                                    <!-- FUTURE : left content -->
                                                    <div class="col-md-6 col-sm-12 col-xs-12">
                                                        <div class="form-group">
                                                            <label class="control-label" for="nama">Nama</label>
                                                            <div id="nama_complain1">
                                                                -
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="control-label" for="id">ID Customer</label>
                                                            <input id="idCustomer_complain1" name="idCustomer_complain1" type="hidden" value="">
                                                            <input type="hidden" id="creator_complain1" name="creator_complain1" value="<?= $this->session->userdata('nama') ?>">
                                                            <input id="useridCustomer_complain1" name="idCustomer_complain1" type="hidden" value="">
                                                            <div id="v_idCustomer_complain1" class="">
                                                                -
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="control-label" for="cabang">Cabang</label>
                                                            <div>
                                                                <select id="cabang_complain1" name="cabang_complain1" class="form-control" required placeholder="Pilih Cabang ..." onchange="cabangDivisi()" required>
                                                                <option selected value="">Pilih cabang</option>
                                                                <?php foreach ( $cabang as $row ) : ?>
                                                                    <option value="<?= $row->id_cabang ?>"><?= $row->nama ?></option>
                                                            <?php endforeach; ?>
                                                            </select>
                                                                <script>
                                                                    $('#cabang_complain1').selectize({
                                                                        dropdownParent: 'body'
                                                                    })

                                                                </script>
                                                            </div>
                                                            <label class="control-label area" for="area">Area</label>
                                                            <div class="selectdiv area">
                                                                <select id="area_complain1" name="area_complain1" class="form-control" placeholder="Pilih Area ..." onchange="areaKapal()" required>
                                                                <option selected>Pilih Area ...</option>
                                                                <option value="Kapal">Kapal</option>
                                                                <option value="Pelabuhan">Pelabuhan</option>
                                                            </select>
                                                            </div>
                                                            <label class="control-label divisi sembunyi" for="divisi">Divisi</label>
                                                            <div class="selectdiv divisi sembunyi">
                                                                <select id="divisi_complain1" name="divisi_complain1" class="form-control" placeholder="Pilih Divisi ..." required>
                                                                <option value=0 selected>Pilih Divisi...</option>
                                                                <?php foreach ( $divisi as $row ) : ?>
                                                                    <option value="<?= $row->id_divisi ?>"><?= $row->nama ?></option>
                                                                <?php endforeach; ?>
                                                            </select>
                                                                <script>
                                                                    $('#divisi_complain1').selectize({
                                                                        dropdownParent: 'body'
                                                                    })

                                                                </script>
                                                            </div>

                                                        </div>
                                                        <div class="control-group nama_kapal_complain1 sembunyi">
                                                            <label class="control-label" for="nama_kapal">Nama Kapal</label>
                                                            <select id="nama_kapal_complain1" name="nama_kapal_complain1" class="form-control" placeholder="Pilih Kapal ...">
                                                            
                                                            </select>
                                                        </div>



                                                    </div>

                                                    <!-- FUTURE : right content -->
                                                    <div class="col-md-6 col-sm-12 col-xs-12">
                                                        <div class="control-group">
                                                            <label class="control-label" for="kategori_complain1">kategori</label>
                                                            <div class="selectdiv">
                                                                <select id="kategori_complain1" name="kategori_complain1" class="form-control" placeholder="Pilih Kategori..." required>
                                                                    <option value="" selected disabled>Pilih Kategori...</option>
                                                                    <option value="Tiket Online">Tiket Online</option>
                                                                    <option value="Petugas">Petugas</option>
                                                                    <option value="Fasilitas">Fasilitas</option>
                                                                    <option value="Kesetaraan">Kesetaraan</option>
                                                                    <option value="Kemudahan/Keterjangkauan">Kemudahan/Keterjangkauan</option>
                                                                    <option value="Kebersihan">Kebersihan</option>
                                                                    <option value="Kehandalan/Keteraturan">Kehandalan/Keteraturan</option>
                                                                    <option value="Keselamatan, Kesehatan dan Lingkungan">Keselamatan, Kesehatan dan Lingkungan</option>
                                                                    <option value="Kenyamanan">Kenyamanan</option>
                                                                    <option value="Keamanan">Keamanan</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class=" form-group">
                                                            <label for="isi_complain1" class="form-label">keluhan</label>
                                                            <textarea rows="6" class="form-control" id="isi_complain1" name="isi_complain1" placeholder="Isi Keluhan..." required></textarea>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="form-label">Prioritas</label>
                                                            <div class="selectdiv">
                                                                <select name="prioritas_complain1" id="prioritas_complain1" class="form-control" required>
                                                                <option disabled selected>Pilih prioritas...</option>
                                                                <option value=3>Normal (3 Hari)</option>
                                                                <option value=2>Penting (2 Hari)</option>
                                                                <option value=0.5>Sangat Penting (1 Hari)</option>
                                                            </select>
                                                            </div>

                                                        </div>
                                                        <div class="form-group">
                                                            <div class="col-md-3 col-sm-12 col-xs-12" style="float:right">
                                                                <input type="submit" class="btn btn-success form-control " value="Simpan">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- end of second content -->

                            <!-- NOTE : TAB 2 - Content 3-->
                            <div class="">
                                <div class="complain1 col-md-12 col-sm-12 col-xs-12">
                                    <div class="x_panel main-panel">
                                        <div class="x_title">
                                            <!-- NOTE : TAB 2 - Content 3 - Tabel Komplain Pelanggan -->
                                            <h2 class="kepala"><strong>TABEL KOMPLAIN PELANGGAN</strong></h2>
                                            <div class="clearfix"></div>
                                        </div>
                                        <div class="x_content">


                                            <table id="tabelComplain" class="table table-bordered table-striped" width="100%" cellspacing="0">
                                                <thead>
                                                    <tr>
                                                        <th>Tiket</th>
                                                        <th>Userid</th>
                                                        <th>Nama</th>
                                                        <th>Tanggal Komplain</th>
                                                        <th>Cabang</th>
                                                        <th>Kategori</th>
                                                        <th>urgency</th>
                                                        <th>Status</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                            </table>

                                            <script src="<?= base_url(); ?>assets/js/customjs/serverProcessing/v_main_tabel_complain.js"></script>
                                            <!-- tabel Complain Perjalanan -->

                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- end of third content -->

                            <!-- NOTE : TAB 2 - Content 4 -->
                            <div class="">
                                <div class="complain1 col-md-12 col-sm-12 col-xs-12">
                                    <div class="x_panel main-panel">
                                        <div class="x_title">
                                            <!-- NOTE : TAB 2 - Content 4 - Detail Komplain Pelanggan -->
                                            <h2 class="kepala"><strong>DETAIL KOMPLAIN PELANGGAN : <font id="userid_complain2">-</font> </strong></h2>
                                            <div class="clearfix"></div>
                                        </div>
                                        <div class="x_content " id="detailComplain">
                                            <div id="info_complain2" class="alert alert-info">
                                                Silahkan pilih data complain
                                            </div>
                                            <div class="detailComplain sembunyi">
                                                <div class="row">
                                                    <!-- left content -->
                                                    <div class="col-md-6 col-sm-12 col-xs-12">
                                                        <div class="form-group">
                                                            <label class="control-label col-md-2 col-sm-12 col-xs-12">Tiket</label>
                                                            <input type='text' id="tiket_complain2" readonly class="form-control " />
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="control-label col-md-2 col-sm-12 col-xs-12">Nama</label>
                                                            <input type='text' id="nama_complain2" readonly class="form-control " />
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="control-label col-md-2 col-sm-12 col-xs-12">Tanggal</label>
                                                            <input type='text' id="tgl_complain2" readonly class="form-control " />
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="control-label col-md-2 col-sm-12 col-xs-12">Cabang</label>
                                                            <input type='text' id="cabang_complain2" readonly class="form-control " />
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="control-label col-md-2 col-sm-12 col-xs-12">Area</label>
                                                            <input type='text' id="area_complain2" readonly class="form-control " />
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="control-label col-md-2 col-sm-12 col-xs-12">Kapal</label>
                                                            <input type='text' id="kapal_complain2" readonly class="form-control " />
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="control-label col-md-2 col-sm-12 col-xs-12">Kategori</label>
                                                            <input type='text' id="kategori_complain2" readonly class="form-control " />
                                                        </div>

                                                    </div>
                                                    <!-- left content -->

                                                    <!-- right content -->
                                                    <div class="col-md-6 col-sm-12 col-xs-12">
                                                        <div class="form-group">
                                                            <label class="control-label">Isi Komplain</label>
                                                            <textarea id="isi_complain2" class="form-control" disabled rows="5" cols=""></textarea>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="control-label">Lampiran : <font class="text_lampiran"></font></label>

                                                            <form method="GET" action="" class="link_lampiran" target="_blank">
                                                                <button class="btn btn-primary btn-sm">Download <i class="fa fa-download"></i></button>
                                                            </form>
                                                            <center>
                                                                <img src="" class="img_lampiran img-resposive img-thumbnail" style="max-width:100%;max-height:400px">
                                                            </center>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="control-label">Urgency</label>
                                                            <div class="progress">
                                                                <div id="progress_complain2" class="progress-bar progress-bar-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="100">
                                                                    test
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div id="info_keterangan" class="alert alert-danger sembunyi">
                                                            Belum ada tindakan oleh cabang!
                                                        </div>
                                                        <div class="keterangan2 form-group sembunyi">
                                                            <label class="control-label">Keterangan</label>
                                                            <textarea id="keterangan_complain2" class="form-control" disabled rows="5" cols=""></textarea>
                                                        </div>
                                                        <?php if($this->session->userdata('userlevel') == 0){ ?>
                                                        <div id="info_konfirm" class="alert alert-danger sembunyi">
                                                            Data Belum di Konfirmasi ke Pengguna Jasa!
                                                        </div>
                                                        <div id="info_konfirm2" class="alert alert-success sembunyi">
                                                            Data Sudah di Konfirmasi ke Pengguna Jasa Oleh CS:
                                                            <font class="cs_name" style="color:red"></font>, Berikut bukti konfirmasi:
                                                            <font class="text_bukti"></font>
                                                            <form method="GET" action="" class="link_bukti" target="_blank">
                                                                <button class="btn btn-primary btn-sm">Download <i class="fa fa-download"></i></button>
                                                            </form>
                                                            <audio id="audio_bukti" controls>
                                                                  <source class="audio_bukti" src="" type="audio/wav">
                                                                <source class="audio_bukti" src="" type="audio/mpeg">
                                                                <source class="audio_bukti" src="" type="audio/ogg">
                                                            </audio>
                                                        </div>
                                                        <div id="info_konfirm3">
                                                            <center>
                                                                <img src="" class="img_bukti img-resposive img-thumbnail" style="max-width:100%;max-height:400px">
                                                            </center>
                                                        </div>
                                                        <?php }?>
                                                        <?php if($this->session->userdata('userlevel') == 0){?>
                                                        <form method="POST" action="<?= base_url()?>dashboard/complain_arsip" onsubmit="return window.confirm('Anda yakin untuk close tiket?')">
                                                            <div class="keterangan form-group">
                                                                <input type="hidden" name="id_komplain_arsip" id="id_komplain_arsip" value="" class="form-control">
                                                                <input type="hidden" name="tiket_arsip" id="tiket_arsip" value="" class="form-control">
                                                                <input type="hidden" name="nama_arsip" id="nama_arsip" value="" class="form-control">
                                                                <input type="hidden" name="cabang_arsip" id="cabang_arsip" value="" class="form-control">
                                                                <input type="hidden" name="kapal_arsip" id="kapal_arsip" value="" class="form-control">
                                                                <input type="hidden" name="prioritas_arsip" id="prioritas_arsip" value="" class="form-control">
                                                                <input type="hidden" name="area_arsip" id="area_arsip" value="" class="form-control">
                                                                <input type="hidden" name="kategori_arsip" id="kategori_arsip" value="" class="form-control">
                                                                <input type="hidden" name="created_by_arsip" id="created_by_arsip" value="" class="form-control">
                                                                <input type="hidden" name="finished_by_arsip" id="finished_by_arsip" value="" class="form-control">
                                                                <input type="hidden" name="dif_arsip" id="dif_arsip" value="" class="form-control">
                                                                <input type="hidden" name="isi_arsip" id="isi_arsip" value="" class="form-control">
                                                                <input type="hidden" name="tindakan_arsip" id="tindakan_arsip" value="" class="form-control">
                                                                <input type="hidden" name="telp_arsip" id="telp_arsip" value="" class="form-control">
                                                                <input type="hidden" name="email_arsip" id="email_arsip" value="" class="form-control">
                                                                <input type="hidden" name="tgl_komplain_arsip" id="tgl_komplain_arsip" value="" class="form-control">
                                                                <input type="hidden" name="tgl_confirm_arsip" id="tgl_confirm_arsip" value="" class="form-control">
                                                                <input type="hidden" name="tgl_cabang_arsip" id="tgl_cabang_arsip" value="" class="form-control">
                                                                <input type=hidden name="status_arsip" class="form-control" value='Selesai' required>

                                                            </div>
                                                            <div class="keterangan form-group">
                                                                <div>
                                                                    <button type="submit" class="btn btn-success form-control">Close Ticket</button>
                                                                </div>
                                                            </div>
                                                        </form>
                                                        <?php } else if($this->session->userdata('userlevel') == 1) {?>

                                                        <form class="konfirm" id="form_konfirmasi" method="POST" action="<?= base_url()?>dashboard/confirm" enctype="multipart/form-data" onsubmit="return window.confirm('Apakah tindakan komplain telah disampaikan ke pengguna jasa?')" ;>
                                                            <label class="control-label">Bukti Konfirmasi (Dapat Berupa File Image <b><i>(.jpg,.jpeg,.png)</i></b> atau Audio <b><i>(.mp3,.wav,.aiff,.ogg)</i></b> </label>
                                                            <label class="control-label">Jika file lebih dari satu dapat dijadikan <b><i>.rar</i></b> atau <b><i>.zip</i></b> Maks. 5MB</label>
                                                            <div class="form-group">
                                                                <input type="file" id="userfile" name="userfile" class="form-control" required="true" style="margin-top:10px;margin-bottom:10px" accept=".jpg, .png, .jpeg, .rar,.zip,.mp3,.wav,.ogg,.aiff">
                                                                <input type="hidden" name="confirm_tiket" id="confirm_tiket" value="" class="form-control">
                                                                <input type="hidden" name="confirm" id="confirm" value="" class="form-control">
                                                                <button type="submit" class="btn btn-success form-control">Konfirmasi</button>
                                                            </div>
                                                        </form>
                                                        <div id="info_confirm" class="alert alert-success sembunyi">
                                                            Data komplain sudah dikonfirmasi
                                                        </div>

                                                        <?php }?>

                                                    </div>
                                                    <!-- right content -->
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- end of fourth content -->

                            <!-- start of fifth content -->
                            <!--<div class="">
                        <div class="complain1 col-md-12 col-sm-12 col-xs-12">
                            <div class="x_panel main-panel">
                                <div class="x_title">
                                    <h2 class="kepala col-md-12"><center><strong>GRAFIK KOMPLAIN <font id="chart_title">TAHUN <?= $this->m_complain_chart->complain_get_year()->tahun ?></font></strong></center></h2>
                                    <div class="clearfix"></div>
                                </div>
                                <div class="x_content " >

                                    <div class="form-group">
                                        <label class="form-label col-md-1" style="width: 4%;margin-top: 5px;">Tahun</label>
                                        <div class="selectdiv col-md-2">
                                            <select id="grafik_tahun" class="form-control" onchange="return grafik_tahun()">
                                                <?php foreach($tahun as $row) {?>
                                                    <option value="<?= $row->tahun ?>"><?= $row->tahun ?></option>
                                                <?php }?>
                                            </select>
                                        </div>
                                    </div>

                                    <div id="chart-container">
                                        <canvas id="mychart" width="100" height="30"></canvas>
                                        <script src="<?= base_url(); ?>assets/js/customjs/graph.js"></script>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>-->

                            <!-- NOTE : TAB 2 - Content 5 - Grafik Komplain-->
                            <div class="">
                                <div class="complain1 col-md-12 col-sm-12 col-xs-12">
                                    <div class="x_panel main-panel">
                                        <div class="x_title">
                                            <h2 class="kepala col-md-12">
                                                <center><strong>Grafik Komplain <font id="chart_title">Tahun <?php 
                                    if($this->m_complain_chart->complain_get_year()){
                                    echo $this->m_complain_chart->complain_get_year()->tahun;
                                    }else{
                                        echo date("Y");
                                    }?></font></strong></center>
                                            </h2>
                                            <div class="clearfix"></div>
                                        </div>
                                        <div class="x_content ">
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


                                                <!-- <div class="col-md-1" style="width: 1%;margin-top: -5px;">
                                            <input type="checkbox" class="form-control" id="grafik_detail">
                                        </div>
                                        <label class="form-label col-md-1" style="width: 6%;margin-top: 5px;">Detail</label> -->


                                            </div>
                                            <!--Cabang-->

                                            <div id="chart-container" style="padding-top: 55px;">
                                                <canvas id="mychart" width="100" height="30"></canvas>
                                                <script src="<?= base_url(); ?>assets/js/customjs/graph.js"></script>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- end of fifth content -->
                        </div>
                        <!-- END OF TAB2 -->




                        <!-- NOTE : TAB 3 -->
                        <div role="tabpanel" class="tab-pane" id="tab_content3" aria-labelledby="profile-tab">

                            <div class="">
                                <div class="col-md-12 col-sm-12 col-xs-12">
                                    <div class="x_panel main-panel">
                                        <div class="x_title">
                                            <!--  NOTE : TAB 3 - Content  1 - Tabel pelanggan-->
                                            <h2 class="kepala"><strong>TABEL DATABASE PELANGGAN</strong></h2>
                                            <div class="clearfix"></div>
                                        </div>
                                        <div class="x_content">

                                            <table id="tabelCustomer3" class="table table-striped table-bordered dt-responsive nowrap" width="100%" cellspacing="0">
                                                <thead>
                                                    <tr>
                                                        <th>ID Customer</th>
                                                        <th>Nama</th>
                                                        <th>No telp</th>
                                                        <th>Email</th>
                                                        <th>Frekuensi</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                            </table>

                                        </div>
                                    </div>
                                </div>
                            </div>


                            <div class="recent2" style="display:none">
                                <div class="col-md-12 col-sm-12 col-xs-12">
                                    <center>
                                        <div class="loader"></div>
                                    </center>
                                </div>
                            </div>

                            <div class="row recent sembunyi">
                                <!-- NOTE : TAB 3 - Content 2 - Detail Customer-->
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <div class="x_panel main-panel ">
                                        <div class="x_title">
                                            <h2 class="kepala"><strong>Detail Pelanggan</strong></h2>
                                            <div class="clearfix"></div>
                                        </div>

                                        <div class="x_content detail_recent">
                                            <p>
                                                <label class="form-label">Nama:</label>
                                                <font id="nama_d2"></font>
                                            </p>
                                            <p>
                                                <label class="form-label">ID Customer:</label>
                                                <font id="userid_d2"></font>
                                            </p>
                                            <p>
                                                <label class="form-label">Email:</label>
                                                <font id="email_d2"></font>
                                            </p>
                                            <p>
                                                <label class="form-label">Telp:</label>
                                                <font id="telp_d2"></font>
                                            </p>
                                            <p>
                                                <label class="form-label">Last Activity:</label>
                                                <font id="lastact_d2"></font>
                                            </p>
                                            <p>
                                                <label class="form-label">Jarak : <font id="poin_jarak" class="btn-primary btn-xs"></font></label>
                                                <label class="form-label" style="float:right">Level Berikutnya: <font id="jarak_max" class="btn-primary btn-xs"></font></label>
                                                <hr style="margin-top:-10px;margin-bottom:0px">
                                                <div class="progress">
                                                    <div class="progress-bar bar_jarak" role="progressbar" aria-valuenow="70" aria-valuemin="0" aria-valuemax="100" style="width:70%">
                                                        <span class="sr-only">70% Complete</span>
                                                    </div>
                                                </div>

                                            </p>
                                            <p>
                                                <label class="form-label">Frekuensi : <font id="poin_freq" class="btn-primary btn-xs"></font></label>
                                                <label class="form-label" style="float:right;border: 1,0,1,0 solid black">Level Berikutnya : <font id="freq_max" class="btn-primary btn-xs"></font></label>
                                                <hr style="margin-top:-10px;margin-bottom:0px">
                                                <div class="progress">
                                                    <div class="progress-bar progress-bar-success bar_freq" role="progressbar" aria-valuenow="70" aria-valuemin="0" aria-valuemax="100" style="width:70%">
                                                        <span class="sr-only">70% Complete</span>
                                                    </div>
                                                </div>
                                            </p>
                                            <p>
                                                <label class="form-label">Poin Perjalanan <font id="poin_poin" class="btn-primary btn-xs"></font></label>
                                                <label class="form-label" style="float:right">Level Berikutnya: <font id="poin_max" class="btn-primary btn-xs"></font></label>
                                                <hr style="margin-top:-10px;margin-bottom:0px">
                                                <div class="progress">
                                                    <div class="progress-bar progress-bar-warning bar_poin" role="progressbar" aria-valuenow="70" aria-valuemin="0" aria-valuemax="100" style="width:70%">
                                                        <span class="sr-only">70% Complete</span>
                                                    </div>
                                                </div>
                                            </p>
                                        </div>
                                    </div>
                                </div>

                                <!-- NOTE : TAB 3 - Content 2 - Detail Customer 2 -->
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <div class="x_panel main-panel ">

                                        <div class="x_content">
                                            <div class="x_title">
                                                <h4 class="kepala">Riwayat Perjalanan</h4>
                                                <div class="clearfix"></div>
                                            </div>
                                            <p><b><font id="count_perjalanan" style="font-size:35px"></font></b></p>
                                            <p>Perjalanan</p>
                                            
                                            <div class="x_title">
                                                <h4 class="kepala">Interaksi dengan Customer Care</h4>
                                                <div class="clearfix"></div>
                                            </div>
                                            <p><b><font id="count_customer" style="font-size:35px"></font></b></p>
                                            <p>Interaksi</p>
                                            
                                            <div class="x_title">
                                                <h4 class="kepala">TOP 3 Lintasan</h4>
                                                <div class="clearfix"></div>
                                            </div>
                                            <label style="display:block" class="top_lintasan1"><font id="top_lintasan1"></font><font style="float:right" id="top_right1"></font></label>
                                            <label style="display:block" class="top_lintasan2"><font id="top_lintasan2"></font><font style="float:right" id="top_right2"></font></label>
                                            <label style="display:block" class="top_lintasan3"><font id="top_lintasan3"></font><font style="float:right" id="top_right3"></font></label>

                                        </div>
                                    </div>
                                </div>

                                <!-- NOTE : TAB 3 - Content 3 - recent Activity -->
                                <div class="col-md-12 col-sm-12 col-xs-12">

                                    <div class="x_panel main-panel ">
                                        <div class="x_title">
                                            <h2 class="kepala"><strong>RECENT ACTIVITY</strong></h2>
                                            <div class="clearfix"></div>
                                        </div>
                                        <div class="x_content">

                                            <table id="tabelRecent" class="table table-bordered table-striped">
                                                <thead>
                                                    <tr>
                                                        <th>Tanggal</th>
                                                        <th>layanan</th>
                                                        <th>Lintasan</th>
                                                        <!--                                                        <th>Kapal</th>-->
                                                        <th>Jarak</th>
                                                        <th>Poin</th>
                                                    </tr>
                                                </thead>
                                            </table>

                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <!-- END OF TAB3 -->
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

<script src="<?= base_url(); ?>assets/js/customjs/v_main_1.js"></script>
<script src="<?= base_url(); ?>assets/js/customjs/v_main_2.js"></script>
<script src="<?= base_url(); ?>assets/js/customjs/v_main_3.js"></script>
<script src="<?= base_url(); ?>assets/js/customjs/serverProcessing/v_main_tabel_customer.js"></script>
<script src="<?= base_url(); ?>assets/js/customjs/serverProcessing/v_main_tabel_customer2.js"></script>
<script src="<?= base_url(); ?>assets/js/customjs/serverProcessing/v_main_tabel_customer3.js"></script>


<!-- tabel Complain Perjalanan -->
