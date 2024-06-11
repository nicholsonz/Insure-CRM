<?php
    require_once('./require/header.php');


    //Check whether the form is submitted or not
    if(isset($_POST['submit']))
    {
        //echo "Form Submitted";

        //Get the values from form and save it in variables
        $list_name = htmlspecialchars($_POST['list_name']);
        $list_description = htmlspecialchars($_POST['list_description']);

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
        $sql = "INSERT INTO task_lists SET
            acct_id = '$acct_id',
            list_name = '$list_name',
            list_description = '$list_description'";

        //Execute Query and Insert into Database
        $res = mysqli_query($conn, $sql);

        //Check whether the query executed successfully or not
        if($res==true)
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

<div class="content">

        <h1>ADD TASK LIST</h1>

        <!-- Menu Starts Here -->
        <div class="task-mngr">
            <a href="./manage-list.php">Manage Lists</a>
        </div>
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

            <table class="">
                <tr>
                    <td>List Name: </td>
                    <td><input type="text" name="list_name" placeholder="Type list name here" required="required" /></td>
                </tr>
                <tr>
                    <td>List Description: </td>
                    <td><textarea name="list_description" placeholder="Type List Description Here"></textarea></td>
                </tr>

                <tr>
                    <td><input class="w3-button" type="submit" name="submit" value="SAVE" /></td>
                    <td><a href="./taskmngr.php" class="w3-button w3-orange w3-hover-amber">Cancel</a></td>
                </tr>

            </table>

        </form>

        <!-- Form to Add List Ends Here -->
        </div>
    </div>

<?php require('./require/footer.php');
?>
