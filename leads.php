<?php
    require_once('./require/header.php');


// Get the total number of records from our table "students".
$total_pages = $con->query("SELECT COUNT(*) FROM leads WHERE acct_id = '$acct_id'")->fetch_row()[0];

// Check if the page number is specified and check if it's a number, if not return the default page number which is 1.
$page = isset($_GET['page']) && is_numeric($_GET['page']) ? $_GET['page'] : 1;

// Number of results to show on each page.
$records_per_page = 10;


if ($stmt = $con->prepare("SELECT * FROM leads  WHERE acct_id = '$acct_id' ORDER BY created DESC -- LIMIT ?,?")) {
	// Calculate the page to get the results we need from our table.
	// $calc_page = ($page - 1) * $records_per_page;
	// $stmt->bind_param('ii', $calc_page, $records_per_page);
	$stmt->execute(); 
	// Get the results...
	$result = $stmt->get_result();
	$stmt->close();
}
?>

<?=template_header('Leads')?>

<div class="content read">
	<h1>LEADS</h1>
    <div class="">
	<a href="createlead.php" class="create-contact">Create Lead</a>
	<a href="impleads.php" class="create-contact">Import Leads</a>
    <div class="w3-right w3-padding">      
         <input id="tableSrch" type="text" placeholder="Filter..">
    </div> 
    <div class="table-viewer tableFixHead">
	<table class="w3-table w3-hoverable" id="srtTable">
        <thead>
            <tr>
                <th>Name</th>
                <th><a href="javascript:SortTable(1,'D','ymd h:m:s');">Birthdate <i class="fa fa-sort"></th>
                <th>Primary Phone</th>
                <th>Email</th>
                <th>Notes</th>
                <th><a href="javascript:SortTable(5,'D','ymd h:m:s');">Created <i class="fa fa-sort"></th>
                <th></th>
            </tr>
        </thead>
        <tbody id="tblSrch">
            <?php while ($row = $result->FETCH_ASSOC()): ?>
	    <tr>
                <td><a href="./viewLds.php?name=<?=$row['name']; ?>" target="_blank"><?=$row['name']?></td>
                <td><?=$row['birthdate']?></td>
                <td><?=$row['phone']?></td>
                <td><?=$row['email']?></td>
                <td><?=$row['notes']?></td>
                <td><?=$row['created']?></td>
                <td class="actions">          
                    <a href="add-task.php?name=<?=$row['name']?>&&type=<?="Lead";?>" class="task"><i class="fas fa-tasks fa-xs"></i></a>
                    <a href="convertlead.php?name=<?=$row['name']?>" class="convert"><i class="fas fa-archive fa-xs"></i></a>
                    <a href="updatelead.php?name=<?=$row['name']?>" class="edit"><i class="fas fa-edit fa-xs"></i></a>                    
                    <a href="delete-lead.php?name=<?=$row['name']?>" class="trash"><i class="fas fa-trash-alt fa-xs"></i></a>
                   
                </td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>
<!-- Pagination
    <?php if (ceil($total_pages / $records_per_page) > 0): ?>
        <ul class="pagination">
            <?php if ($page > 1): ?>
            <li class="prev"><a href="leads.php?page=<?php echo $page-1 ?>">Prev</a></li>
            <?php endif; ?>

            <?php if ($page > 3): ?>
            <li class="start"><a href="leads.php?page=1">1</a></li>
            <li class="dots">...</li>
            <?php endif; ?>

            <?php if ($page-2 > 0): ?><li class="page"><a href="leads.php?page=<?php echo $page-2 ?>"><?php echo $page-2 ?></a></li><?php endif; ?>
            <?php if ($page-1 > 0): ?><li class="page"><a href="leads.php?page=<?php echo $page-1 ?>"><?php echo $page-1 ?></a></li><?php endif; ?>

            <li class="currentpage"><a href="leads.php?page=<?php echo $page ?>"><?php echo $page ?></a></li>

            <?php if ($page+1 < ceil($total_pages / $records_per_page)+1): ?><li class="page"><a href="leads.php?page=<?php echo $page+1 ?>"><?php echo $page+1 ?></a></li><?php endif; ?>
            <?php if ($page+2 < ceil($total_pages / $records_per_page)+1): ?><li class="page"><a href="leads.php?page=<?php echo $page+2 ?>"><?php echo $page+2 ?></a></li><?php endif; ?>

            <?php if ($page < ceil($total_pages / $records_per_page)-2): ?>
            <li class="dots">...</li>
            <li class="end"><a href="leads.php?page=<?php echo ceil($total_pages / $records_per_page) ?>"><?php echo ceil($total_pages / $records_per_page) ?></a></li>
            <?php endif; ?>

            <?php if ($page < ceil($total_pages / $records_per_page)): ?>
            <li class="next"><a href="leads.php?page=<?php echo $page+1 ?>">Next</a></li>
            <?php endif; ?>
        </ul>
    <?php endif; ?>
End Pagination -->
    </div>
</div>

<?php require_once('./require/footer.php');?>
