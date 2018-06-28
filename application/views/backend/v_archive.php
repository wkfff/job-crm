<div class="page-title">
    <div class="title_left">
        <h3 class="kepala">Arsip data complain<small>- Customer Relation Management</small></h3>
    </div>
</div>

<div class="clearfix"></div>

<div class="row">

    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_content">
                <label><h5>Filter:</h5></label>
                <div>
                    <label class="form-label col-md-1" style="width: 5%;margin-top: 5px;">Cabang</label>
                    <div class="selectdiv col-md-2">
                        <select id="optCabang" class="form-control" onchange="return filter()">
                            <option value="semua">Semua Cabang</option>
                            <?php foreach($cabang as $row) {?>
                                <option value="<?= $row->nama ?>"><?= $row->nama ?></option>
                            <?php }?>
                        </select>
                    </div>
                    <label class="form-label col-md-1" style="width: 5%;margin-top: 5px;">Area</label>
                    <div class="selectdiv col-md-2">
                        <select id="optArea" class="form-control" onchange="return filter()">
                            <option value="semua">Semua Area</option>
                            <option value="Kapal">Kapal</option>
                            <option value="Pelabuhan">Pelabuhan</option>
                        </select>
                    </div>
                    <label class="form-label col-md-1" style="width: 5%;margin-top: 5px;">Kategori</label>
                    <div class="selectdiv col-md-2">
                        <select id="optKategori" class="form-control" onchange="return filter()">
                            <option value="semua">Semua kategori</option>
                            <?php foreach($kategori as $row) {?>
                                <option value="<?= $row->kategori ?>"><?= $row->kategori ?></option>
                            <?php }?>
                        </select>
                    </div>
                    
                    <div class="col-md-1">
                        <button class="form-control btn btn-info" onclick="return kembali()">Reset</button>
                    </div>
                     
                </div>

            </div>
        </div>
    </div>

    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_content">
                <table id="tabelArsip" class="table table-striped table-bordered dt-responsive nowrap" width="100%" cellspacing="0">
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

<script src="<?= base_url(); ?>assets/js/customjs/serverProcessing/v_tabel_arsip.js"></script>

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

        $('html, body').animate({
            scrollTop: $("#detail_archive").offset().top 
        }, 500);

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
    
    function filter(){
        var optCabang = $('#optCabang').val();
        var optKategori = $('#optKategori').val();
        var optArea = $('#optArea').val();
        
        $('#tabelArsip').dataTable().fnDestroy();
        tabelArsip(optCabang,optArea,optKategori);
        
        
    }
    
    function kembali(){
        document.getElementById("optCabang").selectedIndex = '0';
        document.getElementById("optArea").selectedIndex = '0';
        document.getElementById("optKategori").selectedIndex = '0';
        
        $('#tabelArsip').dataTable().fnDestroy();
        tabelArsip('semua','semua','semua');
    }

</script>
