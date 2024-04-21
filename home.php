<?php
    require_once('./functions.php');

// Home Page template below.
?>

<?=template_header('Home')?>

<div class="content w3-mobile">
 <h1><?php echo date('M d, Y'); ?></h1>
   <div class="w3-col s12 m5 l5 w3-margin">
    <div class="read">
     <h2>Tasks</h2>
     <table class="w3-table w3-hoverable">     
	  <thead>   
		<tr>
		<th>#</th>
		<th>Task</th>
		<th>Lead</th>
		<th>Priority</th>
		<th>Deadline</th>
		</tr>
     </thead>
		<?php 
			
		//Select Database
		$db_select = mysqli_select_db($con, DB_NAME) or die();
				
		//Create SQL Query to Get DAta from Databse
		$sql = "SELECT task_id, task_name, lead_name, priority, list_name, DATE_FORMAT(deadline, '%m-%d-%Y') AS deadline, tbll.list_name 
				FROM tbl_tasks AS tblt
				LEFT JOIN tbl_lists AS tbll ON tblt.list_id = tbll.list_id
				ORDER BY deadline";
		

		//Execute Query
		$res = mysqli_query($con, $sql);
				
		//CHeck whether the query execueted o rnot
			if($res==true)
			{
			//DIsplay the Tasks from DAtabase
			//Dount the Tasks on Database first
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
				$lead_name = $row['lead_name'];
				$priority = $row['priority'];
				// $list_name = $row['list_name'];
				$deadline = $row['deadline'];

		
				$sql2 = "SELECT name FROM leads WHERE name LIKE '$lead_name%'";
				$result = mysqli_query($con, $sql2);
				while($row=mysqli_fetch_assoc($result)){
					$name = $row['name'];
				}
		?>				
		<tr>
		<td><?php echo $sn++; ?></td>
		<td><a href="./update-task.php?task_id=<?= $task_id; ?>"><?php echo $task_name;?></a></td>
		<td><a href="./updatelead.php?name=<?= $name; ?>"><?php echo $lead_name; ?></a></td>
		<td><?php echo $priority; ?></td>
		<td><?php echo $deadline; ?></td>
		</tr>			
		<?php
				}
			}
			else
			{
			//No data in Database
		?>					
		<tr>
		<td colspan="5">No tasks ...</td>
		</tr>					
		<?php
				}
			}
		
		?>	
     </table>
	</div>
 </div>
</div>
 <div class="content w3-mobile">
	<div class="w3-col s12 m3 l3 w3-margin">
		<h2><?php echo date('F'); ?> Activity</h2>
		<?php
			$pdo = pdo_connect_mysql();
			$newleads = $pdo->query('SELECT COUNT(*) FROM leads WHERE MONTH(created) = MONTH(now())')->fetchColumn();
			$convleads = $pdo->query('SELECT COUNT(*) FROM clients WHERE MONTH(created) = MONTH(now())')->fetchColumn();
			$convperc = $convleads / $newleads;

		?>
	<div>
		<h4>Leads - <?= $newleads?></h4>
	</div>
	<div>
		<h4>Clients - <?= $convleads?></h4>
	</div>
	<div>
		<h4>Conversion = <?= number_format($convperc * 100); ?> %</h4>
	</div> 
    </div>
	<div class="w3-col s12 m3 l3 w3-margin">
		<h2><?php echo date('Y'); ?> Activity</h2>
		<?php
			$pdo = pdo_connect_mysql();
			$newleads = $pdo->query('SELECT COUNT(*) FROM leads WHERE YEAR(created) = YEAR(now())')->fetchColumn();
			$convleads = $pdo->query('SELECT COUNT(*) FROM clients WHERE YEAR(created) = YEAR(now())')->fetchColumn();
			if($convleads > 0){
				$convperc = $convleads / $newleads;
			}
		?>
       <div>
	 <h4>Leads - <?= $newleads?></h4>
	</div>
        <div>
	 <h4>Clients - <?= $convleads?></h4>
        </div>
	<div>
		<h4>Conversion = <?= number_format($convperc * 100); ?> %</h4>
	</div> 
   </div>
 <div class="w3-col s12 m6-6 l6-6 w3-margin w3-padding">
	<h2><?php echo date('Y'); ?> Activity</h2>
	<?php
		$pdo = pdo_connect_mysql();
		$mnthleads = $pdo->query('SELECT DATE_FORMAT(created, "%b") as monthname, COUNT(*) as leadnum FROM leads WHERE YEAR(created) = YEAR(now()) GROUP BY monthname')->fetchAll(PDO::FETCH_OBJ);
		$mnthclients = $pdo->query('SELECT DATE_FORMAT(created, "%b") as monthname, COUNT(*) as clientnum FROM clients WHERE YEAR(created) = YEAR(now()) GROUP BY monthname')->fetchAll(PDO::FETCH_OBJ);
	?>

	<canvas id="activityChart" class="chart-style"></canvas>
 </div>
</div>
</div>
<script type="text/javascript">
	const mnthleads = <?php echo json_encode($mnthleads) ?>;
	const mnthclients = <?php echo json_encode($mnthclients) ?>;
</script>
<script src="./js/activity.js"></script>

<?=template_footer()?>
