<?php 			
	$mail->IsSMTP(); 
	
	$mail->Host     = "mail.indonesiaferry.co.id"; 
	$mail->SMTPAuth = false;     
	$mail->Username = "pelanggan@indonesiaferry.co.id";  
	 $mail->Password = "123556"; 
	//$mail->Password = "123456";
	$mail->Username = "fiumewangi@gmail.com";  
	 $mail->Password = "fiumewangi!@#$%^&*()";
	
	$mail->IsHTML(true);
	$mail->From       = "noreply@indonesiaferry.co.id";
	// $mail->AddEmbeddedImage('asdp.png','img', 'asdp.png');
	// $mail->Sender = 'pelanggan@indonesiaferry.co.id';
	$mail->FromName   = "Customer Relationship Management PT.ASDP Indonesia Ferry";
       
	
	
?>