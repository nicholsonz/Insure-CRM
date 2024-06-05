<?php 
    require_once('./require/header.php');
    
// Get the total number of records from our table "students".
$total_pages = $con->query('SELECT COUNT(*) FROM task_lists')->fetch_row()[0];

// Check if the page number is specified and check if it's a number, if not return the default page number which is 1.
$page = isset($_GET['page']) && is_numeric($_GET['page']) ? $_GET['page'] : 1;

// Number of results to show on each page.
$records_per_page = 8;


if ($stmt = $con->prepare('SELECT * FROM task_lists ORDER BY list_name LIMIT ?,?')) {
	// Calculate the page to get the results we need from our table.
	$calc_page = ($page - 1) * $records_per_page;
	$stmt->bind_param('ii', $calc_page, $records_per_page);
	$stmt->execute(); 
	// Get the results...
	$result = $stmt->get_result();
	$stmt->close();
}

?>

<?=template_header('Task Mngr')?>
        
    <div class="content">
        
        <h1>TASK LIST MANAGER</h1>
    <!-- Menu Starts Here -->
    <div class="task-mngr">
            
        <a href="./taskmngr.php">Tasks</a>              
    </div>
        <!-- Menu Ends Here -->
            <?php 
            
                //Check if the session is set
                if(isset($_SESSION['add']))
                {
                    //display message
                    echo $_SESSION['add'];
                    //REmove the message after displaying one time
                    unset($_SESSION['add']);
                }
                
                //Check the session for Delete
                
                if(isset($_SESSION['delete']))
                {
                    echo $_SESSION['delete'];
                    unset($_SESSION['delete']);
                }
                
                //Check Session Message for Update
                if(isset($_SESSION['update']))
                {
                    echo $_SESSION['update'];
                    unset($_SESSION['update']);
                }
                
                //Check for Delete Fail
                if(isset($_SESSION['delete_fail']))
                {
                    echo $_SESSION['delete_fail'];
                    unset($_SESSION['delete_fail']);
                }
            
            ?>
             
        <!-- Table to display lists starts here -->
        <div class="read">
            
            <a href="./add-list.php" class="add-task">Add List</a>
            
            <table class="w3-table w3-hoverable">
             <thead>
                <tr>
                    <th>List Name</th>
                    <th>Description</th>
                    <th></th>
                </tr>
             </thead>                             
             <tbody id="tblSrch">
                <?php while ($row = $result->FETCH_ASSOC()): ?>                  
                    <tr>
                        <td><a href="./update-list.php?list_id=<?= $row['list_id']; ?>"><?= $row['list_name'] ?></a></td>
                        <td><?= $row['list_description'] ?></td>
                        <td class="actions">
                            <a href="./update-list.php?list_id=<?= $row['list_id'] ?>" class="edit"><i class="fas fa-edit fa-xs"></i></a>   
                            <a href="./delete-list.php?list_id=<?= $row['list_id'] ?>" class="trash"><i class="fas fa-trash-alt fa-xs"></i></a>
                        </td>
                    </tr>
                <?php endwhile ?>
             </tbody>                                                 
            </table>
            <?php if (ceil($total_pages / $records_per_page) > 0): ?>
                <ul class="pagination">
                    <?php if ($page > 1): ?>
                    <li class="prev"><a href="manage-list.php?page=<?php echo $page-1 ?>">Prev</a></li>
                    <?php endif; ?>

                    <?php if ($page > 3): ?>
                    <li class="start"><a href="manage-list.php?page=1">1</a></li>
                    <li class="dots">...</li>
                    <?php endif; ?>

                    <?php if ($page-2 > 0): ?><li class="page"><a href="manage-list.php?page=<?php echo $page-2 ?>"><?php echo $page-2 ?></a></li><?php endif; ?>
                    <?php if ($page-1 > 0): ?><li class="page"><a href="manage-list.php?page=<?php echo $page-1 ?>"><?php echo $page-1 ?></a></li><?php endif; ?>

                    <li class="currentpage"><a href="manage-list.php?page=<?php echo $page ?>"><?php echo $page ?></a></li>

                    <?php if ($page+1 < ceil($total_pages / $records_per_page)+1): ?><li class="page"><a href="manage-list.php?page=<?php echo $page+1 ?>"><?php echo $page+1 ?></a></li><?php endif; ?>
                    <?php if ($page+2 < ceil($total_pages / $records_per_page)+1): ?><li class="page"><a href="manage-list.php?page=<?php echo $page+2 ?>"><?php echo $page+2 ?></a></li><?php endif; ?>

                    <?php if ($page < ceil($total_pages / $records_per_page)-2): ?>
                    <li class="dots">...</li>
                    <li class="end"><a href="manage-list.php?page=<?php echo ceil($total_pages / $records_per_page) ?>"><?php echo ceil($total_pages / $records_per_page) ?></a></li>
                    <?php endif; ?>

                    <?php if ($page < ceil($total_pages / $records_per_page)): ?>
                    <li class="next"><a href="manage-list.php?page=<?php echo $page+1 ?>">Next</a></li>
                    <?php endif; ?>
                </ul>
            <?php endif; ?>
        </div>
        <!-- Table to display lists ends here -->
        </div>

<?php
    require_once('./require/footer.php');
?>