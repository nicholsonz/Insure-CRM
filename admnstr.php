<?php
    require_once('./require/header.php');

// Test whether the user is Admin or not and restrict access
if($rowchk['acct_type'] !== "Admin"){      
	header("Location: home.php");
} else {
	// Fetch all accounts
	$stmt = $con->prepare("SELECT * FROM accounts AS a
							ORDER BY a.username DESC"); 
	}$stmt->execute();
        // Get the results...
        $result = $stmt->get_result();
        $stmt->close();

?>

<?=template_header('Administrator')?>
		<div class="w3-content">
			<h1>Administrator</h1>
      <hr></hr>
			<div class="">
			  	<div class="w3-col s12 m5 l5 w3-camo-fade w3-margin w3-border w3-round w3-border-blue-grey w3-pannel w3-card-4">
				<h2>User Accounts</h2>
					<div class="table-viewer tableFixHead">
						<table class="w3-table w3-hoverable" id="srtTable">
							<thead>
							<tr>						
								<th><a href="javascript:SortTable(0,'T');">Username <i class="fa fa-sort"></a></th>
								<th>Email</th>
								<th>Account Type</th>
							</tr>
							</thead>
						<?php while ($row = $result->FETCH_ASSOC()): ?>
							<tbody>
							<tr>
								<td><?=$row['username']?></td>
								<td><?=$row['email']?></td>
								<td><?=$row['acct_type']?></td>
							</tr>
						<?php endwhile; ?>
							</tbody>					
						</table>
					</div>
				</div>
			</div>
		</div>

<?php require_once('./require/footer.php');?>
