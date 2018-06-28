<?php
 
//  header("Content-type: application/vnd-ms-excel");
 
header("Content-type: application/octet-stream");
//  header("Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet; charset=utf-8");
 $title = "dataCustomer".date('d').date('m').date('Y').".xls";
 header("Content-Disposition: attachment; filename=".$title." ");
 
 header("Pragma: no-cache");
 
 header("Expires: 0");
 
 ?>
 
 <table border="1" width="100%">
 
      <thead>
 
           <tr>
 
                <th>UserID</th>
                <th>NIK</th>
                <th>Nama</th>
                <th>Tempat Lahir</th>
                <th>Tanggal Lahir</th>
                <th>Jenis Kelamin</th>
                <th>Alamat</th>
                <th>Kewarganegaraan</th>
                <th>No Telp</th>
                <th>Email</th>
                <th>Pekerjaan</th>
                <th>Nama Perusahaan</th>
                <th>Sosmed</th>
                <th>Nama Sosmed</th>
 
           </tr>
 
      </thead>
 
      <tbody>
 
           <?php $i=1; foreach($customer as $row) { ?>
 
           <tr>
                <th><?= "'".$row->userid; ?></th>
                <td><?= "'".$row->nik; ?></td>
                <td><?= $row->nama; ?></td>
                <td><?= $row->tempat_lahir; ?></td>

                <?php
                    $res = explode('-',$row->tgl_lahir);
                    $tgl = $res[2].'-'.$res[1].'-'.$res['0'];
                ?>

                <td><?= $tgl; ?></td>
                <td><?= $row->gender; ?></td>
                <td><?= $row->alamat; ?></td>
                <td><?= $row->warga; ?></td>
                <td><?= $row->telp; ?></td>
                <td><?= $row->email; ?></td>
                <td><?= $row->job; ?></td>
                <td><?= $row->perusahaan; ?></td>
                <td><?= $row->sosmed; ?></td>
                <td><?= $row->nama_sosmed; ?></td>

           </tr>
 
           <?php $i++; } ?>
 
      </tbody>
 
 </table>
