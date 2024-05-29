 <?php
$name = $_POST['name'];
$email = $_POST['email'];
$sub = $_POST['subject'];
$message = $_POST['message'];
//
// *** To Email ***
$to = 'mail.siomplacementassistant@gmail.com';
//
// *** Subject Email ***
$subject = 'Contact Form submitted Subject : ' . $sub;
//
// *** Content Email ***
$content = "From : " . $name . "\n" . "Email : " . $email . "\n" . "Message : " . $message;
//
//*** Head Email ***
$headers = "From:" . $email . "\r\n";
//
//*** Show the result... ***
$sent = false;
if (mail($to, $subject, $content, $headers)) {
  $sent = true;
  echo "No Error - Message send Success !!!";
} else {
  echo "ERROR";
}
