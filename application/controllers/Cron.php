<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;  

defined('BASEPATH') OR exit('No direct script access allowed');

class Cron extends CI_Controller {
    
    function __construct()
    {
        parent::__construct();
    }
    
   function sendemail($email = array('fzellyan@gmail.com'),$tiket = 'tes')
    {
//         require_once("mail/class.phpmailer.php");
        
        

        require_once("mail/PHPMailer.php");
        require_once("mail/Exception.php");
        require_once("mail/SMTP.php");

        $mail = new PHPMailer(true);
        
        try{
            
            $mail->isSMTP();
//            $mail->SMTPDebug = 4; 
//            $mail->Host = "mail.indonesiaferry.co.id";
//            $mail->Host = "10.1.107.124";
            $mail->Host = "10.1.107.125";
//            $mail->SMTPAuth = false;
            $mail->Username = "devmail@indonesiaferry.co.id";
            $mail->Password = "P@ssw0rd-123"; 
            $mail->Port = 25;
            $mail->SMTPAuth   = true;                  // enable SMTP authentication
            $mail->SMTPSecure = "tls";
            $mail->SMTPOptions = array(
    'ssl' => array(
        'verify_peer' => false,
        'verify_peer_name' => false,
        'allow_self_signed' => true
    )
);
//            $mail->SMTPAutoTLS = false;
//            $mail->attach('./assets/img/logo-asdp-dashboard.png'); 
            $mail->AddEmbeddedImage('./assets/img/logo-asdp-dashboard.png', 'logo');
            $mail->IsHTML(true);
            $mail->From       = "noreply@indonesiaferry.co.id";
            $mail->FromName   = "Customer Relationship Management PT.ASDP Indonesia Ferry";
        $html_message ="<body style='margin: 20px;'>"
                        ."<div style='backgound-color:#348ecd'><img src='cid:logo'><center><h1>Customer Relationship Management</h1></center></div>"
                        
                        ."<p>Dear, user cabang</p>"
                        ."<p>Cabang anda mendapat keluhan dengan no tiket : <strong>".$tiket."</strong>, silahkan membuka aplikasi crm indonesia ferry.</p>"
                        ."<p>Terima kasih</p>"
                        ."<p><strong>PT. ASDP Indonesia Ferry</strong></p>"
                        ."</body>";
//        require_once('mail/mailsettings.php');
            
            $mail->Subject    = "Customer Relationship Management PT.ASDP Indonesia Ferry";
            
            $mail->MsgHTML($html_message);
            
            $len = sizeof($email);

            for($i=0;$i<$len;$i++){

                $mail->AddAddress($email[$i]);

            }
            
            $mail->send();
            // $mail->AddCC($email);
            // $mail->AddReplyTo($email);
            // $mail->AddAddress($email);
//            $data = array('res'=>TRUE);
            $data = $mail->send();
            $this->output->set_content_type('application/json');
            return json_encode($data);
        } catch (Exception $e) {
            $this->output->set_content_type('application/json');
            return json_encode( $mail->ErrorInfo); 
        }
            
            // return $mail->send();
                
    }
}