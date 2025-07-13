<?php
    require_once('./require/header.php');

// Get the total number of records from our table "students".
$total_pages = $con->query("SELECT COUNT(*) FROM task_lists WHERE acct_id = '$acct_id'")->fetch_row()[0];

// Check if the page number is specified and check if it's a number, if not return the default page number which is 1.
$page = isset($_GET['page']) && is_numeric($_GET['page']) ? $_GET['page'] : 1;

// Number of results to show on each page.
$records_per_page = 8;


if ($stmt = $con->prepare("SELECT * FROM task_lists WHERE acct_id = '$acct_id' ORDER BY list_name -- LIMIT ?,?")) {
	// Calculate the page to get the results we need from our table.
	// $calc_page = ($page - 1) * $records_per_page;
	// $stmt->bind_param('ii', $calc_page, $records_per_page);
	$stmt->execute();
	// Get the results...
	$result = $stmt->get_result();
	$stmt->close();
}

?>

<?=template_header('Task Mngr')?>

    <div class="w3-content">

        <h1>TASK LIST MANAGER</h1>
  <div class="w3-col s12 m12 l12 w3-camo-fade w3-margin w3-border w3-round w3-border-blue-grey w3-card-4">
        <div class="task-mngr">
            <a href="./taskmngr.php">Manage Tasks</a>
        </div>
        <div class="">

        <!-- Table to display lists starts here -->
        <div class="">
            <a href="./add-list.php" class="add-task">Add List</a>
            <div class="table-viewer tableFixHead" id="listTable">
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
                          <a href="./update-list.php?list_id=<?= $row['list_id'] ?>" class="w3-btn edit"><i class="fas fa-edit fa-xs"></i></a>
                          <button type="button" value="<?=$row['list_id'];?>" class="w3-btn delList trash"><i class="fas fa-trash-alt fa-xs"></i></button>

                        </td>
                    </tr>
                <?php endwhile ?>
             </tbody>
            </table>
        </div>
<!-- Pagination
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
End Pagination -->
        </div>
        </div>

<?php
    require_once('./require/footer.php');
?>
