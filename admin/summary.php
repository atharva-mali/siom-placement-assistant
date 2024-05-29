<?php

session_start();

if (empty($_SESSION['id_admin'])) {
  header("Location: index.php");
  exit();
}

require_once("../db.php");
?>
<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Placement Portal</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="../css/AdminLTE.min.css">
  <link rel="stylesheet" href="../css/_all-skins.min.css">
  <!-- Custom -->
  <link rel="stylesheet" href="../css/custom.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->


  <!-- Google Font -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
</head>

<body class="hold-transition skin-green sidebar-mini">
  <div class="wrapper">

    <?php

    include 'header.php';

    ?>

    <head>
      <title>Placement Statistics</title>
      <style>
        .mytable {
          width: 100%;
        }

        table {
          font-size: 16px;
        }

        h1 {
          text-align: center;
          margin-bottom: 10px;
        }

        h2,
        h3 {
          margin-top: 1rem;
          margin-bottom: 1rem;
        }

        #no_data_message {
          font-size: large;
        }

        #year_input {
          background-image: url('/css/searchicon.png');
          /* Add a search icon to input */
          background-position: 10px 12px;
          /* Position the search icon */
          background-repeat: no-repeat;
          /* Do not repeat the icon image */
          width: 20%;
          /* Full-width */
          font-size: 14px;
          /* Increase font-size */
          padding: 12px;
          /* Add some padding */
          border: 1px solid #ddd;
          /* Add a grey border */
          margin-bottom: 12px;
          /* Add some space below the input */
          margin-inline: 10px;
      </style>
    </head>
    <div class="content-wrapper" style="margin-left: 0px; background-color: white;">
      <section id="candidates" class="content-header" style="padding-bottom: 10px;">
        <h1>Placement Statistics</h2>
          <div class="container">
            <form action="" method="GET">
              <label for="year" style="font-size: 16px;">Enter Year:</label>
              <input type="number" id="year_input" name="year" required>
              <!-- <button type="submit">Submit</button> -->
              <button type="submit" name='get_summary_btn' style="margin-left: 8px;" class="btn btn-primary btn-lg">Submit</button>

            </form>

          </div>
          <div class="container">
            <?php
            // process.php
            if (isset($_GET['year'])) {
              $year = $_GET['year'];

              // Perform database query
              $sql_qualification = "SELECT users.qualification, COUNT(DISTINCT users.id_user) AS count FROM users
  INNER JOIN apply_job_post ON users.id_user = apply_job_post.id_user
  INNER JOIN job_post ON apply_job_post.id_jobpost = job_post.id_jobpost
  WHERE apply_job_post.status = '0' AND YEAR(job_post.createdat) = $year
  GROUP BY job_post.qualification";

              $sql_jobtitle = "SELECT jobtitle, COUNT(*) AS count FROM users INNER JOIN apply_job_post ON users.id_user = apply_job_post.id_user INNER JOIN job_post ON apply_job_post.id_jobpost = job_post.id_jobpost WHERE apply_job_post.status = '0' AND YEAR(job_post.createdat) = $year 
        GROUP BY jobtitle";


              // Execute the queries and fetch the results
              // Assuming you are using a MySQLi connection
              $result_qualification = $conn->query($sql_qualification);
              $result_jobtitle = $conn->query($sql_jobtitle);

              if ($result_qualification->num_rows > 0 && $result_jobtitle->num_rows > 0) {
                echo "<h2>Placement Statistics for $year</h2>";
                echo "<div class='d-flex align-content-stretch flex-wrap'>";
                echo "<div class='w-50 p-3'>";
                // Display qualification-wise count
                echo "<h3>Program-wise Count</h3>";
                echo "<div class='box-body table-responsive no-padding'>";
                echo "<table class='table table-bordered mytable'>";
                echo "<thead class='thead-dark'>";
                echo "<tr><th scope='col'>Program</th><th scope='col'>Count</th></tr>";
                echo "</thead>";
                echo "<tbody>";

                $totalQualificationCount = 0; // Variable to store the total count

                while ($row = $result_qualification->fetch_assoc()) {
                  $qualification = $row['qualification'];
                  $count = $row['count'];
                  $totalQualificationCount += $count; // Update the total count

                  echo "<tr><td>{$qualification}</td><td>{$count}</td></tr>";
                }

                echo "<tr class='table-info'><td><strong>Total</strong></td><td>{$totalQualificationCount}</td></tr>";
                echo "</tbody>";
                echo "</table>";
                echo "</div>";
                echo "</div>";

                // Display job title-wise count
                echo "<div class='w-50 p-3'>";
                echo "<h3>Job Title-wise Count</h3>";
                echo "<div class='box-body table-responsive no-padding'>";
                echo "<table class='table table-bordered mytable'>";
                echo "<thead class='thead-dark'>";
                echo "<tr><th>Job Title</th><th>Count</th></tr>";
                echo "</thead>";
                echo "<tbody>";

                $totalJobTitleCount = 0; // Variable to store the total count

                while ($row = $result_jobtitle->fetch_assoc()) {
                  $jobTitle = $row['jobtitle'];
                  $count = $row['count'];
                  $totalJobTitleCount += $count; // Update the total count

                  echo "<tr class='table-light'><td>{$jobTitle}</td><td>{$count}</td></tr>";
                }

                echo "<tr class='table-info'><td><strong>Total</strong></td><td>{$totalJobTitleCount}</td></tr>";
                echo "</tbody>";
                echo "</table>";
                echo "</div>";
                echo "</div>";
              } else {
                echo "<div class='alert alert-danger' id='no_data_message'>No data available for the selected year.</div>";
              }

              $conn->close();
            }
            ?>
          </div>
      </section>
    </div>
  </div>


  <footer class="main-footer" style="margin:auto;bottom: 0;
  width: 100%;
  height: 50px; position:relative; background-color:#1f0a0a; color:white;">
    <div class="text-center">
      <strong>Copyright &copy; 2024 SIOM Placement Assistant</strong> All rights
      reserved.
    </div>
  </footer>

  <!-- /.control-sidebar -->
  <!-- Add the sidebar's background. This div must be placed
       immediately after the control sidebar -->
  <div class="control-sidebar-bg"></div>

  </div>
  <!-- ./wrapper -->

  <!-- jQuery 3 -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <!-- Bootstrap 3.3.7 -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/js/bootstrap.min.js"></script>
  <!-- AdminLTE App -->
  <script src="../js/adminlte.min.js"></script>
</body>

</html>