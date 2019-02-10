<?php	
	$mailInfo = parse_ini_file($_SERVER['DOCUMENT_ROOT']."/../mainInfo.ini", true);
	$username = $mailInfo['gartDB']['username'];
	$pass = $mailInfo['gartDB']['pass'];
	$dbname = $mailInfo['gartDB']['dbname'];
	
	$servername = $mailInfo['gartDB']['severname'];

	// Create connection
	$conn = new mysqli($servername, $username, $pass, $dbname);

	// Check connection
	if ($conn->connect_error) {
		die("Connection failed: " . $conn->connect_error);
	}
	
	$conn->set_charset("utf8");

	// prepare and bind
	$stmt = $conn->prepare("INSERT INTO contact_services (name, email, message) VALUES (?, ?, ?)");
	$stmt->bind_param("sss", $name, $email, $message);

	// set parameters and execute
	$email = $_POST['email'];
	$name = $_POST['name'];
	$message = $_POST['message'];
	$stmt->execute();

	echo "New records created successfully";

	$stmt->close();
	$conn->close();
?>