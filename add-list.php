<?php
    require_once('./require/header.php');


    //Check whether the form is submitted or not
    if(isset($_POST['submit']))
    {
        //echo "Form Submitted";

        //Get the values from form and save it in variables
        $list_name = mysqli_real_escape_string($con, $_POST['list_name']);
        $list_description = mysqli_real_escape_string($con, $_POST['list_description']);

        //Connect Database
        $conn = mysqli_connect(LOCALHOST, DB_USERNAME, DB_PASSWORD) or die();

        //Check whether the database connected or not
        /*
        if($conn==true)
        {
            echo "Database Connected";
        }
        */

        //SElect Database
        $db_select = mysqli_select_db($conn, DB_NAME);

        //Check whether database is connected or not
        /*
        if($db_select==true)
        {
            echo "Database SElected";
        }
        */
        //SQL Query to Insert data into database
        $sql = mysqli_prepare($con, "INSERT INTO task_lists SET acct_id = ?, list_name = ?, list_description = ?");
          mysqli_stmt_bind_param($sql, "iss", $acct_id, $list_name, $list_description);
        $sql->execute();

        if($sql)
        {
            //Data inserted successfully
            //echo "Data Inserted";

            //Create a SESSION VAriable to Display message
            $_SESSION['add'] = "List Added Successfully";

            //Redirect to Manage List Page
            header('location: ./manage-list.php');


        }
        else
        {
            //Failed to insert data
            //echo "Failed to Insert Data";

            //Create SEssion to save message
            $_SESSION['add_fail'] = "Failed to Add List";

            //REdirect to Same Page
            header('location: ./add-list.php');
        }

    }

?>

<?=template_header('Task Mngr')?>

<div class="w3-content w3-mobile update">

        <h1>ADD TASK LIST</h1>
    <div class="w3-col s12 m12 l12 w3-camo-fade w3-margin w3-border w3-round w3-border-blue-grey w3-pannel w3-card-4">
        <div class="task-mngr">
            <a href="./manage-list.php">Manage Lists</a>
        </div>
        <br />
        <div class="">
        <!-- Menu Ends Here -->
        <?php

            //Check whether the session is created or not
            if(isset($_SESSION['add_fail']))
            {
                //display session message
                echo $_SESSION['add_fail'];
                //Remove the message after displaying once
                unset($_SESSION['add_fail']);
            }

        ?>

        <!-- Form to Add List Starts Here -->

        <form method="POST" action="">

            <table class="w3-table">
                <tr>
                    <td>List Name: </td>
                    <td><input type="text" name="list_name" placeholder="Type list name here" required="required" /></td>
                </tr>
                <tr>
                    <td>List Description: </td>
                    <td><textarea name="list_description" placeholder="Type List Description Here"></textarea></td>
                </tr>
                <tr>
                  <td>
                    <br />
                  </td>
                </tr>
                <tr>
                  <td>
                    <br />
                  </td>
                </tr>
            </table>
            <div class="w3-row">
                <div class="w3-col s12 m12 l3 w3-margin-right">
                    <input class="w3-button" type="submit" name="submit" value="SAVE" />
                </div>
                <div class="w3-col s12 m12 l3 w3-margin-right w3-margin">
                    <a href="./taskmngr.php" class="w3-button w3-orange w3-hover-amber">Cancel</a>
                </div>
            </div>
        </form>
        <!-- Form to Add List Ends Here -->
        </div>
    </div>
</div>
<?php require('./require/footer.php');?>
