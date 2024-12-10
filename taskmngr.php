<?php
    require_once('./require/header.php');


// Get the total number of records.
$total_pages = $con->query("SELECT COUNT(*) FROM tasks WHERE acct_id = '$acct_id'")->fetch_row()[0];

// Check if the page number is specified and check if it's a number, if not return the default page number which is 1.
$page = isset($_GET['page']) && is_numeric($_GET['page']) ? $_GET['page'] : 1;

// Number of results to show on each page.
$records_per_page = 10;


if ($stmt = $con->prepare("SELECT task_id, task_name, name, priority, list_name, DATE_FORMAT(deadline, '%b %d, %y %h:%i %p') AS deadline, type, tl.list_name
                           FROM tasks
                           LEFT JOIN task_lists AS tl ON tasks.list_id = tl.list_id
                           WHERE tasks.acct_id = '$acct_id'
                           ORDER BY tasks.deadline ASC -- LIMIT ?,?")) {
	// Calculate the page to get the results we need from our table.
	// $calc_page = ($page - 1) * $records_per_page;
	// $stmt->bind_param('ii', $calc_page, $records_per_page);
	$stmt->execute();
	// Get the results...
	$result = $stmt->get_result();
	$stmt->close();
}
// Home Page template below.
?>

<?=template_header('Task Mngr')?>

<div class="w3-content read">

    <h1>TASK MANAGER</h1>
    <hr></hr>
    <div class="">
    <div class="task-mngr">
        <a href="./manage-list.php">Manage Lists</a>
    </div>
     <div class="">
    </div>
        <a href="./add-task.php" class="add-task">Add Task</a>
      <div id="taskTable">
        <div class="table-viewer tableFixHead">
        <table class="w3-table w3-hoverable" id="srtTable">
         <thead>
            <tr>
                <!-- <th>S.N.</th> -->
                <th><a href="javascript:SortTable(0,'T');">Task <i class="fa fa-sort"></th>
                <th><a href="javascript:SortTable(1,'T');">Name <i class="fa fa-sort"></th>
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
                <td><a href="./update-task.php?task_id=<?= $row['task_id'] ?>"><?= $row['task_name'] ?></a></td>
                <?php if($row['type'] == 'Lead'): ?>
                    <td><a href="./updatelead.php?name=<?= $row['name']; ?>"><?= $row['name'] ?></a></td>
                <?php else: ?>
                    <td><a href="./updateclient.php?name=<?= $row['name']; ?>"><?= $row['name'] ?></a></td>
                <?php endif; ?>
                <td><?= $row['details'] ?></td>
                <td><?= $row['list_name'] ?></td>
                <td><?= $row['priority'] ?></td>
                <td><?= $row['deadline'] ?></td>
                <td><?= $row['type'] ?></td>
                <td class="actions">
                    <a href="./update-task.php?task_id=<?= $row['task_id'] ?>" class="w3-btn edit"><i class="fas fa-edit fa-xs"></i></a>
                    <button type="button" value="<?=$row['task_id'];?>" class="w3-btn delTask trash"><i class="fas fa-trash fa-xs"></i></button>

                </td>
            </tr>
            <?php endwhile ?>

        </tbody>

        </table>
        </div>
      </div>
<!-- Pagination
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
End Pagination-->
    </div>
</div>

<?php require_once('./require/footer.php');?>
