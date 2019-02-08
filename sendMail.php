<?php
	use PHPMailer\PHPMailer\PHPMailer;
	use PHPMailer\PHPMailer\Exception;

	//Load Composer's autoloader
	require 'vendor/autoload.php';
	
	$subject = $_POST['subject'];
	$message = $_POST['message'];
	
	$mailInfo = parse_ini_file($_SERVER['DOCUMENT_ROOT']."/../mainInfo.ini", true);
	$username = $mailInfo['email']['username'];
	$pass = $mailInfo['email']['pass'];

	$mail = new PHPMailer(true);                              // Passing `true` enables exceptions
	try {
		//Server settings
		$mail->SMTPDebug = 2;                                 // Enable verbose debug output
		$mail->isSMTP();                                      // Set mailer to use SMTP
		$mail->Host = 'smtp.gmail.com';					  	  // Specify main and backup SMTP servers
		$mail->SMTPAuth = true;                               // Enable SMTP authentication
		$mail->Username = $username;                 		  // SMTP username
		$mail->Password = $pass;                           	  // SMTP password
		$mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
		$mail->Port = 587;                                    // TCP port to connect to

		//Recipients
		$mail->setFrom($username, 'Website\'s contact');
		$mail->addAddress($username);     					  // Add a recipient

		//Content
		$mail->isHTML(false);                                 // Set email format to HTML
		$mail->Subject = $subject;
		$mail->Body    = $message;

		$mail->send();
		echo 'Message has been sent';
	} catch (Exception $e) {
		echo 'Message could not be sent. Mailer Error: ', $mail->ErrorInfo;
	}
?>