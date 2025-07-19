<?php

require_once './require/header.php';

// Set some global variables
$acct_id = $_SESSION["id"];

$file_err = "";

if($_SERVER["REQUEST_METHOD"] == "POST"){

  if(isset($_POST['importSubmit'])){

    // Allowed mime types
    $csvMimes = array('text/x-comma-separated-values', 'text/comma-separated-values', 'application/octet-stream', 'application/vnd.ms-excel', 'application/x-csv', 'text/x-csv', 'text/csv', 'application/csv', 'application/excel', 'application/vnd.msexcel', 'text/plain');

    // Validate whether selected file is a CSV file
    if(!empty($_FILES['file']['name'])){
    if(!empty($_FILES['file']['name']) && in_array($_FILES['file']['type'], $csvMimes)){

        // If the file is uploaded
        if(is_uploaded_file($_FILES['file']['tmp_name'])){

            // Open uploaded CSV file with read-only mode
            $csvFile = fopen($_FILES['file']['tmp_name'], 'r');

            // Skip the first line
            fgetcsv($csvFile);

            // Parse data from CSV file line by line
            while(($line = fgetcsv($csvFile)) !== FALSE){
                // Get row data
                $name   = $line[0];
                $address  = $line[1];
                $city  = $line[2];
                $state  = $line[3];
                $zip  = $line[4];
                $county  = $line[5];
                $birthdate  = $line[6];
                $phone  = $line[7];
                $phone_sec  = $line[8];
                $email = $line[9];
                $partA_date  = $line[10];
                $partB_date  = $line[11];
                $medicare_number  = $line[12];
                $policy  = $line[13];
                $insurer  = $line[14];
                $appstatus = $line[15];
                $notes  = $line[16];
                $created  = $line[17];

                // Check whether member already exists in the database with the same email
                $prevQuery = "SELECT * FROM leads WHERE name = '$line[0]' AND acct_id = '$acct_id'";
                $prevResult = $con->query($prevQuery);
                $nameQry = "SELECT name FROM leads WHERE name = '$line[0]' AND acct_id = '$acct_id'";
                $result = $con -> query($nameQry);
                $row = $result -> fetch_array(MYSQLI_ASSOC);

                if($prevResult->num_rows > 0){
                  foreach($row as $names) {
                    echo "<div class='alert w3-content'>Possible duplicate lead - " . $names ."!</div>";
                  }
                    // $con->query("UPDATE leads SET name = '$name', address = '$address', city = '$city', state = '$state', zip = '$zip', county = '$county', birthdate = '$birthdate', phone = '$phone', phone_sec = '$phone_sec', email = '$email', partA_date = '$partA_date', partB_date = '$partB_date', medicare_number = '$medicare_number', policy = '$policy', insurer = '$insurer',  appstatus = '$appstatus', notes = '$notes', created = '$created'");
                }else{
                    // Insert member data in the database
                    $con->query("INSERT INTO leads (acct_id, name, address, city, state, zip, county, birthdate, phone, phone_sec, email, partA_date, partB_date, medicare_number, policy, insurer, appstatus, notes, created) VALUES ('$acct_id', '$name', '$address', '$city', '$state', '$zip', '$county', '$birthdate', '$phone', '$phone_sec', '$email', '$partA_date', '$partB_date', '$medicare_number', '$policy', '$insurer', '$appstatus', '$notes', NOW())");

                    $file_suc = "Leads imported successfully!";
                }
            }

            // Close opened CSV file
            fclose($csvFile);

    }
  }else{
      $file_err = "Plese choose a valid file (CSV format).";
  }
}else{
    $file_err = "Plese select a file to upload.";
}
}
}
?>

<?=template_header('Leads')?>
<div class="w3-content w3-mobile">
	<div class="w3-col s12 m12 l12 w3-camo-fade w3-margin w3-border w3-round w3-border-blue-grey w3-pannel w3-card-4">
  <?php
  if(!empty($file_err)){
    echo '<div class="alert">' . $file_err .'</div>';
  } elseif(!empty($file_suc)){
    echo '<div class="success">' . $file_suc .'</div>';
  } else{
      
  }
  ?>
  <div class="w3-row">
    <div class="w3-col l4 m4 s12 w3-margin w3-padding" id="importFrm">
        <form action="<?php htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" enctype="multipart/form-data">
            <input type="file" id="file" class="file-upload" name="file" />
            <input type="submit" class="w3-btn" name="importSubmit" value="IMPORT">
        </form>
    </div>
  </div>
  <div class="w3-row">
    <div class="w3-col l4 m4 s12 w3-margin w3-padding w3-text-white">
      <p><a href="./db/impLeads.csv" class="w3-btn w3-blue" download>Download</a> csv template file for upload.</p>
    </div>
 </div>
</div>
</div>

 <?php require_once('./require/footer.php');?>
