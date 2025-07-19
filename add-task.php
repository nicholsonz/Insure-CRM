<?php
    require_once('./require/header.php');

    if (isset($_GET['name'])) {
        $object = ($_GET['name']);
    }else{
        $object = "";
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
    $acct_id = mysqli_real_escape_string($con, $_POST['acct_id']);
    $object = mysqli_real_escape_string($con, $_POST['object']);
    $details = mysqli_real_escape_string($con, $_POST['details']);
    $list_id = mysqli_real_escape_string($con, $_POST['list_id']);
    $priority = mysqli_real_escape_string($con, $_POST['priority']);
    $deadline = mysqli_real_escape_string($con, $_POST['deadline']);
    $type = mysqli_real_escape_string($con, $_POST['type']);

    //Connect Database
    $conn2 = mysqli_connect(LOCALHOST, DB_USERNAME, DB_PASSWORD) or die();

    //SElect Database
    $db_select2 = mysqli_select_db($conn2, DB_NAME) or die();

    //CReate SQL Query to INSERT DATA into DAtabase
    $sql_ins = mysqli_prepare($con, "INSERT INTO tasks SET acct_id = ?, object = ?, details = ?, list_id = ?, priority = ?, deadline = ?, type = ?");
      mysqli_stmt_bind_param($sql_ins, "ississs", $acct_id, $object, $details, $list_id, $priority, $deadline, $type);
    $sql_ins->execute();

    if($sql_ins)
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

<div class="w3-content w3-mobile update">
   <h1>ADD TASK</h1>
    <div class="w3-col s12 m12 l12 w3-camo-fade w3-margin w3-border w3-round w3-border-blue-grey w3-pannel w3-card-4">
        <div class="task-mngr">
            <a href="./taskmngr.php">Tasks</a>
        </div>
        <br />

            <?php
                if(isset($_SESSION['add_fail']))
                {
                    echo $_SESSION['add_fail'];
                    unset($_SESSION['add_fail']);
                }
            ?>

        <form method="POST" action="add-task.php">
                <input type="hidden" name="acct_id" value="<?=$acct_id?>">
            <table>
                    <td>Task: </td>
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
                                            $list_id = $row['id'];
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
                    <td>Name/Object: </td>
                    <td><input type="text" name="object" placeholder="Lead/Client/Other" value="<?= $object;?>"/></td>
                </tr>

                <tr>
                    <td>Task Description: </td>
                    <td><textarea type="text" name="details" placeholder="Type Task Description"></textarea></td>
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
                    <td><input type="datetime-local" name="deadline" /></td>
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
                <input type="submit" name="submit" value="SAVE" />
            </div>
            <div class="w3-col s12 m12 l3 w3-margin-right w3-margin">
                <a href="./taskmngr.php" class="w3-button w3-orange w3-hover-amber">Cancel</a>
            </div>
        </div>

         </form>
        </div>
    </div>
<?php require('./require/footer.php');?>
