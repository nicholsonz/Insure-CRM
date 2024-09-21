<?php
 include('./include/dbconfig.php');

 // We need to use sessions, so you should always start sessions using the below code.
 if (session_status() === PHP_SESSION_NONE) {
     session_start();
   }

   // Set some global variables
 $acct_id = $_SESSION['id'];


 // Check if the user is logged in, if not then redirect him to login page
 if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
   header("location: index.php");
   exit;
  }

// Connect to MySQL database
$pdo = pdo_connect_mysql();

// Check existence of name parameter before processing further
if(isset($_GET["name"]) && !empty(trim($_GET["name"]))){

    // Prepare a select statement
    $sql = "SELECT * FROM leads WHERE acct_id = '$acct_id' AND name = :name";

    if($stmt = $pdo->prepare($sql)){
        // Bind variables to the prepared statement as parameters
        $stmt->bindParam(":name", $param_name);

        // Set parameters
        $param_name = trim($_GET["name"]);

        // Attempt to execute the prepared statement
        if($stmt->execute()){
            if($stmt->rowCount() == 1){
                /* Fetch result row as an associative array. Since the result set
                contains only one row, we don't need to use while loop */
                $row = $stmt->fetch(PDO::FETCH_ASSOC);

                // Retrieve individual field value
                $name = $row["name"];
                $address = $row["address"];
                $city = $row["city"];
                $state = $row['state'];
                $zip = $row['zip'];
                $county = $row['county'];
                $birthdate = $row['birthdate'];
                $phone = $row['phone'];
                $phone2 = $row['phone_sec'];
                $email = $row['email'];
                $partA_date = $row['partA_date'];
                $partB_date = $row['partB_date'];
                $medicare_number = $row['medicare_number'];
                $policy = $row['policy'];
                $insurer = $row['insurer'];
                $appstatus = $row['appstatus'];
                $notes = $row['notes'];
                $created = $row['created'];
            } else{
                // URL doesn't contain valid id parameter. Redirect to error page
                 header("location: error.php");
                exit();
            }

        } else{
            echo "Oops! Something went wrong. Please try again later.";
        }
    }

    // Close statement
    unset($stmt);

    // Close connection
    unset($pdo);
} else{
    // URL doesn't contain id parameter. Redirect to error page
    header("location: error.php");
    exit();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>View Record</title>
    <link rel="stylesheet" href="./css/style.css">

</head>
<body>
    <div class="contentview">
        <div class="">
                    <h1 class=""><?php echo $row["name"]; ?></h1>
                    <table>
                        <tr>
                         <td colspan="2"><b><label>Name & Address</label></b><br />
                             <p><?php echo $row["name"]; ?>
                             <p><?php echo $row["address"]; ?>
                             <p><?php echo $row["city"]; ?> <?php echo $row["state"]; ?>  <?php echo $row["zip"]; ?></p>
                         </td>
                         <td><b><label>County</label></b><br />
                             <p><?php echo $row["county"]; ?></p>
                         </td>
                        </tr>
                        <tr>
                         <td><b><label>Primary Phone</label></b><br />
                             <p><?php echo $row["phone"]; ?></p>
                         </td>
                         <td>
                             <b><label>Secondary Phone</label></b><br />
                             <p><?php echo $row["phone_sec"]; ?></p>
                         </td>
                         <td>
                             <b><label>Email</label></b><br />
                             <p><?php echo $row["email"]; ?></p>
                         </td>
                         <td><b><label>Birth Date</label></b><br />
                             <p><?php echo $row["birthdate"]; ?></p>
                         </td>
                        </tr>
                        <tr>
                         <td><b><label>Part A</label></b><br />
                             <p><?php echo $row["partA_date"]; ?></p>
                             <b><label>Part B</label></b><br />
                             <p><?php echo $row["partB_date"]; ?></p>
                         </td>
                         <td><b><label>Medicare Number</label></b><br />
                             <p><?php echo $row["medicare_number"]; ?></p>
                         </td>
                         <td><b><label>Policy</label></b><br />
                             <p><?php echo $row["policy"]; ?></p>
                         <td><b><label>Insurer</label></b><br />
                             <p><?php echo $row["insurer"]; ?></p>
                         </td>
                         <td><b><label>App Status</label></b><br />
                             <p><?php echo $row["appstatus"]; ?></p>
                         </td>
                        </tr>
                        <tr>
                         <td colspan="3"><b><label>Notes</label></b><br />
                             <textarea><?php echo $row["notes"]; ?></textarea>
                         </td>
                         <td><b><label>Created</label></b><br />
                             <p><?php echo $row["created"]; ?></p>
                         </td>
                        </tr>
                    </table>

                </div>
           </div>
    </body>
</html>
