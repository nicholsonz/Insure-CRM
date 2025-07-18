<?php
 require('./require/header.php');

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

<?=template_header('View Client')?>

    <div class="w3-content w3-mobile">
        <div class="w3-col s12 m12 l12 w3-camo-fade w3-margin w3-border w3-round w3-border-blue-grey w3-pannel w3-card-4">
                    <h1 class=""><?php echo $row["name"]; ?></h1>
                    <div class="w3-row">
                        <div class="w3-col l5 m5 s12 w3-margin w3-padding">
                             <h3>Contact Info</h3>
                             <address>
                                <?php echo $row["address"]; ?><br>
                                <?php echo $row["city"]; ?>, <?php echo $row["state"]; ?>  <?php echo $row["zip"]; ?>
                             </address>
                            <?php echo "<b>County: </b>" .  $row["county"]; ?><br>
                            <?php echo "<b>Phone #: </b>" . $row["phone"]; ?><br>
                            <?php echo "<b>Other #: </b>" . $row["phone_sec"]; ?><br>
                            <?php echo "<b>Email: </b>" . $row["email"]; ?><br>
                            <?php echo "<b>Birthdate: </b>" . $row['birthdate']; ?><br>
                        </div>  
                        <div class="w3-col l5 m5 s12 w3-margin w3-padding"> 
                            <h3>Part A</h3>
                            <?php echo $row["partA_date"]; ?>
                            <h3>Part B</h3>
                            <?php echo $row["partB_date"]; ?>
                            <h3>Medicare Number</h3>
                            <?php echo $row["medicare_number"]; ?>
                        </div>
                    <div class="w3-row">
                        <div class="w3-col l5 m5 s12 w3-margin w3-padding">
                            <h3>Policy</h3>
                            <?php echo $row["policy"]; ?>
                            <h3>Insurer</h3>
                            <?php echo $row["insurer"]; ?>
                            <h3>App Status</h3>
                            <?php echo $row["appstatus"]; ?>
                            <h3>Created</h3>
                            <?php echo $row["created"]; ?>
                        </div>
                        <div class="w3-col l5 m5 s12 w3-margin w3-padding">
                            <h3>Notes</h3>
                            <textarea><?php echo $row["notes"]; ?></textarea>
                        </div>
                    </div>  
                    </table>

                </div>
           </div>
<?php require_once('./require/footer.php');?>