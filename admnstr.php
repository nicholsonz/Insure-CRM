<?php
    require_once('./require/header.php');

// Test whether the user is Admin or not and restrict access
if($rowchk['acct_type'] !== "Admin"){      
	header("Location: home.php");
} else {
	// Fetch all accounts
	$stmt = $con->prepare("SELECT id, username, email, acct_type
							FROM accounts"); 
	}
	// Count policies for each user
	// $stmt = $con->prepare("SELECT a.id, a.username, a.email, a.acct_type, COUNT(c.policy) as policies 
	// 						FROM accounts AS a
	// 						LEFT JOIN clients AS c ON a.id = c.acct_id
	// 						GROUP BY a.id"); 
		
$stmt->execute();
// Get the results...
$result = $stmt->get_result();
$stmt->close();

?>

<?=template_header('Administrator')?>

<!-- Edit User Modal -->
<div class="modal fade" id="userEditModal" tabindex="-1" aria-labelledby="User Edit Modal">
    <div class="modal-dialog">
        <div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel">Edit Task</h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<form id="updateUser">
				<div class="modal-body">
					<div id="errorMessageUpdate" class="alert alert-warning d-none">
					</div>
						<input type="hidden" name="id" id="id" > 
					<div class="col-md6">
						<label for="username">Username</label>
						<input type="text" name="username" id="username" class="form-control" />						
					</div>					
					<div class="col-md-11">
						<label for="email">Email</label>
						<input type="email" name="email" id="email" class="form-control" />
					</div>        
					<div class="mb-3">
						<label for="acct_type">Account Type</label>
							<select class="form-select" id="acct_type" name="acct_type">
								<option value="Admin">Admin</option>
								<option value="Agent">Agent</option>
								<option value="Support">Support</option>
								<option value="Other">Other</option>
							</select>                    
					</div>                              
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
					<button type="submit" class="btn btn-primary">Update</button>
				</div>
			</form>
        </div>
    </div>
</div>
<div class="w3-content w3-mobile">
	<h1>Administrator</h1>
	<div class="w3-col s12 m10 l6 w3-camo-fade w3-margin w3-border w3-round w3-border-blue-grey w3-pannel w3-card-4">
		<div class="tableFixHead" id="userTable">
			<h2>User Accounts</h2>
				<table class="w3-table" id="srtTable">
					<thead>
					<tr>						
						<th><a href="javascript:SortTable(0,'T');">Username <i class="fa fa-sort"></a></th>
						<th>Email</th>
						<th>Account Type</th>
						<th>Edit</th>
					</tr>
					</thead>
				<?php while ($row = $result->FETCH_ASSOC()): ?>
					<tbody>
					<tr>
						<td><?=$row['username']?></td>
						<td><?=$row['email']?></td>
						<td><?=$row['acct_type']?></td>
						<td><button type="button" value="<?=$row['id'];?>" class="editUserBtn w3-btn edit"><i class="fas fa-edit fa-xs"></i></button></td>
					</tr>
				<?php endwhile; ?>
					</tbody>					
				</table>
		</div>
	</div>
</div>
<script src="./js/admnstr.js"></script>
<?php require_once('./require/footer.php');?>
