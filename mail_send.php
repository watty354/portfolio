<?php 
use PHPMailer\PHPMailer\PHPMailer;

if(isset($_POST['email'])) {
$email = $_POST['email'];


require_once "PHPMailer/PHPMailer.php";
require_once "PHPMailer/SMTP.php";
require_once "PHPMailer/Exception.php";

$mail= new PHPMailer();

// STMP設定
$mail->isSMTP();
$mail->Host="smtp.gmail.com";
$mail ->SMTPAuth=true;
$mail->Username = "wadamibass@gmail.com";
$mail->Password = 'Wadawada1';
$mail->Port=465;
$mail->SMTPSecure="ssl";

// emailsetting 
$mail->isHTML(true);
$mail->setFrom($email,);
$email->addAddress('wadamibass@gmail.com');
$mail->Body=$body;

if($mail->send()) {
$status = "succes";
$response= "Email is sent";
} else {
  $status = "failed";
  $response="error";
}
exit(json_encode(array("status"=>$status, "response"=>$response)));
}

?>