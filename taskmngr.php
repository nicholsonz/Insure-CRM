<?php
    require_once('./functions.php');

// Home Page template below.
?>

<?=template_header('Task Mngr')?>

<div class="content read">
    
    <h1>TASK MANAGER</h1>    
    <!-- Menu Starts Here -->
    <div class="">
    
        <a href="./taskmngr.php" class="task-mngr">Tasks</a>                
        <a href="./manage-list.php" class="task-mngr">Manage Lists</a>
    </div>
    <!-- Menu Ends Here -->
    
    <!-- Tasks Starts Here -->
   
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
   
    
    <div class="">
        
        <a href="./add-task.php" class="add-task">Add Task</a>
        
        <table class="w3-table w3-hoverable" id="srtTable">
         <thead>
            <tr>
                <!-- <th>S.N.</th> -->
                <th>Task Name</th>
                <th>Name</th>
                <th>Details</th>
                <th><a href="javascript:SortTable(4,'T');">Task List <i class="fa fa-sort"></a></th>
                <th>Priority</th>
                <th>Deadline</th>
                <th><a href="javascript:SortTable(7,'T');">Type <i class="fa fa-sort"></a></th>
                <th></th>
            </tr>
         </thead>
        <tbody id="tblSrch">
            <?php 
                
                //Select Database
                $db_select = mysqli_select_db($con, DB_NAME) or die();
                
                //Create SQL Query to Get DAta from Databse
                $sql = "SELECT *, tl.list_name FROM tasks AS t
                        LEFT JOIN task_lists AS tl ON tl.list_id = t.list_id
                        WHERE t.acct_id = '$acct_id' 
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
                            $name = $row['name'];
                            $descr = $row['task_description'];
                            $list_name = $row['list_name'];
                            $priority = $row['priority'];
                            $deadline = $row['deadline'];
                            $type = $row['type'];
                            ?>
                            <tr>
                                <!-- <td><?php echo $sn++; ?></td> -->
                                <td><?php echo $task_name; ?></td>
                                <td><?php echo $name; ?></td>
                                <td><?php echo $descr; ?></td>
                                <td><?php echo $list_name; ?></td>
                                <td><?php echo $priority; ?></td>
                                <td><?php echo $deadline; ?></td>
                                <td><?php echo $type; ?></td>
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
            
        </tbody>
        
        </table>
    
    <!-- Tasks Ends Here -->
    </div>
</div>

<?php require_once('./footer.php');?>