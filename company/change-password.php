<?php

//To Handle Session Variables on This Page
session_start();

if (empty($_SESSION['id_company'])) {
	header("Location: ../index.php");
	exit();
}

//Including Database Connection From db.php file to avoid rewriting in all files
require_once("../db.php");

//If user Actually clicked login button 
if (isset($_POST)) {

	//Escape Special Characters in String
	$password = mysqli_real_escape_string($conn, $_POST['password']);

	//Encrypt Password
	$password = base64_encode(strrev(md5($password)));

	//sql query to check user login
	$sql = "UPDATE company SET password='$password' WHERE id_company='$_SESSION[id_company]'";
	if ($conn->query($sql) === true) {
		// get user email
		$sql = "SELECT email FROM company WHERE id_company='$_SESSION[id_company]'";
		$result = $conn->query($sql);
		$row = $result->fetch_assoc();
		// Send Email			
		//
		// *** To Email ***
		$to = $row['email'];
		//
		// *** Subject Email ***
		$subject = "Alert ! Account Password Changed | SIOM Placement Assistant";
		//
		// *** Content Email ***
		$html_template = file_get_contents('../email_templates/password_change_company.html');
		//
		//*** Head Email ***
		$headers = "From: mail.siomplacementassistant@gmail.com\r\n";
		$headers .= "MIME-Version: 1.0" . "\r\n";
		$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
		//you add more headers like Cc, Bcc;

		$res = mail($to, $subject, $html_template, $headers); // \r\n will return new line. 





		header("Location: index.php");
		exit();
	} else {
		echo $conn->error;
	}

	//Close database connection. Not compulsory but good practice.
	$conn->close();
} else {
	//redirect them back to login page if they didn't click login button
	header("Location: settings.php");
	exit();
}
