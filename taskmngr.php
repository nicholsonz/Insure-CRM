<?php
    require_once('./functions.php');

// Home Page template below.
?>

<?=template_header('Task Mngr')?>

<div class="content read">
<div class="">
    
    <h1>TASK MANAGER</h1>
    
    
    <!-- Menu Starts Here -->
    <div class="">
    
        <a href="./taskmngr.php" class="task-mngr">Home</a>                
        <a href="./manage-list.php" class="task-mngr">Manage Lists</a>
    </div>
    <!-- Menu Ends Here -->
    
    <!-- Tasks Starts Here -->
    
    <p>
        <?php 
        
            if(isset($_SESSION['add']))
            {
                echo $_SESSION['add'];
                unset($_SESSION['add']);
            }
            
            if(isset($_SESSION['delete']))
            {
                echo $_SESSION['delete'];
                unset($_SESSION['delete']);
            }
            
            if(isset($_SESSION['update']))
            {
                echo $_SESSION['update'];
                unset($_SESSION['update']);
            }
            
            
            if(isset($_SESSION['delete_fail']))
            {
                echo $_SESSION['delete_fail'];
                unset($_SESSION['delete_fail']);
            }
        
        ?>
    </p>
    
    <div class="">
        
        <a href="./add-task.php" class="add-task">Add Task</a>
        
        <table class="w3-table w3-bordered">
         <thead>
            <tr>
                <th>S.N.</th>
                <th>Task Name</th>
                <th>Details</th>
                <th>Task List</th>
                <th>Priority</th>
                <th>Deadline</th>
                <th></th>
            </tr>
         </thead>
            <?php 
                
                //Select Database
                $db_select = mysqli_select_db($con, DB_NAME) or die();
                
                //Create SQL Query to Get DAta from Databse
                $sql = "SELECT *, tbll.list_name FROM tbl_tasks AS tblt
                        LEFT JOIN tbl_lists AS tbll ON tbll.list_id = tblt.list_id
                         ORDER BY deadline";
                
                //Execute Query
                $res = mysqli_query($con, $sql);
                
                //CHeck whether the query execueted o rnot
                if($res==true)
                {
                    //DIsplay the Tasks from DAtabase
                    $count_rows = mysqli_num_rows($res);
                    
                    //Create Serial Number Variable
                    $sn=1;
                    
                    //Check whether there is task on database or not
                    if($count_rows>0)
                    {
                        //Data is in Database
                        while($row=mysqli_fetch_assoc($res))
                        {
                            $task_id = $row['task_id'];
                            $task_name = $row['task_name'];
                            $descr = $row['task_description'];
                            $list_name = $row['list_name'];
                            $priority = $row['priority'];
                            $deadline = $row['deadline'];
                            ?>
                            <tr>
                                <td><?php echo $sn++; ?></td>
                                <td><?php echo $task_name; ?></td>
                                <td><?php echo $descr; ?></td>
                                <td><?php echo $list_name; ?></td>
                                <td><?php echo $priority; ?></td>
                                <td><?php echo $deadline; ?></td>
                                <td class="actions">
                                    <a href="./update-task.php?task_id=<?php echo $task_id; ?>" class="edit"><i class="fas fa-edit fa-xs"></i></a>                                    
                                    <a href="./delete-task.php?task_id=<?php echo $task_id; ?>" class="trash"><i class="fas fa-trash-alt fa-xs"></i></a>
                                
                                </td>
                            </tr>
                            <?php
                        }
                    }
                    else
                    {
                        //No data in Database
                        ?>
                        
                        <tr>
                            <td colspan="5">No Task Added Yet.</td>
                        </tr>
                        
                        <?php
                    }
                }
            
            ?>
            
            
        
        </table>
    
    </div>
    
    <!-- Tasks Ends Here -->
    </div>
</div>

<?=template_footer()?>