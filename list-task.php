<?php 
    require_once('./require/header.php');
    

    //Get the listid from URL
    
    $list_id_url = $_GET['list_id'];
?>
<?=template_header('Task List')?>

    <div class="content">        
        <div class="">
        
        <h1>TASK MANAGER</h1>
        
        <!-- Menu Starts Here -->
        <div class="w3-row w3-padding w3-margin">
          <div class="w3-col l2 m2 s12">
            <a href="./taskmngr.php">Home</a>
          </div>
          <div clas="w3-col l2 m2 s12">
            <?php 
                
                //Comment Displaying Lists From Database in ourMenu
                $conn2 = mysqli_connect(LOCALHOST, DB_USERNAME, DB_PASSWORD) or die();
                
                //SELECT DATABASE
                $db_select2 = mysqli_select_db($conn2, DB_NAME) or die();
                
                //Query to Get the Lists from database
                $sql2 = "SELECT * FROM tbl_lists";
                
                //Execute Query
                $res2 = mysqli_query($conn2, $sql2);
                
                //CHeck whether the query executed or not
                if($res2==true)
                {
                    //Display the lists in menu
                    while($row2=mysqli_fetch_assoc($res2))
                    {
                        $list_id = $row2['list_id'];
                        $list_name = $row2['list_name'];
                        ?>
                        
                        <a href="./list-task.php?list_id=<?php echo $list_id; ?>"><?php echo $list_name; ?></a>
                        
                        <?php
                        
                    }
                }
                
            ?>

          </div>
          <div class="w3-col l2 m2 s12">            
            <a href="./manage-list.php">Manage Lists</a>

          </div>          
        </div>
        <!-- Menu Ends Here -->
        
        
        <div class="all-task">
        
            <a class="btn-primary" href="./add-task.php">Add Task</a>
            
            
            <table class="w3-table w3-bordered">
            
                <tr>
                    <th>S.N.</th>
                    <th>Task Name</th>
                    <th>Priority</th>
                    <th>Deadline</th>
                    <th>Actions</th>
                </tr>
                
                <?php 
                
                    $conn = mysqli_connect(LOCALHOST, DB_USERNAME, DB_PASSWORD) or die();
                    
                    $db_select = mysqli_select_db($conn, DB_NAME) or die();
                    
                    //SQL QUERY to display tasks by list selected
                    $sql = "SELECT * FROM tbl_tasks WHERE list_id=$list_id_url";
                    
                    //Execute Query
                    $res = mysqli_query($conn, $sql);
                    
                    if($res==true)
                    {
                        //Display the tasks based on list
                        //Count the Rows
                        $count_rows = mysqli_num_rows($res);
                        
                        if($count_rows>0)
                        {
                            //We have tasks on this list
                            while($row=mysqli_fetch_assoc($res))
                            {
                                $task_id = $row['task_id'];
                                $task_name = $row['task_name'];
                                $priority = $row['priority'];
                                $deadline = $row['deadline'];
                                ?>
                                
                                <tr>
                                    <td>1. </td>
                                    <td><?php echo $task_name; ?></td>
                                    <td><?php echo $priority; ?></td>
                                    <td><?php echo $deadline; ?></td>
                                    <td>
                                        <a href="./update-task.php?task_id=<?php echo $task_id; ?>">Update </a>
                                    
                                    <a href="./delete-task.php?task_id=<?php echo $task_id; ?>">Delete</a>
                                    </td>
                                </tr>
                                
                                <?php
                            }
                        }
                        else
                        {
                            //NO Tasks on this list
                            ?>
                            
                            <tr>
                                <td colspan="5">No Tasks added on this list.</td>
                            </tr>
                            
                            <?php
                        }
                    }
                ?>
                
                
            
            </table>
        
        </div>
        
        </div>

 <?php 
    require_once('./require/footer.php') ;
?>      






























