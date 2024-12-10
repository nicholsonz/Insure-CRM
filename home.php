<?php
    require_once('./require/header.php');

	$sql = "SELECT COUNT(*) as clients,
		(SELECT COUNT(*) FROM tasks WHERE acct_id = '$acct_id' AND type = 'Lead') as leads,
		(SELECT COUNT(*) FROM tasks WHERE acct_id = '$acct_id' AND type = 'Other') as other
		FROM tasks
		WHERE acct_id = '$acct_id' AND type = 'Client'";
	$res = mysqli_query($con, $sql);
	while($row=mysqli_fetch_assoc($res)){
		$clients = $row['clients'];
		$leads = $row['leads'];
		$other = $row['other'];
	}

?>

<?=template_header('Home')?>
<div class="content w3-padding w3-mobile">
<table class="w3-table w3-custom-blue w3-card-4">
  <tr>
    <?php
      $sqlpol = "SELECT policy, COUNT(policy) as counted FROM clients WHERE acct_id = '$acct_id' GROUP BY policy";
      $result = mysqli_query($con, $sqlpol);

      while($row = mysqli_fetch_assoc($result)){
        echo  "<td>".$row['policy']. "&nbsp; - " .$row['counted']. "</td>";
      }?>
   </tr>
 </table>
</div>
<div class="content w3-padding w3-mobile">
  <!-- <h1><?= date("l - F d Y");?></h1> -->

   		<div class="w3-col s12 m3 l3 w3-camo-fade w3-margin w3-border w3-round w3-border-blue-grey w3-card-4">
			<h2><?php echo date('F'); ?> Activity</h2>
      <br />
			<?php
				$pdo = pdo_connect_mysql();
				$newleads = $pdo->query("SELECT COUNT(*) FROM leads WHERE acct_id = '$acct_id' AND YEAR(created) = YEAR(NOW()) AND MONTH(created) = MONTH(now())")->fetchColumn();
				$convleads = $pdo->query("SELECT COUNT(*) FROM clients WHERE acct_id = '$acct_id' AND YEAR(created) = YEAR(NOW()) AND MONTH(created) = MONTH(now())")->fetchColumn();
				if($convleads == "0"){
					$convperc = "0";
				}elseif($newleads == "0" && $convleads > "0"){
					$convperc = $convleads;
				}else{
				$convperc = $convleads / $newleads;
				}
			?>
			<table>
				<tr>
					<td class="w3-xlarge">Leads</td>
					<td class="w3-xlarge"><?= $newleads?></td>
				</tr>
				<tr>
					<td class="w3-xlarge">Clients</td>
					<td class="w3-xlarge"><?= $convleads?></td>
				</tr>
        <tr>
          <td><br /></td>
        </tr>
				<tr>
					<td class="w3-xlarge">Conversion</td>
					<td class="w3-xlarge">&nbsp; <?= number_format($convperc * 100); ?> %</td>
				</tr>
			</table>
    </div>
		<div class="w3-col s12 m3 l3 w3-camo-fade w3-margin w3-border w3-round w3-border-blue-grey w3-pannel w3-card-4">
			<h2><?php echo date('Y'); ?> Activity</h2>
      <br />
			<?php
				$pdo = pdo_connect_mysql();
				$newleads = $pdo->query("SELECT COUNT(*) FROM leads WHERE acct_id = '$acct_id' AND YEAR(created) = YEAR(now())")->fetchColumn();
				$convleads = $pdo->query("SELECT COUNT(*) FROM clients WHERE acct_id = '$acct_id' AND YEAR(created) = YEAR(now())")->fetchColumn();
				if($convleads == "0"){
					$convperc = "0";
				}elseif($newleads == "0" && $convleads > "0"){
					$convperc = $convleads;
				}else{
				$convperc = $convleads / $newleads;
				}
			?>
			<table>
				<tr>
					<td class="w3-xlarge">Leads</td>
					<td class="w3-xlarge"><?= $newleads?></td>
				</tr>
				<tr>
					<td class="w3-xlarge">Clients</td>
					<td class="w3-xlarge"><?= $convleads?></td>
				</tr>
        <tr>
          <td><br /></td>
        </tr>
				<tr>
					<td class="w3-xlarge">Conversion</td>
					<td class="w3-xlarge">&nbsp; <?= number_format($convperc * 100); ?> %</td>
				</tr>
			</table>
		</div>
  		<?php

  			// PHP Calendar for lead count
  			$time = time();
  			$mnthyr = date('F Y');
  			$numDay = date('d', $time);
  			$numMonth = date('m', $time);
  			$strMonth = date('F', $time);
  			$numYear = date('Y', $time);
  			$firstDay = mktime(0,0,0,$numMonth,1,$numYear);
  			$daysInMonth = cal_days_in_month(0, $numMonth, $numYear);
  			$dayOfWeek = date('w', $firstDay);
  		?>
		<div class="w3-col s12 m5 l5 w3-camo-fade w3-margin w3-border w3-round w3-border-blue-grey w3-pannel w3-card-4">
      <h2><?php echo($mnthyr); ?></h2>
			<table class="w3-centered cal-table">
				<thead>
					<tr>
						<th abbr="Sunday" scope="col" title="Sunday">S</th>
						<th abbr="Monday" scope="col" title="Monday">M</th>
						<th abbr="Tuesday" scope="col" title="Tuesday">T</th>
						<th abbr="Wednesday" scope="col" title="Wednesday">W</th>
						<th abbr="Thursday" scope="col" title="Thursday">T</th>
						<th abbr="Friday" scope="col" title="Friday">F</th>
						<th abbr="Saturday" scope="col" title="Saturday">S</th>
					</tr>
				</thead>
			<tbody>
				<tr>
					<?php
					if($dayOfWeek != 0) { echo("<td colspan='$dayOfWeek'> </td>"); }
					for($i=1;$i<=$daysInMonth;$i++) {

					if($i == $numDay) { echo("<td class='today'>"); } else { echo("<td>"); }
					echo($i);
					echo("</td>");
					if(date('w', mktime(0,0,0,$numMonth, $i, $numYear)) == 6) {
					echo("</tr><tr>");
					}
					}
					?>
				</tr>
			</tbody>
			</table>
		</div>
		<div class="w3-col s12 m6-6 l6-6 w3-camo-fade w3-margin w3-border w3-round w3-border-blue-grey w3-pannel w3-card-4">
			<h2><?php echo date('Y'); ?> Activity</h2>
			<?php
				$pdo = pdo_connect_mysql();
				$mnthleads = $pdo->query("SELECT DATE_FORMAT(created, '%b') as monthname, COUNT(*) as leadnum FROM leads WHERE acct_id = '$acct_id' AND YEAR(created) = YEAR(now()) GROUP BY monthname")->fetchAll(PDO::FETCH_OBJ);
				$mnthclients = $pdo->query("SELECT DATE_FORMAT(created, '%b') as monthname, COUNT(*) as clientnum FROM clients WHERE acct_id = '$acct_id' AND YEAR(created) = YEAR(now()) GROUP BY monthname")->fetchAll(PDO::FETCH_OBJ);
			?>

			<canvas id="activityChart" class="chart-style"></canvas>
		</div>
    <div class="w3-col s12 m5 l5  w3-camo-fade w3-margin w3-border w3-round w3-border-blue-grey w3-pannel w3-card-4">
    <button id="showhide" class="w3-btn w3-border w3-round w3-block w3-custom-blue w3-border-blue-grey w3-margin-bottom w3-padding"><h3>Tasks | &nbsp;Clients <?= number_format($clients);?></h3></button>
      <div id="show" class="read w3-hide">
        <div class="tableFixHead">
        <table class="w3-table w3-hoverable">
        <thead>
          <tr>
          <!-- <th>#</th> -->
          <th>Task</th>
          <th>Client</th>
          <th>Priority</th>
          <th>Deadline</th>
          </tr>
        </thead>
          <?php

          //Select Database
          $db_select = mysqli_select_db($con, DB_NAME) or die();

          //Create SQL Query to Get Data from Databse
            $stmt = $pdo->prepare("SELECT task_id, task_name, name, priority, list_name, DATE_FORMAT(deadline, '%b %d, %y %h:%i %p') AS deadline, tl.list_name
              FROM tasks AS t
              LEFT JOIN task_lists AS tl ON t.list_id = tl.list_id
              WHERE t.acct_id = '$acct_id' AND t.type = 'Client'
              ORDER BY deadline");
            $stmt->execute();

            // Fetch the records so we can display them in our template.
            $clients = $stmt->fetchAll(PDO::FETCH_ASSOC);
            // Get the total number of clients, this is so we can determine whether there should be a next and previous button
            $num_clients = $pdo->query("SELECT COUNT(*) FROM tasks AS t
            LEFT JOIN task_lists AS tl ON t.list_id = tl.list_id
            WHERE t.acct_id = '$acct_id' AND t.type = 'Client'")->fetchColumn();

            //Create SQL Query to Get DAta from Databse
            $sql = "SELECT task_id, task_name, name, priority, list_name, DATE_FORMAT(deadline, '%b %d, %y %h:%i %p') AS deadline, tl.list_name
            FROM tasks AS t
            LEFT JOIN task_lists AS tl ON t.list_id = tl.list_id
            WHERE t.acct_id = '$acct_id' AND t.type = 'Client'
            ORDER BY deadline"
            ;
            //Execute Query
            $res = mysqli_query($con, $sql);

            //CHeck whether the query execueted o rnot
            if($res==true)
            {
            //DIsplay the Tasks from DAtabase
            //Count the Tasks on Database first
            $count_clients = mysqli_num_rows($res);

            //Create Serial Number Variable
            $sn=1;

            //Check whether there is task on database or not
            if($count_clients>0)
            {

            ?>
            <tbody id="tblSrch">
            <?php foreach ($clients as $client): ?>
            <tr>
            <!-- <td><?php echo $sn++; ?></td> -->
            <td><a href="./update-task.php?task_id=<?= $client['task_id']; ?>"><?= $client['task_name'];?></a></td>
            <td><a href="./updateclient.php?name=<?= $client['name']; ?>"><?= $client['name']; ?></a></td>
            <td><?= $client['priority']; ?></td>
            <td><?= $client['deadline']; ?></td>
            </tr>
            <?php endforeach; ?>
            <?php

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
      <button id="showhide2" class="w3-btn w3-border w3-round w3-block w3-custom-blue w3-border-blue-grey w3-margin-bottom w3-margin-top w3-padding"><h3>Tasks | &nbsp;Leads <?= number_format($leads);?></h3></button>
      <div id="show2" class="read w3-hide">
      <div class="tableFixHead">
        <table class="w3-table" id="srtTable">
        <thead>
          <tr>
          <!-- <th>#</th> -->
          <th>Task</th>
          <th>Lead</th>
          <th>Priority</th>
          <th>Deadline</th>
          </tr>
        </thead>
          <?php
            // Prepare the SQL statement and get records from our clients table, LIMIT will determine the page
            $stmt = $pdo->prepare("SELECT task_id, task_name, name, priority, list_name, DATE_FORMAT(deadline, '%b %d, %y %h:%i %p') AS deadline, tl.list_name
                        FROM tasks AS t
                        LEFT JOIN task_lists AS tl ON t.list_id = tl.list_id
                        WHERE t.acct_id = '$acct_id' AND t.type = 'Lead'
                        ORDER BY deadline");
            $stmt->execute();
            // Fetch the records so we can display them in our template.
            $leads = $stmt->fetchAll(PDO::FETCH_ASSOC);
            // Get the total number of clients, this is so we can determine whether there should be a next and previous button
            $num_leads = $pdo->query("SELECT COUNT(*) FROM tasks AS t
            LEFT JOIN task_lists AS tl ON t.list_id = tl.list_id
            WHERE t.acct_id = '$acct_id' AND t.type = 'Lead'")->fetchColumn();

          //Select Database
          $db_select = mysqli_select_db($con, DB_NAME) or die();

          //Create SQL Query to Get DAta from Databse
          $sql = "SELECT task_id, task_name, name, priority, list_name, DATE_FORMAT(deadline, '%b %d, %y %h:%i %p') AS deadline, tl.list_name
              FROM tasks AS t
              LEFT JOIN task_lists AS tl ON t.list_id = tl.list_id
              WHERE t.acct_id = '$acct_id' AND t.type = 'Lead'
              ORDER BY deadline";


          //Execute Query
          $res = mysqli_query($con, $sql);

          //Check whether the query execueted or not
            if($res==true)
            {
            //DIsplay the Tasks from DAtabase
            //Count the Tasks on Database first
            $count_leads = mysqli_num_rows($res);

            //Create Serial Number Variable
            $sn=1;

            //Check whether there is task on database or not
            if($count_leads>0)
            {

          ?>
        <tbody id="tblSrch">
          <?php foreach ($leads as $lead): ?>
          <tr>
          <!-- <td><?php echo $sn++; ?></td> -->
          <td><a href="./update-task.php?task_id=<?= $lead['task_id']; ?>"><?= $lead['task_name'];?></a></td>
          <td><a href="./updatelead.php?name=<?= $lead['name']; ?>"><?= $lead['name']; ?></a></td>
          <td><?= $lead['priority']; ?></td>
          <td><?= $lead['deadline']; ?></td>
          </tr>
          <?php endforeach; ?>
          <?php

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
      <button id="showhide3" class="w3-btn w3-border w3-round w3-block w3-custom-blue w3-border-blue-grey  w3-margin-bottom w3-margin-top w3-padding"><h3>Tasks | &nbsp;Other <?= number_format($other);?></h3></button>
      <div id="show3" class="read w3-hide">
        <div class="tableFixHead">
        <table class="w3-table w3-hoverable">
        <thead>
          <tr>
          <!-- <th>#</th> -->
          <th>Task</th>
          <th>Name</th>
          <th>Priority</th>
          <th>Deadline</th>
          </tr>
        </thead>
          <?php

          //Select Database
          $db_select = mysqli_select_db($con, DB_NAME) or die();

          //Create SQL Query to Get DAta from Databse
          $sql = "SELECT task_id, task_name, name, priority, list_name, DATE_FORMAT(deadline, '%b %d, %y %h:%i %p') AS deadline, tl.list_name
              FROM tasks AS t
              LEFT JOIN task_lists AS tl ON t.list_id = tl.list_id
              WHERE t.acct_id = '$acct_id' AND t.type = 'Other'
              ORDER BY deadline";


          //Execute Query
          $res = mysqli_query($con, $sql);

          //CHeck whether the query execueted o rnot
            if($res==true)
            {
            //DIsplay the Tasks from DAtabase
            //Dount the Tasks on Database first
            $count_other = mysqli_num_rows($res);

            //Create Serial Number Variable
            $sn=1;

            //Check whether there is task on database or not
            if($count_other>0)
            {
            //Data is in Database
              while($row=mysqli_fetch_assoc($res))
              {
              $task_id = $row['task_id'];
              $task_name = $row['task_name'];
              $name = $row['name'];
              $priority = $row['priority'];
              // $list_name = $row['list_name'];
              $deadline = $row['deadline'];


              $sql2 = "SELECT name FROM clients WHERE name LIKE '$name%'";
              $result = mysqli_query($con, $sql2);
              while($row=mysqli_fetch_assoc($result)){
                $name = $row['name'];
              }
          ?>
          <tr>
          <!-- <td><?php echo $sn++; ?></td> -->
          <td><a href="./update-task.php?task_id=<?= $task_id; ?>"><?php echo $task_name;?></a></td>
          <td><a href="./update-task.php?task_id=<?= $task_id; ?>"><?php echo $name; ?></a></td>
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

	</div>

<script type="text/javascript">
	const mnthleads = <?php echo json_encode($mnthleads) ?>;
	const mnthclients = <?php echo json_encode($mnthclients) ?>;
</script>
<script src="./js/activity.js"></script>
<script src="./js/showhide.js"></script>
<?php require_once './require/footer.php';?>
