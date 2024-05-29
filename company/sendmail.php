<?php


//To Handle Session Variables on This Page
session_start();

//If user Not logged in then redirect them back to homepage. 
//This is required if user tries to manually enter view-job-post.php in URL.
if (empty($_SESSION['id_company'])) {
    header("Location: ../index.php");
    exit();
}


require_once("../db.php");

$sql = "select * from users";

$result = $conn->query($sql);
if ($result->num_rows > 0) {

    while ($row = $result->fetch_assoc()) {

        //recipient email here
        $to = $row['email'];
        // *** Subject Email ***
        $subject = "New Drive Posted | " . $jobtitle . " | SIOM Placement Assistant";
        //
        // *** Content Email ***
        $html_template = file_get_contents('../email_templates/add_drive.html');
        $html = str_replace('{{jobtitle}}', $jobtitle, $html_template);
        $html = str_replace('{{description}}', $description, $html);
        //
        //*** Head Email ***
        $headers = "From: mail.siomplacementassistant@gmail.com\r\n";
        $headers .= "MIME-Version: 1.0" . "\r\n";
        $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
        //you add more headers like Cc, Bcc;

        $res = mail($to, $subject, $html, $headers); // \r\n will return new line. 
    }
}
