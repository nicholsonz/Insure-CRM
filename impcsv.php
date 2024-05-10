<?php
// Load the database configuration file
include_once 'dbconfig.php';
// We need to use sessions, so you should always start sessions using the below code.
if (session_status() === PHP_SESSION_NONE) {
    session_start();
  }

  // Set some global variables 
$acct_id = $_SESSION["id"];


// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
  header("location: index.php");
  exit;
}
if(isset($_POST['importSubmit'])){
    
    // Allowed mime types
    $csvMimes = array('text/x-comma-separated-values', 'text/comma-separated-values', 'application/octet-stream', 'application/vnd.ms-excel', 'application/x-csv', 'text/x-csv', 'text/csv', 'application/csv', 'application/excel', 'application/vnd.msexcel', 'text/plain');
    
    // Validate whether selected file is a CSV file
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
                $prevQuery = "SELECT * FROM leads WHERE name = '$line[0]'";
                $prevResult = $con->query($prevQuery);
                
                if($prevResult->num_rows > 0){
                    // Update member data in the database
                    $con->query("UPDATE leads SET name = '$name', phone = '$phone', status = '$status', modified = NOW() WHERE email = '$email'");
                }else{
                    // Insert member data in the database
                    $con->query("INSERT INTO leads (acct_id, name, address, city, state, zip, county, birthdate, phone, phone_sec, email, partA_date, partB_date, medicare_number, policy, insurer, appstatus, notes, created) VALUES ('$acct_id', '$name', '$address', '$city', '$state', '$zip', '$county', '$birthdate', '$phone', '$phone_sec', '$email', '$partA_date', '$partB_date', '$medicare_number', '$policy', '$insurer', '$appstatus', '$notes', NOW())");
                }
            }
            
            // Close opened CSV file
            fclose($csvFile);
            
            $qstring = '?status=succ';
        }else{
            $qstring = '?status=err';
        }
    }else{
        $qstring = '?status=invalid_file';
    }
}

// Redirect to the listing page
header("Location: leads.php");
?>
