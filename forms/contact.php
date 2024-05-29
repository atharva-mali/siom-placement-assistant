<!-- 
  /**
  * Requires the "PHP Email Form" library
  * The "PHP Email Form" library is available only in the pro version of the template
  * The library should be uploaded to: vendor/php-email-form/php-email-form.php
  * For more info and help: https://bootstrapmade.com/php-email-form/
  */

  // // Replace contact@example.com with your real receiving email address
  // $receiving_email_address = 'pythnprograom8@gmail.com';

  // if( file_exists($php_email_form = '../forms/contact.php' )) {
  //   include( $php_email_form );
  // } else {
  //   die( 'Unable to load the "PHP Email Form" Library!');
  //}

  // $contact = new $php_email_form;
  // $contact->ajax = true;
  
  // $contact->to = $receiving_email_address;
  // $contact->from_name = $_POST['name'];
  // $contact->from_email = $_POST['email'];
  // $contact->subject = $_POST['subject'];

  // Uncomment below code if you want to use SMTP to send emails. You need to enter your correct SMTP credentials
  
  // $contact->smtp = array(
  //   'host' => 'smtp.gmail.com',
  //   'username' => 'programpython8@gmail.com',
  //   'password' => 'brjtvxvqsgdbmezz',
  //   'port' => '465'
  // );
  

  // $contact->add_message( $_POST['name'], 'From');
  // $contact->add_message( $_POST['email'], 'Email');
  // $contact->add_message( $_POST['message'], 'Message', 10);

  // echo $contact->send();
 -->
<?php
$name = $_POST['name'];
$email = $_POST['email'];
$sub = $_POST['subject'];
$message = $_POST['message'];
//
// *** To Email ***
$to = 'mail.siomplacementassistant@gmail.com,' . $email;
//
// *** Subject Email ***
$subject = 'New Contact Form Submitted -  Subject : ' . $sub;
//
// *** Content Email ***
$content = "From : " . $name . "\n" . "Email : " . $email . "\n" . "Message : " . $message . "\nThank you for contacting us!\nOur team will respond to your query, feedback soon!\nFor any queries you can contact T/P Cell on mail.siomplacementassistant@gmail.com\n\nRegards,\nMail Team, SIOM Placement Assistant";
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
