<?php
//NOTE : fungsi cek level
    function cekLevel($val){
        $res = ""; 
        switch ($val) {
            case '0':
                $res = "Super Admin";
                break;
            case '1':
                $res = "Customer Service";
                break;
            case '2':
                $res = "Vice President";
                break;
            case '3':
                $res = "Cabang";
                break;
            case '4':
                $res = "BOD";
                break;
            case '5':
                $res = "Pusat";
                break;
            default:
                # code...
                break;
        }
        return $res;
    }


?>

<div class="page-title">
    <div class="title_left">
        <h3 class="kepala">Administrasi User<small> - Customer Relationship Management</small></h3>
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

                <div class="">
                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <div class="x_panel main-panel">
                            <div class="x_title">
                                <!--                                   NOTE : Tambah User-->
                                <h2 class="kepala">Tambah User <i class="fa fa-plus-circle"></i></h2>
                                <div class="clearfix"></div>
                            </div>
                            <div class="x_content">
                                <form class="form-horizontal" method="POST" action="<?= base_url()?>dashboard/user_input">
                                   <div class="form-group">
                                       <label class="checkbox-inline"><input type="checkbox" value="">Menggunakan email corporate PT. ASDP Indonesia Ferry (Persero)</label>
                                   </div>
                                    <div class="form-group">
                                        <label class="control-label col-md-1 col-sm-12 col-xs-12" for="username">Nama</label>
                                        <div class="col-md-11 col-sm-12 col-xs-12">
                                            <input class="form-control " type="text" name="name" id="name" required minlength="4" placeholder="Nama pengguna...">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label col-md-1 col-sm-12 col-xs-12" for="username">Username</label>
                                        <div class="col-md-5 col-sm-12 col-xs-12">
                                            <input class="form-control " type="email" name="username" id="username" required minlength="4" placeholder="Username gunakan alamat email">
                                        </div>
                                        <label class="control-label col-md-1 col-sm-12 col-xs-12" for="username">Password</label>
                                        <div class="col-md-5 col-sm-12 col-xs-12">
                                            <input class="form-control " type="password" name="password" id="password" required minlength="4" placeholder="Password...">
                                        </div>

                                    </div>
                                    <div class="form-group">
                                        <label class="control-label col-md-1 col-sm-12 col-xs-12" for="username">Level</label>
                                        <div class="selectdiv col-md-3 col-sm-12 col-xs-12">
                                            <select id="level" class="form-control" name="level" required>
                                                <option value="" disabled selected>Pilih Level ...</option>
                                                <option value="0">Super Admin</option>
                                                <option value="2">VP</option>
                                                <option value="4">BOD</option>
                                                <option value="1">Customer Service</option>
                                                <option value="3">Cabang</option>
                                            </select>
                                        </div>

                                        <label class="control-label col-md-1 col-sm-12 col-xs-12 sembunyi  cabang" for="username">Cabang</label>
                                        <div class="selectdiv col-md-3 col-sm-12 col-xs-12 sembunyi  cabang">
                                            <select id="cabang" name="cabang" class="form-control" placeholder="Pilih Cabang..">
                                                <option value="0" disabled selected>Pilih Cabang...</option>
                                                <?php  foreach ($cabang as $row) : ?>
                                                <option value="<?= $row->id_cabang?>">
                                                    <?= $row->nama ?>
                                                </option>
                                                <?php endforeach;?>
                                            </select>
                                        </div>

                                        <label class="control-label col-md-1 col-sm-12 col-xs-12 sembunyi pusat" for="username">Divisi</label>
                                        <div class="selectdiv col-md-3 col-sm-12 col-xs-12 sembunyi pusat">
                                            <select id="divisi" name="divisi" class="form-control" placeholder="Pilih Divisi...">
                                                <option value="0" disabled selected>Pilih Divisi...</option>
                                                <?php  foreach ($divisi as $row) : ?>
                                                <option value="<?= $row->id_divisi?>">
                                                    <?= $row->nama ?>
                                                </option>
                                                <?php endforeach;?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-md-2 col-sm-12 col-xs-12" style="float:right">
                                            <input type="submit" class="form-control btn btn-success" name="submit" value="Tambah">
                                        </div>
                                    </div>

                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="">
                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <div class="x_panel main-panel">
                            <div class="x_title">
                                <!--                                   NOTE: Tabel Data User-->
                                <h2 class="kepala">Tabel Data User
                                </h2>
                                <div class="clearfix"></div>
                            </div>
                            <div class="x_content">
                                <button type="submit" class="btn btn-danger disabled" style="margin-bottom: 20px" id="del_button"><i class="fa fa-trash-o"> Delete Selected</i></button>

                                <table id="tb_user" class="table table-striped table-bordered ">
                                    <thead>
                                        <tr>
                                            <th><input name="select_all" value="1" type="checkbox"></th>
                                            <th>No</th>
                                            <th>Nama</th>
                                            <th>username</th>
                                            <th>level</th>
                                            <th>cabang</th>
                                            <th>log</th>
                                            <th>Action</th>

                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $i = 1; foreach ($user as $row) : ?>
                                        <tr class="del_<?= $row->id_user ;?>">
                                            <td>
                                                <?= $row->id_user ?>
                                            </td>
                                            <td>
                                                <?= $i; ?>
                                            </td>
                                            <td>
                                                <?= $row->nama; ?>
                                            </td>
                                            <td>
                                                <?= $row->nameuser; ?>
                                            </td>
                                            <td>
                                                <?= cekLevel($row->level); ?>
                                            </td>
                                            <?php $cabang = $row->cabang;
                                                if(is_null($row->cabang)){
                                                    $cabang = "-";
                                                }else if($row->cabang == 'Pusat'){
                                                    $cabang = $row->cabang.' - '.$row->nama_divisi;
                                                }?>
                                            <td>
                                                <?= $cabang; ?>
                                            </td>
                                            <td>
                                                <?= $row->log; ?>
                                            </td>
                                            <td><button onclick="delUser(<?= $row->id_user ?>)" title="Delete" class="btn btn-danger form-control"><i class="fa fa-trash"></i></button></td>
                                        </tr>
                                        <?php $i++; endforeach;?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>



<script type="text/javascript">
    function updateDataTableSelectAllCtrl(table) {
        var $table = table.table().node();
        var $chkbox_all = $('tbody input[type="checkbox"]', $table);
        var $chkbox_checked = $('tbody input[type="checkbox"]:checked', $table);
        var chkbox_select_all = $('thead input[name="select_all"]', $table).get(0);
        var del_button = $('#del_button');

        // If none of the checkboxes are checked
        if ($chkbox_checked.length === 0) {
            chkbox_select_all.checked = false;
            if ('indeterminate' in chkbox_select_all) {
                chkbox_select_all.indeterminate = false;
                del_button.addClass('disabled');
            }

            // If all of the checkboxes are checked
        } else if ($chkbox_checked.length === $chkbox_all.length) {
            chkbox_select_all.checked = true;
            if ('indeterminate' in chkbox_select_all) {
                chkbox_select_all.indeterminate = false;
                del_button.removeClass('disabled');
            }

            // If some of the checkboxes are checked
        } else {
            chkbox_select_all.checked = true;
            if ('indeterminate' in chkbox_select_all) {
                chkbox_select_all.indeterminate = true;
                del_button.removeClass('disabled');
            }
        }
    }

    $(document).ready(function() {

        var rows_selected = [];
        var table = $('#tb_user').DataTable({

            'columnDefs': [{
                'targets': 0,
                'searchable': false,
                'orderable': false,
                'className': 'dt-body-center',
                'render': function(data, type, full, meta) {
                    return '<input type="checkbox">';
                }
            }],
            'order': [1, 'asc'],
            'rowCallback': function(row, data, dataIndex) {
                // Get row ID
                var rowId = data[0];

                // If row ID is in the list of selected row IDs
                if ($.inArray(rowId, rows_selected) !== -1) {
                    $(row).find('input[type="checkbox"]').prop('checked', true);
                    $(row).addClass('selected');
                }
            }
        });

        // Handle click on checkbox
        $('#tb_user tbody').on('click', 'input[type="checkbox"]', function(e) {
            var $row = $(this).closest('tr');

            // Get row data
            var data = table.row($row).data();

            // Get row ID
            var rowId = data[0];

            // Determine whether row ID is in the list of selected row IDs
            var index = $.inArray(rowId, rows_selected);

            // If checkbox is checked and row ID is not in list of selected row IDs
            if (this.checked && index === -1) {
                rows_selected.push(rowId);

                // Otherwise, if checkbox is not checked and row ID is in list of selected row IDs
            } else if (!this.checked && index !== -1) {
                rows_selected.splice(index, 1);
            }

            if (this.checked) {
                $row.addClass('selected');
            } else {
                $row.removeClass('selected');
            }

            // Update state of "Select all" control
            updateDataTableSelectAllCtrl(table);

            // Prevent click event from propagating to parent
            e.stopPropagation();
        });

        // Handle click on table cells with checkboxes
        // $('#tb_user').on('click', 'tbody td, thead th:first-child', function (e) {
        //     $(this).parent().find('input[type="checkbox"]').trigger('click');
        // });

        // Handle click on "Select all" control
        $('thead input[name="select_all"]', table.table().container()).on('click', function(e) {
            if (this.checked) {
                $('tbody input[type="checkbox"]:not(:checked)', table.table().container()).trigger('click');
            } else {
                $('tbody input[type="checkbox"]:checked', table.table().container()).trigger('click');
            }

            // Prevent click event from propagating to parent
            e.stopPropagation();
        });



        // Handle table draw event
        table.on('draw', function() {
            // Update state of "Select all" control
            updateDataTableSelectAllCtrl(table);
        });

        // Handle form submission event
        $('#del_button').on('click', function(e) {

            var check = confirm("Apakah anda yakin menghapus data tersebut?");

            if (check === true) {

                // Iterate over all selected checkboxes
                $.each(rows_selected, function(index, rowId) {
                    // Create a hidden element
                    var chkbox_select_all = $('thead input[name="select_all"]', $('#tb_user')).get(0);
                    var del_button = $('#del_button');

                    var id = rowId;
                    $.ajax({
                        type: 'POST',
                        url: '<?=base_url()?>dashboard/user_del/' + id,
                        data: 'id=' + id,
                        success: function(html) {
                            $(".del_" + id).fadeOut('slow');
                            chkbox_select_all.checked = false;
                            chkbox_select_all.indeterminate = false;
                            del_button.addClass('disabled');

                        }
                    });
                });
                notifSukses('<strong>Sukses!</strong> Data User berhasil dihapus!');
            } else {
                return false;
            }


            // FOR DEMONSTRATION ONLY


            // Prevent actual form submission
            e.preventDefault();

        });

        //NOTE : Level Cabang ganti
        $('#level').change(function() {

            var val = $('#level').val();
            var element = $('.cabang');

            if (val == 3) {
                element.fadeIn();
                $('#cabang').selectize({
                    dropdownParent: 'body'
                });

            } else {
                element.fadeOut('fast');
                $('#cabang').val("0");
            }
        });

        //NOTE : Divisi
        $('#cabang').change(function() {
            var val = $('#cabang').val();
            var element = $('.pusat');

            if (val == 110) {
                element.fadeIn();
                $('#divisi').selectize({
                    dropdownParent: 'body'
                });
            } else {
                element.fadeOut('fast');
                $('#divisi').val("0");

            }
        });
    });

</script>
