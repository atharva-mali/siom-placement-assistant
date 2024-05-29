<?php

//To Handle Session Variables on This Page
session_start();

//If user Not logged in then redirect them back to homepage. 
//This is required if user tries to manually enter view-job-post.php in URL.
if (empty($_SESSION['id_company'])) {
  header("Location: ../index.php");
  exit();
}

//Including Database Connection From db.php file to avoid rewriting in all files  
require_once("../db.php");

$sql = "SELECT * FROM apply_job_post WHERE id_company='$_SESSION[id_company]' AND id_user='$_GET[id]' AND id_jobpost='$_GET[id_jobpost]'";
$result = $conn->query($sql);
if ($result->num_rows == 0) {
  header("Location: index.php");
  exit();
}


// i am changing the default status to value 0 in order to give the output that the student is placed. 

// under review code is now placed student code

$sql = "UPDATE apply_job_post SET status='0' WHERE id_company='$_SESSION[id_company]' AND id_user='$_GET[id]' AND id_jobpost='$_GET[id_jobpost]'";
if ($conn->query($sql) === TRUE) {
  // Send email to the placed student
  $sql_student = "SELECT email FROM users WHERE id_user='$_GET[id]'";
  $result_student = $conn->query($sql_student);
  if ($result_student->num_rows > 0) {
    $row_student = $result_student->fetch_assoc();
    $to_email = $row_student['email'];
    $subject = "Congratulations! You have been placed | SIOM Placement Assistant";
    $message = "Dear student,\n\nCongratulations on being placed at company. We are excited to have you on board and look forward to your contributions. Kindly check your student dashboard for more detils.\n\nRegards,\n$_SESSION[name]";
    $headers = "From: mail.siomplacementassistant@gmail.com";
    // Send email
    if (mail($to_email, $subject, $message, $headers)) {
      // Redirect to job applications page
      header("Location: job-applications.php");
      exit();
    } else {
      echo "Error: Unable to send email.";
    }
  } else {
    echo "Error: Student record not found.";
  }
} else {
  echo "Error: Student record not found.";
}
