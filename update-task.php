<?php
    require_once('./require/header.php');

    //Check the Task ID in URL

    if(isset($_GET['task_id']))
    {
        //Get the Values from DAtabase
        $task_id = $_GET['task_id'];

        //Select Database
        $db_select = mysqli_select_db($con, DB_NAME) or die();
        $sql = "SELECT * FROM tasks WHERE acct_id = '$acct_id' AND task_id = '$task_id'";

        //Execute Query
        $res = mysqli_query($con, $sql);

        //Check if the query executed successfully or not
        if($res==true)
        {
            //Query <br />Executed
            $row = mysqli_fetch_assoc($res);

            //Get the Individual Value
            $object = $row['object'];
            $details = $row['details'];
            $list_id = $row['list_id'];
            $priority = $row['priority'];
            $deadline = $row['deadline'];
            $type = $row['type'];
        }
    }
    else
    {
        //Redirect to Homepage
        header('location: ./taskmngr.php');
    }


    //Check if the button is clicked
    if(isset($_POST['submit']))
    {
        //echo "Clicked";

        //Get the values from Form
        $object = htmlspecialchars($_POST['object']);
        $details = htmlspecialchars($_POST['details']);
        $list_id = htmlspecialchars($_POST['list_id']);
        $priority = htmlspecialchars($_POST['priority']);
        $deadline = htmlspecialchars($_POST['deadline']);
        $type = htmlspecialchars($_POST['type']);

        //SElect Database
        $db_select3 = mysqli_select_db($con, DB_NAME) or die();

        //CREATE SQL QUery to Update TAsk
        $sql3 = "UPDATE tasks SET
                object = '$object',
                details = '$details',
                list_id = '$list_id',
                priority = '$priority',
                deadline = '$deadline',
                type = '$type'
                WHERE acct_id = '$acct_id'
                AND task_id = '$task_id'";

        //Execute Query
        $res3 = mysqli_query($con, $sql3);


        //CHeck whether the Query Executed of Not
        if($res3==true)
        {
            //Query Executed and Task Updated
            $_SESSION['update'] = "Task Updated Successfully";

            //Redirect to Home Page
            header('location: ./taskmngr.php');
        }
        else
        {
            //FAiled to Update Task
            $_SESSION['update_fail'] = "Failed to Update Task";

            //Redirect to this Page
            header('Location: ./update-task.php?task_id='.$task_id);
        }


    }

?>

<?=template_header('Task Mngr')?>

    <div class="w3-content w3-mobile update">

        <h1>UPDATE TASK</h1>
            <div class="w3-col s12 m12 l12 w3-camo-fade w3-margin w3-border w3-round w3-border-blue-grey w3-pannel w3-card-4">
            <!-- Menu Starts Here -->
            <div class="task-mngr">
                <a href="./taskmngr.php">Tasks</a>
            </div>
            <br />
            <?php
                if(isset($_SESSION['update_fail']))
                {
                    echo $_SESSION['update_fail'];
                    unset($_SESSION['update_fail']);
                }
            ?>

            <form method="POST" action="">
                <table class="">
                    <tr>
                        <td>Task List: </td>
                        <td>
                            <select name="list_id">
                                <?php

                                    //SElect Database
                                    $db_select2 = mysqli_select_db($con, DB_NAME) or die();

                                    //SQL Query to GET Lists
                                    $sql2 = "SELECT * FROM task_lists WHERE acct_id = '$acct_id' ";

                                    //Execute Query
                                    $res2 = mysqli_query($con, $sql2);

                                    //Check if executed successfully or not
                                    if($res2==true)
                                    {
                                        //Display the Lists
                                        //Count Rows
                                        $count_rows2 = mysqli_num_rows($res2);

                                        //Check whether list is added or not
                                        if($count_rows2>0)
                                        {
                                            //Lists are Added
                                            while($row2=mysqli_fetch_assoc($res2))
                                            {
                                                //Get individual value
                                                $list_id_db = $row2['id'];
                                                $list_name = $row2['list_name'];
                                                ?>

                                                <option <?php if($list_id_db==$list_id){echo "selected='selected'";} ?> value="<?php echo $list_id_db; ?>"><?php echo $list_name; ?></option>

                                                <?php
                                            }
                                        }
                                        else
                                        {
                                            //No List Added
                                            //Display None as option
                                            ?>
                                            <option <?php if($list_id=0){echo "selected='selected'";} ?> value="0">None</option>p
                                            <?php
                                        }
                                    }
                                ?>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td>Name/Object: </td>
                        <td><input type="text" name="object" value="<?php echo $object; ?>" /></td>
                    </tr>

                    <tr>
                        <td>Task Description: </td>
                        <td><textarea  type="text" name="details"><?=$details; ?></textarea></td>
                    </tr>
                    <tr>
                    <td>Priority: </td>
                    <td>
                        <select name="priority">
                            <option <?php if($type=="High"){echo "selected='selected'";} ?> value="High">High</option>
                            <option <?php if($type=="Medium"){echo "selected='selected'";} ?> value="Medium">Medium</option>
                            <option <?php if($type=="Low"){echo "selected='selected'";} ?> value="Low">Low</option>
                        </select>
                    </td>
                    </tr>
                    <tr>
                        <td>Deadline: </td>
                        <td><input type="datetime-local" name="deadline" value="<?php echo $deadline; ?>" /></td>
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
                </table>
                    <div class="w3-row">
                        <div class="w3-col s12 m12 l3 w3-margin-right">
                            <input type="submit" name="submit" value="UPDATE" />
                        </div>
                        <div class="w3-col s12 m12 l3 w3-margin-right w3-margin">
                            <a href="./taskmngr.php" class="w3-button w3-orange w3-hover-amber">Cancel</a>
                        </div>
                    </div>
            </form>
        </div>
    </div>
<?php
    require_once('./require/footer.php');
?>
