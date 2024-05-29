<?php

session_start();

if (empty($_SESSION['id_admin'])) {
    header("Location: index.php");
    exit();
}


require_once("../db.php");

if (isset($_GET)) {

    //Delete Student using id and redirect
    $sql = "UPDATE users  SET active='0' WHERE id_user='$_GET[id]'";
    if ($conn->query($sql)) {
        // get user email
        $sql = "SELECT email FROM users WHERE id_user='$_GET[id]'";
        $result = $conn->query($sql);
        $row = $result->fetch_assoc();
        // Send Email			
        //
        // *** To Email ***
        $to = $row['email'];
        //
        // *** Subject Email ***
        $subject = "Alert ! Account Rejected | SIOM Placement Assistant";
        //
        // *** Content Email ***
        $html_template = file_get_contents('../email_templates/student_reject.html');
        //
        //*** Head Email ***
        $headers = "From: mail.siomplacementassistant@gmail.com\r\n";
        $headers .= "MIME-Version: 1.0" . "\r\n";
        $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
        //you add more headers like Cc, Bcc;

        $res = mail($to, $subject, $html_template, $headers); // \r\n will return new line. 


        header("Location: applications.php");
        exit();
    } else {
        echo "Error";
    }
}
