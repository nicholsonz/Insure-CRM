<?php
    require_once('./require/header.php');
    

// Get the total number of records from our table "students".
$total_pages = $con->query('SELECT COUNT(*) FROM tasks')->fetch_row()[0];

// Check if the page number is specified and check if it's a number, if not return the default page number which is 1.
$page = isset($_GET['page']) && is_numeric($_GET['page']) ? $_GET['page'] : 1;

// Number of results to show on each page.
$records_per_page = 10;


if ($stmt = $con->prepare('SELECT * FROM tasks 
                           LEFT JOIN task_lists AS tl ON tasks.list_id = tl.list_id
                           ORDER BY tasks.deadline ASC LIMIT ?,?')) {
	// Calculate the page to get the results we need from our table.
	$calc_page = ($page - 1) * $records_per_page;
	$stmt->bind_param('ii', $calc_page, $records_per_page);
	$stmt->execute(); 
	// Get the results...
	$result = $stmt->get_result();
	$stmt->close();
}
// Home Page template below.
?>

<?=template_header('Task Mngr')?>

<div class="content read">
    
    <h1>TASK MANAGER</h1>    
    <!-- Menu Starts Here -->
    <div class="task-mngr">
               
        <a href="./manage-list.php">Manage Lists</a>
    </div>
    <!-- Menu Ends Here -->
    
    <!-- Tasks Starts Here -->
       
    <div class="">
     <div class="">
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
    </div>
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
                <th><a href="javascript:SortTable(6,'D','dmyy');">Deadline <i class="fa fa-sort"></a></th>
                <th><a href="javascript:SortTable(7,'T');">Type <i class="fa fa-sort"></a></th>
                <th></th>
            </tr>
         </thead>
        <tbody id="tblSrch">
            <?php while ($row = $result->FETCH_ASSOC()): ?>
            <tr>
                <td><?= $row['task_name'] ?></td>
                <?php if($row['type'] == 'Lead'): ?>
                    <td><a href="./updatelead.php?name=<?= $row['name']; ?>"><?= $row['name'] ?></a></td>
                <?php else: ?>
                    <td><a href="./updateclient.php?name=<?= $row['name']; ?>"><?= $row['name'] ?></a></td>
                <?php endif; ?>
                <td><?= $row['task_description'] ?></td>
                <td><?= $row['list_name'] ?></td>
                <td><?= $row['priority'] ?></td>
                <td><?= $row['deadline'] ?></td>
                <td><?= $row['type'] ?></td>
                <td class="actions">
                    <a href="./update-task.php?task_id=<?= $row['task_id'] ?>" class="edit"><i class="fas fa-edit fa-xs"></i></a>                                    
                    <a href="./delete-task.php?task_id=<?= $row['task_id'] ?>" class="trash"><i class="fas fa-trash-alt fa-xs"></i></a>
                
                </td>
            </tr>
            <?php endwhile ?>
            
        </tbody>
        
        </table>
    <?php if (ceil($total_pages / $records_per_page) > 0): ?>
        <ul class="pagination">
            <?php if ($page > 1): ?>
            <li class="prev"><a href="taskmngr.php?page=<?php echo $page-1 ?>">Prev</a></li>
            <?php endif; ?>

            <?php if ($page > 3): ?>
            <li class="start"><a href="taskmngr.php?page=1">1</a></li>
            <li class="dots">...</li>
            <?php endif; ?>

            <?php if ($page-2 > 0): ?><li class="page"><a href="taskmngr.php?page=<?php echo $page-2 ?>"><?php echo $page-2 ?></a></li><?php endif; ?>
            <?php if ($page-1 > 0): ?><li class="page"><a href="taskmngr.php?page=<?php echo $page-1 ?>"><?php echo $page-1 ?></a></li><?php endif; ?>

            <li class="currentpage"><a href="taskmngr.php?page=<?php echo $page ?>"><?php echo $page ?></a></li>

            <?php if ($page+1 < ceil($total_pages / $records_per_page)+1): ?><li class="page"><a href="taskmngr.php?page=<?php echo $page+1 ?>"><?php echo $page+1 ?></a></li><?php endif; ?>
            <?php if ($page+2 < ceil($total_pages / $records_per_page)+1): ?><li class="page"><a href="taskmngr.php?page=<?php echo $page+2 ?>"><?php echo $page+2 ?></a></li><?php endif; ?>

            <?php if ($page < ceil($total_pages / $records_per_page)-2): ?>
            <li class="dots">...</li>
            <li class="end"><a href="taskmngr.php?page=<?php echo ceil($total_pages / $records_per_page) ?>"><?php echo ceil($total_pages / $records_per_page) ?></a></li>
            <?php endif; ?>

            <?php if ($page < ceil($total_pages / $records_per_page)): ?>
            <li class="next"><a href="taskmngr.php?page=<?php echo $page+1 ?>">Next</a></li>
            <?php endif; ?>
        </ul>
    <?php endif; ?>
    
    <!-- Tasks Ends Here -->
    </div>
</div>

<?php require_once('./require/footer.php');?>