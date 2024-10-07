<?php
include('../include/dbconfig.php');

// We need to use sessions, so you should always start sessions using the below code.
if (session_status() === PHP_SESSION_NONE) {
  session_start();
}

// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
header("location: ../index.php");
exit;
}

// prevent execution of the file directly
if(!isset($_POST['submit'])){
  exit("This file cannot be accessed directly!");
}


// Determine if client or lead
if(isset($_GET['client'])){
  $name = $_GET['client'];
  $type = 'Client';
  $target_dir = "../uplds/clients/$name";
  // Check if target dir exists and if not create
  if (!file_exists($target_dir)) {
    mkdir($target_dir, 0755, true);
  }
}
if(isset($_GET['lead'])){
  $name = $_GET['lead'];
  $type = 'Lead';
  $target_dir = "../uplds/leads/$name";
  // Check if target dir exists and if not create
  if (!file_exists($target_dir)) {
    mkdir($target_dir, 0755, true);
  }
}
// Set a few variables
$target_file = $target_dir . "/" . basename($_FILES["fileToUpload"]["name"]);
$uploadOk = 1;
$fileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
$error_msg = '';

// Check if file is genuine
if(isset($_POST["submit"])) {
  $check = filesize($_FILES["fileToUpload"]["tmp_name"]);
  if($check !== false) {
    $uploadOk = 1;
  } else {
    $uploadOk = 0;
  }
}

// Check if file already exists
if (file_exists($target_file)) {
  $error_msg = "Sorry, file already exists.";
  $uploadOk = 0;
}

// Check file size and set to 20Mb
if ($_FILES["fileToUpload"]["size"] > 20000000) {
  $error_msg = "Sorry, your file is too large.";
  $uploadOk = 0;
}

// Allow certain file formats
if($fileType != "pdf" && $fileType != "odt" && $fileType != "docx" && $fileType != "doc" ) {
  $error_msg = "Sorry, only PDF, ODT, DOCX, and DOC files are allowed.";
  $uploadOk = 0;
}

// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
  echo "<script>alert('$error_msg');
        history.back()</script>";

// if everything is ok, try to upload file
} else {
  if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
      // $insert = $con->query("INSERT INTO files (name, type, location) VALUES ('$name', '$type', '$target_file')");
      // }
      // if($insert){
        echo "<script>alert('The file ". htmlspecialchars( basename( $_FILES["fileToUpload"]["name"])). " has been uploaded.');
              history.back()</script>";
  } else {
    echo "<script>alert('$error_msg');
          history.back()</script>";
  }
}
?>
