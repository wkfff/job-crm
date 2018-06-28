<?php

    $file = 'E:/Server/asdp-crm/application/output.txt';
    
    $data = date('d/m/y H:i:s')."\n";
    

$edit_file = fopen($file, 'a');
	
 fwrite($edit_file, $data);
 fclose($edit_file);