<div class="page-title">
    <div class="title_left">
    <h3>Hasil Pencarian<small> - Customer Relationship Management</small></h3>
    </div>
</div>

<div class="clearfix"></div>

<div class="row"  >
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel" >
            <div class="x_content">

            <p>Berikut hasil pencarian untuk kata kunci : <strong><?= $_GET['search-bar'] ?></strong></p>

            <div class="">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="x_panel main-panel">
                        <div class="x_title">
                            <h2 class="kepala"><strong>DATA CUSTOMER</strong></h2>
                            <div class="clearfix"></div>
                        </div>
                        <div class="x_content">
                            <?php if(!empty($customer)) { ?>
                        <table id="myTabel" class="table table-striped table-bordered dt-responsive nowrap" width="100%" cellspacing="0" >
                                        <thead>
                                            <tr>
                                                <th>ID Customer</th> 
                                                <th>NIK</th>
                                                <th>Nama</th>
                                                <!-- <th>Umur</th> -->
                                                <th>Gender</th>
                                                <!-- <th>Alamat</th> -->
                                                <th>Telp</th>
                                                <th>Email</th>
                                                <th>TTL</th>
                                                <th>Pekerjaan</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($customer as $row) : ?>
                                                <tr>
                                                    <td><?= $row->userid ?></td>
                                                    <?php
                                                    $nik = '-';
                                                    if($row->nik){
                                                        $nik = $row->nik;
                                                    }
                                                    ?>
                                                    <td><?= $nik ?></td>
                                                    <td><?= $row->nama ?></td>
                                                    <!-- Menentukan umur -->
                                                    <?php 
                                                        $biday = new DateTime($row->tgl_lahir);
                                                        $today = new DateTime('today');
                                                        $umur = $today->diff($biday);
                                                    ?>
                                                    <!-- <td><?= $umur->y ?></td> -->
                                                    <td><?= $row->gender ?></td>
                                                    <!-- <td><?= $row->alamat ?></td> -->
                                                    <td><?= $row->telp ?></td>
                                                    <td><?= $row->email ?></td>
                                                    <td><?= $row->tgl_lahir ?></td>
                                                    <td><?= $row->job ?></td>
                                                    <!-- <td>
                                                    <a  class="btn btn-success fa fa-plus-circle" href="<?=base_url()?>dashboard#tab_content2-<?= $row->id ?>-<?= $row->nama ?>-<?= $row->userid ?>" title="userid = <?= $row->userid ?>, Klik untuk melihat complain">
                                                        Complain
                                                    </a>
                                                    </td> -->
                                                    <td>
                                                    <a  class="btn btn-info " href="<?=base_url()?>dashboard#tab_content1-detailUser-<?= $row->id ?>" title="detail" style="padding:5px 5px;"><i class="fa fa-search"></i>
                                                        
                                                    </a>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                        <tbody>
                                    </table>
                            <?php  } else {?>
                                <p><strong>Maaf!</strong> untuk kata kunci <strong><?= $_GET['search-bar'] ?></strong> tidak ditemukan di data customer</p>
                                <a  class="btn btn-success " href="<?=base_url()?>dashboard#tab_content1-add" title="Tambah Cusromer" style="padding:5px 5px;"><i class="fa fa-plus-circle"></i>
                                    Tambah Customer
                                </a>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>

            <div class="">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="x_panel main-panel">
                        <div class="x_title">
                            <h2 class="kepala"><strong>COMPLAIN</strong></h2>
                            <div class="clearfix"></div>
                        </div>
                        <div class="x_content">
                            <?php if(!empty($complain)) { ?>
                        <table id="myTabel" class="table table-striped table-bordered dt-responsive" width="100%" cellspacing="0" >
                                        <thead>
                                            <tr>
                                                <th>Tiket</th>
                                                <th>Nama</th>
                                                <th>Umur</th>
                                                <th>Tanggal</th>
                                                <th>Cabang</th>
                                                <th>Area</th>
                                                <th>Kapal</th>
                                                <th>Kategori</th>
                                                <th>Komplain</th>
                                                <th>Urgency</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($complain as $row) : ?>
                                                <tr>
                                                    <td><?= $row->tiket ?></td>
                                                    <td><?= $row->nama ?></td>

                                                    <!-- Menentukan umur -->
                                                    <?php 
                                                        $biday = new DateTime($row->tgl_komplain);
                                                        $today = new DateTime('today');
                                                        $umur = $today->diff($biday);

                                                        $tahun = substr($row->tgl_komplain,0,4);
                                                        $bulan = substr($row->tgl_komplain,5,2);
                                                        $hari = substr($row->tgl_komplain,8,2);

                                                        $kapal = "-";
                                                        if($row->kapal){
                                                            $kapal = $row->kapal;
                                                        }

                                                        //difference
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
                                                        //difference
                                                    ?>
                                                     <td><?= $umur->y ?></td>
                                                    <td><?= $hari.'-'.$bulan.'-'.$tahun ?></td>
                                                    <td><?= $row->cabang ?></td>
                                                    <td><?= $row->area ?></td>
                                                    <td><?= $kapal ?></td>
                                                    <td><?= $row->kategori ?></td>
                                                    <td><?= $row->isi_komplain ?></td>
                                                    <td><div class="progress">
                                                            <div class="progress-bar <?= $bar ?>" role="progressbar" 
                                                                aria-valuemin="0" aria-valuemax="100" style="width:<?= $batas ?>%">
                                                                <?= $str ?>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                    <a  class="btn btn-info " href="<?=base_url()?>dashboard#tab_content2-detail-<?= $row->id_komplain ?>" title="userid = <?= $row->userid ?>, Klik untuk melihat complain" style="padding: 5px 5px;"><i class="fa fa-search"></i>
                                                        Detail
                                                    </a>
                                                </td>
                                                </tr>
                                            <?php endforeach; ?>
                                        <tbody>
                                    </table>
                            <?php  } else {?>
                                <p><strong>Maaf!</strong> untuk kata kunci <strong><?= $_GET['search-bar'] ?></strong> tidak ditemukan di data complain</p>
                            <?php } ?>
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
    } );
</script>