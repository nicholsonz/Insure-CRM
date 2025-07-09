<?php
    require_once('./require/header.php');

// Test whether the user is Admin or not and restrict access
$admchk = "SELECT * FROM accounts WHERE id = '$acct_id'";
$chkres = mysqli_query($con, $admchk);
while($row = mysqli_fetch_assoc($chkres)){
    if($row['acct_type'] != "Admin") {        
	header("Location: home.php");
    }
 }

// Fetch all accounts
$stmt = "SELECT * FROM accounts";
// In this case we can use the account ID to get the account info.
//Execute Query
        $res = mysqli_query($con, $stmt);

        //Check if the query executed successfully or not
        if($res==true)
        {
            //Query <br />Executed
            $row = mysqli_fetch_assoc($res);

            //Get the Individual Value
			$acct_name = $row['username'];
			$email = $row['email'];
			$accttype = $row['acct_type'];
        } else
			{
				//Redirect to Homepage
				header('location: home.php');
		}

?>

<?=template_header('Settings')?>
		<div class="w3-content">
			<h1>Settings</h1>
      <hr></hr>
			<div class="">
			  <div class="w3-col s12 m5 l5 w3-camo-fade w3-margin w3-border w3-round w3-border-blue-grey w3-pannel w3-card-4">
				<h2>User Accounts</h2>
				<table class="w3-table">
					<thead>
					  <tr>
						<th>Username</th>
						<th>Email</th>
						<th>Account Type</th>
					  </tr>
					</thead>
					<tbody>
					  <tr>
						<td><?=$acct_name?></td>
						<td><?=$email?></td>
						<td><?=$accttype?></td>
					  </tr>
					</tbody>					
				</table>
			  </div>
			</div>
		</div>

<?php require_once('./require/footer.php');?>
