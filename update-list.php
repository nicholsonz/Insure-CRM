<?php
    require_once('./require/header.php');

    //Get the Current Values of Selected List
    if(isset($_GET['id']))
    {
        //Get the List ID value
        $id = $_GET['id'];

        //SElect DAtabase
        $db_select = mysqli_select_db($con, DB_NAME) or die();

        //Query to Get the Values from Database
        $sql = "SELECT * FROM task_lists WHERE acct_id = '$acct_id' AND id=$id";

        //Execute Query
        $res = mysqli_query($con, $sql);

        //CHekc whether the query executed successfully or not
        if($res==true)
        {
            //Get the Value from Database
            $row = mysqli_fetch_assoc($res); //Value is in array

            //printing $row array
            //print_r($row);

            //Create Individual Variable to save the data
            $list_name = $row['list_name'];
            $list_description = $row['list_description'];
        }
        else
        {
            //Go Back to Manage List Page
            header('location: ./manage-list.php');
        }
    }


    //Check whether the Update is Clicked or Not
    if(isset($_POST['submit']))
    {
        //echo "Button Clicked";

        //Get the Updated Values from our Form
        $list_name = $_POST['list_name'];
        $list_description = $_POST['list_description'];

        //SElect the Database
        $db_select2 = mysqli_select_db($con, DB_NAME);

        //QUERY to Update List
        $sql2 = "UPDATE task_lists SET
                list_name = '$list_name',
                list_description = '$list_description'
                WHERE acct_id = '$acct_id' AND id = '$id'";

        //Execute the Query
        $res2 = mysqli_query($con, $sql2);

        //Check whether the query executed successfully or not
        if($res2==true)
        {
            //Update Successful
            //SEt the Message
            $_SESSION['update'] = "List Updated Successfully";

            //Redirect to Manage List PAge
            header('location: ./manage-list.php');
        }
        else
        {
            //FAiled to Update
            //SEt Session Message
            $_SESSION['update_fail'] = "Failed to Update List";
            //Redirect to the Update List PAge
            header('location: ./update-list.php?id='.$id);
        }

    }
?>

<?=template_header('Task Mngr')?>

<div class="w3-content w3-mobile update">
    <h1>UPDATE TASK LIST</h1>
    <div class="w3-col s12 m12 l12 w3-camo-fade w3-margin w3-border w3-round w3-border-blue-grey w3-card-4">
        <div class="task-mngr">
            <a href="./manage-list.php">Manage Lists</a>
        </div>
        <br />

            <?php
                //Check whether the session is set or not
                if(isset($_SESSION['update_fail']))
                {
                    echo $_SESSION['update_fail'];
                    unset($_SESSION['update_fail']);
                }
            ?>

            <form method="POST" action="">

                <table class="tbl-half">
                    <tr>
                        <td>List Name: </td>
                        <td><input type="text" name="list_name" value="<?php echo $list_name; ?>" required="required" /></td>
                    </tr>

                    <tr>
                        <td>List Description: </td>
                        <td>
                            <textarea type="text" name="list_description"><?=$list_description; ?></textarea>
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
                            <a href="./manage-list.php" class="w3-button w3-orange w3-hover-amber">Cancel</a>
                        </div>
                    </div>
            </form>
        </div>
    </div>
<?php
    require_once('./require/footer.php');
?>
