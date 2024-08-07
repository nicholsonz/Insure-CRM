<?php
    require_once('./require/header.php');

    if (isset($_GET['task_name'])) {
        $name = ($_GET['task_name']);
    }else{
        $task_name = "";
    }
    if (isset($_GET['name'])) {
        $name = ($_GET['name']);
    }else{
        $name = "";
    }
    if(isset($_GET['type'])){
        $type = ($_GET['type']);
    }else{
        $type = "";
    }

//Check whether the SAVE button is clicked or not
if(isset($_POST['submit']))
{
    //echo "Button Clicked";
    //Get all the Values from Form
    $task_name = htmlspecialchars($_POST['task_name']);
    $name = htmlspecialchars($_POST['name']);
    $details = htmlspecialchars($_POST['details']);
    $list_id = htmlspecialchars($_POST['list_id']);
    $priority = htmlspecialchars($_POST['priority']);
    $deadline = htmlspecialchars($_POST['deadline']);
    $type = htmlspecialchars($_POST['type']);

    //Connect Database
    $conn2 = mysqli_connect(LOCALHOST, DB_USERNAME, DB_PASSWORD) or die();

    //SElect Database
    $db_select2 = mysqli_select_db($conn2, DB_NAME) or die();

    //CReate SQL Query to INSERT DATA into DAtabase
    $sql2 = "INSERT INTO tasks SET
        acct_id = '$acct_id',
        task_name = '$task_name',
        name = '$name',
        details = '$details',
        list_id = $list_id,
        priority = '$priority',
        deadline = '$deadline',
        type = '$type'";

    //Execute Query
    $res2 = mysqli_query($conn2, $sql2);

    //Check whetehre the query executed successfully or not
    if($res2==true)
    {
        //Query Executed and Task Inserted Successfully
        $_SESSION['add'] = "Task Added Successfully.";

        //Redirect to Homepage
        header('location: ./taskmngr.php');

    }
    else
    {
        //FAiled to Add TAsk
        $_SESSION['add_fail'] = "Failed to Add Task";
        //Redirect to Add TAsk Page
        header('location: ./add-task.php');
    }
}

?>


<?=template_header('Task Mngr')?>

        <div class="w3-content">

        <h1>ADD TASK</h1>
        <hr></hr>

            <!-- Menu Starts Here -->
        <div class="task-mngr">
            <a href="./taskmngr.php">Tasks</a>
        </div>
        <br />
        <div class="">

<!-- Menu Ends Here -->

            <?php
                if(isset($_SESSION['add_fail']))
                {
                    echo $_SESSION['add_fail'];
                    unset($_SESSION['add_fail']);
                }
            ?>

        <form method="POST" action="">

            <table>
                <tr>
                    <td>Task Name: </td>
                    <td><input type="text" name="task_name" placeholder="Task Name" required="required" value="<?= $task_name;?>"/></td>
                </tr>
                <tr>
                    <td>Name: </td>
                    <td><input type="text" name="name" placeholder="Name" value="<?= $name;?>"/></td>
                </tr>

                <tr>
                    <td>Task Description: </td>
                    <td><textarea type="text" name="details" placeholder="Type Task Description"></textarea></td>
                </tr>

                <tr>
                    <td>Select List: </td>
                    <td>
                        <select name="list_id">

                            <?php

                                //Connect Database
                                $conn = mysqli_connect(LOCALHOST, DB_USERNAME, DB_PASSWORD) or die();

                                //SElect Database
                                $db_select = mysqli_select_db($conn, DB_NAME) or die();

                                //SQL query to get the list from table
                                $sql = "SELECT * FROM task_lists WHERE acct_id = '$acct_id'";

                                //Execute Query
                                $res = mysqli_query($conn, $sql);

                                //Check whether the query executed or not
                                if($res==true)
                                {
                                    //Create variable to Count Rows
                                    $count_rows = mysqli_num_rows($res);

                                    //If there is data in database then display all in dropdows else display None as option
                                    if($count_rows>0)
                                    {
                                        //display all lists on dropdown from database
                                        while($row=mysqli_fetch_assoc($res))
                                        {
                                            $list_id = $row['list_id'];
                                            $list_name = $row['list_name'];
                                            ?>
                                            <option value="<?php echo $list_id ?>"><?php echo $list_name; ?></option>
                                            <?php
                                        }
                                    }
                                    else
                                    {
                                        //Display None as option
                                        ?>
                                        <option value="0">None</option>p
                                        <?php
                                    }

                                }
                            ?>


                        </select>
                    </td>
                </tr>

                <tr>
                    <td>Priority: </td>
                    <td>
                        <select name="priority">
                            <option value="High">High</option>
                            <option value="Medium">Medium</option>
                            <option value="Low">Low</option>
                        </select>
                    </td>
                </tr>

                <tr>
                    <td>Deadline: </td>
                    <td><input type="date" name="deadline" /></td>
                </tr>
                <tr>
                    <td>Type: </td>
                    <td>
                        <select name="type">
                            <option <?php if($type=="Lead"){echo "selected='selected'";} ?> value="Lead">Lead</option>
                            <option <?php if($type=="Client"){echo "selected='selected'";} ?> value="Client">Client</option>
                            <option <?php if($type=="Other"){echo "selected='selected'";} ?> value="Other">Other</option>
                        </select>
                    </td>
                </tr>
                <tr>
                  <td>
                    <br />
                  </td>
                </tr>
                <tr>
                    <td><input class="w3-button" type="submit" name="submit" value="SAVE" /></td>
                    <td><a href="./taskmngr.php" class="w3-button w3-orange w3-hover-amber">Cancel</a></td>
                </tr>

            </table>

         </form>
        </div>
    </div>
</body>
</html>
