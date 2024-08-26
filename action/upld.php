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
    mkdir($target_dir, 0770, true);
  }
}
if(isset($_GET['lead'])){
  $name = $_GET['lead'];
  $type = 'Lead';
  $target_dir = "../uplds/leads/$name";
  // Check if target dir exists and if not create
  if (!file_exists($target_dir)) {
    mkdir($target_dir, 0770, true);
  }
}
// Set a few variables
$target_file = $target_dir . "/" . basename($_FILES["fileToUpload"]["name"]);
$uploadOk = 1;
$fileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

// Check if file is genuine
if(isset($_POST["submit"])) {
  $check = filesize($_FILES["fileToUpload"]["tmp_name"]);
  if($check !== false) {
    echo "File has been uploaded successfully - " . $check . ".";
    $uploadOk = 1;
  } else {
    echo "File is not an acceptable format.";
    $uploadOk = 0;
  }
}

// Check if file already exists
if (file_exists($target_file)) {
  echo "Sorry, file already exists.";
  $uploadOk = 0;

}

// Check file size
if ($_FILES["fileToUpload"]["size"] > 10000000) {
  echo "Sorry, your file is too large.";
  $uploadOk = 0;

}

// Allow certain file formats
if($fileType != "pdf" && $fileType != "odt" && $fileType != "docx" && $fileType != "doc" ) {
  echo "Sorry, only PDF, ODT, DOCX, and DOC files are allowed.";
  $uploadOk = 0;
}

// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
  echo "Sorry, your file was not uploaded.";
// if everything is ok, try to upload file
} else {
  if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
      // $insert = $con->query("INSERT INTO files (name, type, location) VALUES ('$name', '$type', '$target_file')");
      // }
      // if($insert){
        echo "The file ". htmlspecialchars( basename( $_FILES["fileToUpload"]["name"])). " has been uploaded.";
  } else {
    echo "Sorry, there was an error uploading your file.";
  }
}
?>
