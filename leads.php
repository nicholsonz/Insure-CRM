<?php
    require_once('./functions.php');

// Connect to MySQL database
$pdo = pdo_connect_mysql();
// Get the page via GET request (URL param: page), if non exists default the page to 1
$page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int)$_GET['page'] : 1;
// Number of records to show on each page
$records_per_page = 12;

// Prepare the SQL statement and get records from our leads table, LIMIT will determine the page
$stmt = $pdo->prepare("SELECT * FROM leads WHERE acct_id = '$acct_id' ORDER BY created DESC LIMIT :current_page, :record_per_page");
$stmt->bindValue(':current_page', ($page-1)*$records_per_page, PDO::PARAM_INT);
$stmt->bindValue(':record_per_page', $records_per_page, PDO::PARAM_INT);
$stmt->execute();
// Fetch the records so we can display them in our template.
$leads = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Get the total number of leads, this is so we can determine whether there should be a next and previous button
$num_leads = $pdo->query('SELECT COUNT(*) FROM leads')->fetchColumn();
?>

<?=template_header('Leads')?>

<div class="content read">
	<h1>LEADS</h1>
	<a href="createlead.php" class="create-contact">Create Lead</a>
	<a href="impleads.php" class="create-contact">Import Leads</a>
    <div class="w3-right w3-padding">      
         <input id="tableSrch" type="text" placeholder="Filter..">
    </div> 
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
            <?php foreach ($leads as $lead): ?>
	    <tr>
                <td><a href="./updatelead.php?name=<?=$lead['name']; ?>"><?=$lead['name']?></td>
                <td><?=$lead['birthdate']?></td>
                <td><?=$lead['phone']?></td>
                <td><?=$lead['email']?></td>
                <td><?=$lead['notes']?></td>
                <td><?=$lead['created']?></td>
                <td class="actions">          
                    <a href="add-task.php?name=<?=$lead['name']?>&&type=<?="Lead";?>" class="task"><i class="fas fa-tasks fa-xs"></i></a>
                    <a href="convertlead.php?name=<?=$lead['name']?>" class="convert"><i class="fas fa-archive fa-xs"></i></a>
                    <a href="updatelead.php?name=<?=$lead['name']?>" class="edit"><i class="fas fa-edit fa-xs"></i></a>                    
                    <a href="deletelead.php?name=<?=$lead['name']?>" class="trash"><i class="fas fa-trash-alt fa-xs"></i></a>
                   
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
	<div class="center pagination">
		<?php if ($page > 1): ?>
		<a href="leads.php?page=<?=$page-1?>"><i class="fas fa-angle-double-left fa-lg"></i></a>
		<?php endif; ?>
		<?php if ($page*$records_per_page < $num_leads): ?>
		<a href="leads.php?page=<?=$page+1?>"><i class="fas fa-angle-double-right fa-lg"></i></a>
		<?php endif; ?>
	</div>
</div>
<?=template_footer()?>
