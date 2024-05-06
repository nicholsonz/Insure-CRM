<?php
require_once('./functions.php');

// Connect to MySQL database
$pdo = pdo_connect_mysql();
// Get the page via GET request (URL param: page), if non exists default the page to 1
$page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int)$_GET['page'] : 1;
// Number of records to show on each page
$records_per_page = 12;

// Prepare the SQL statement and get records from our clients table, LIMIT will determine the page
$stmt = $pdo->prepare('SELECT * FROM clients ORDER BY name LIMIT :current_page, :record_per_page');
$stmt->bindValue(':current_page', ($page-1)*$records_per_page, PDO::PARAM_INT);
$stmt->bindValue(':record_per_page', $records_per_page, PDO::PARAM_INT);
$stmt->execute();
// Fetch the records so we can display them in our template.
$clients = $stmt->fetchAll(PDO::FETCH_ASSOC);
// Get the total number of clients, this is so we can determine whether there should be a next and previous button
$num_clients = $pdo->query('SELECT COUNT(*) FROM clients')->fetchColumn();


?>

<?=template_header('Clients')?>

<div class="content read">
	<h1>CLIENTS</h1>
	<a href="./createclient.php" class="create-contact">Create Client</a>
    <div class="w3-right w3-padding">      
        <input id="tableSrch" type="text" placeholder="Filter..">
    </div> 
	<table class="w3-table w3-hoverable" id="srtTable">
        <thead>
            <tr>
                <th>Name</th>
                <th><a href="javascript:SortTable(1,'D','ymd');">Birth Date <i class="fa fa-sort"></a></th>
                <th>Primary Phone</th>
                <th>Policy</th>
                <th><a href="javascript:SortTable(4,'T');">Insurer <i class="fa fa-sort"></a></th>
                <th>App Status</th>
                <th><a href="javascript:SortTable(6,'D','ymd h:m:s');">Created <i class="fa fa-sort"></a></th>
                <th></th>
            </tr>
        </thead>
        <tbody id="tblSrch">
            <?php foreach ($clients as $client): ?>
            <tr>
                <td><a href="./view.php?id=<?=$client['id']; ?>" target="_blank"><?=$client['name']?></a></td>
                <td><?=$client['birthdate']?></td>
                <td><?=$client['phone']?></td>
                <td><?=$client['policy']?></td>
                <td><?=$client['insurer']?></td>
                <td><?=$client['appstatus']?></td>
                <td><?=$client['created']?></td>
                <td class="actions">       
                    <a href="add-task.php?name=<?=$client['name']?>&&type=<?="Client";?>" class="task"><i class="fas fa-tasks fa-xs"></i></a>
                    <a href="view.php?id=<?=$client['id']?>" class="view" target="_blank"><i class="fas fa-eye fa-xs"></i></a>
                    <a href="updateclient.php?id=<?=$client['id']?>" class="edit"><i class="fas fa-edit fa-xs"></i></a>                    
                    <a href="delete.php?name=<?=$client['name']?>" class="trash"><i class="fas fa-trash-alt fa-xs"></i></a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
            </div>
	<div class="center pagination">
		<?php if ($page > 1): ?>
		<a href="clients.php?page=<?=$page-1?>"><i class="fas fa-angle-double-left fa-lg"></i></a>
		<?php endif; ?>
		<?php if ($page*$records_per_page < $num_clients): ?>
		<a href="clients.php?page=<?=$page+1?>"><i class="fas fa-angle-double-right fa-lg"></i></a>
		<?php endif; ?>
	</div>
</div>

<?=template_footer()?>
