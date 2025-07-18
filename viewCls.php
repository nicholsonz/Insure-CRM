<?php
 require('./require/header.php');



// Check existence of id parameter before processing further
if(isset($_GET["id"]) && !empty(trim($_GET["id"]))){

    // Prepare a select statement
    $sql = "SELECT * FROM clients WHERE acct_id = '$acct_id' AND id = :id";

    if($stmt = $pdo->prepare($sql)){
        // Bind variables to the prepared statement as parameters
        $stmt->bindParam(":id", $param_id);

        // Set parameters
        $param_id = trim($_GET["id"]);

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

</head>
<body>
    <div class="w3-content w3-mobile">
        <div class="w3-col s12 m12 l12 w3-camo-fade w3-margin w3-border w3-round w3-border-blue-grey w3-pannel w3-card-4">
                    <h1 class=""><?php echo $row["name"]; ?></h1>

                         <div class="w3-col l5 m5 s8">
                            <b><label>Name & Address</label></b><br />
                             <p><?php echo $row["name"]; ?>
                             <p><?php echo $row["address"]; ?>
                             <p><?php echo $row["city"]; ?> <?php echo $row["state"]; ?>  <?php echo $row["zip"]; ?></p>
                         </div>
                         <div><b><label>County</label></b><br />
                             <p><?php echo $row["county"]; ?></p>
                         </div>
                       <div><b><label>Primary Phone</label></b><br />
                             <p><?php echo $row["phone"]; ?></p>
                         </div>
                         <div>
                             <b><label>Secondary Phone</label></b><br />
                             <p><?php echo $row["phone_sec"]; ?></p>
                         </div>
                         <div>
                             <b><label>Email</label></b><br />
                             <p><?php echo $row["email"]; ?></p>
                         </div>
                         <div><b><label>Birth Date</label></b><br />
                             <p><?php echo $row["birthdate"]; ?></p>
                         </div>
                       <div><b><label>Part A</label></b><br />
                             <p><?php echo $row["partA_date"]; ?></p>
                             <b><label>Part B</label></b><br />
                             <p><?php echo $row["partB_date"]; ?></p>
                         </div>
                         <div><b><label>Medicare Number</label></b><br />
                             <p><?php echo $row["medicare_number"]; ?></p>
                         </div>
                         <div><b><label>Policy</label></b><br />
                             <p><?php echo $row["policy"]; ?></p>
                         <div><b><label>Insurer</label></b><br />
                             <p><?php echo $row["insurer"]; ?></p>
                         </div>
                         <div><b><label>App Status</label></b><br />
                             <p><?php echo $row["appstatus"]; ?></p>
                         </div>
                       <div class="w3-col l5 m5 s8">
                            <b><label>Notes</label></b><br />
                             <textarea><?php echo $row["notes"]; ?></textarea>
                         </div>
                         <div><b><label>Created</label></b><br />
                             <p><?php echo $row["created"]; ?></p>
                         </div>
                        
                    </table>

                </div>
           </div>
    </body>
</html>
