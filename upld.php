<?php


$target_dir = "uploads/";
$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
$uploadOk = 1;
$fileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

// Check if image file is a actual image or fake image
if(isset($_POST["submit"])) {
  $check = filesize($_FILES["fileToUpload"]["tmp_name"]);
  if($check !== false) {
    echo "File has been uploaded successfully - " . $check["mime"] . ".";
    $uploadOk = 1;
    sleep(7);
    header('Location: clients.php');
  } else {
    echo "File is not an acceptable format.";
    $uploadOk = 0;
    sleep(7);
    header('Location: clients.php');
  }
}

// Check if file already exists
if (file_exists($target_file)) {
  echo "Sorry, file already exists.";
  $uploadOk = 0;
  sleep(7);
  header('Location: clients.php');

}

// Check file size
if ($_FILES["fileToUpload"]["size"] > 1000000) {
  echo "Sorry, your file is too large.";
  $uploadOk = 0;
  sleep(7);
  header('Location: clients.php');

}

// Allow certain file formats
if($fileType != "pdf" && $fileType != "odt" && $fileType != "docx" && $fileType != "doc" ) {
  echo "Sorry, only PDF, ODT, DOCX, and DOC files are allowed.";
  $uploadOk = 0;
  sleep(7);
  header('Location: clients.php');
}

// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
  echo "Sorry, your file was not uploaded.";
  sleep(7);
  header('Location: clients.php');
// if everything is ok, try to upload file
} else {
  if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
    echo "The file ". htmlspecialchars( basename( $_FILES["fileToUpload"]["name"])). " has been uploaded.";
    sleep(7);
    header('Location: clients.php');
  } else {
    echo "Sorry, there was an error uploading your file.";
    sleep(7);
    header('Location: clients.php');
  }
}
?>
