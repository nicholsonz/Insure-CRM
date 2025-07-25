<?php
require_once('./require/header.php');

// Get the total number of records from our table "students".
$total_pages = $con->query("SELECT COUNT(*) FROM leads WHERE acct_id = '$acct_id'")->fetch_row()[0];

// Check if the page number is specified and check if it's a number, if not return the default page number which is 1.
$page = isset($_GET['page']) && is_numeric($_GET['page']) ? $_GET['page'] : 1;

// Number of results to show on each page.
$records_per_page = 10;

$stmt = $con->prepare("SELECT * FROM leads WHERE acct_id = ? ORDER BY created DESC -- LIMIT ?,?");
// Calculate the page to get the results we need from our table.
// $calc_page = ($page - 1) * $records_per_page;
// $stmt->bind_param('ii', $calc_page, $records_per_page);
$stmt->execute([$acct_id]);
// Get the results...
$result = $stmt->get_result();
$stmt->close();
    
?>

<?=template_header('Leads')?>

<div class="w3-content">
	<h1>LEADS</h1>
	<div class="w3-col s12 m12 l12 w3-camo-fade w3-margin w3-border w3-round w3-border-blue-grey w3-pannel w3-card-4">
    	<a href="createlead.php" class="create-contact">Create Lead</a>
    	<a href="impleads.php" class="create-contact">Import Leads</a>        
            <div class="w3-row"> 
                <div class="w3-left">           
                    <button type="button" value="" id="delete" class="w3-button w3-small w3-round w3-border w3-red w3-text-black"> DELETE</button>
                </div>
                <div class="w3-right w3-padding">
                    <input id="tableSrch" type="text" placeholder="Filter..">
                </div>
            </div>
        <div class="table-viewer tableFixHead" id="leadTable">
        	<table class="w3-table w3-hoverable" id="srtTable">
                <thead>
                    <tr>
                      <th><input type="checkbox" id="select_all"></th>
                      <th><a href="javascript:SortTable(1,'T');">Name <i class="fa fa-sort"></a></th>
                      <th><a href="javascript:SortTable(2,'D','ymd h:m:s');">Birthdate <i class="fa fa-sort"></a></th>
                      <th>Primary Phone</th>
                      <th>Zip Code</th>
                      <th>Email</th>
                      <th><a href="javascript:SortTable(6,'D','mdy');">Created <i class="fa fa-sort"></a></th>
                      <th></th>
                    </tr>
                </thead>
                <tbody id="tblSrch">
                    <?php while ($row = $result->FETCH_ASSOC()): ?>
        	    <tr>
                  <td><input type="checkbox" class="name" value="<?=$row['id']?>"></td>
                  <td><a href="./updatelead.php?name=<?=$row['name']?>"><?=$row['name']?></a></td>
                  <td><?=$row['birthdate']?></td>
                  <td><?=$row['phone']?></td>
                  <td><?=$row['zip']?></td>
                  <td><?=$row['email']?></td>
                  <td><?=date("m-d-Y", strtotime($row['created']));?></td>
                  <td class="actions">
                      <a href="add-task.php?name=<?=$row['name']?>&&type=<?="Lead";?>" class="task"><i class="fas fa-tasks fa-xs"></i></a>
                      <a href="convertlead.php?name=<?=$row['name']?>" class="convert"><i class="fas fa-archive fa-xs"></i></a>
                      <a href="updatelead.php?name=<?=$row['name']?>" class="edit"><i class="fas fa-edit fa-xs"></i></a>
                      <button type="button" value="<?=$row['name'];?>" class="w3-btn delLead trash"><i class="fas fa-trash-alt fa-xs"></i></button>
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
