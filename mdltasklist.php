<?php

$acct_id = $_POST['acct_id'];

$sql_tasks = "SELECT * FROM tasks WHERE acct_id = '$acct_id' AND NOW() > DATE(deadline)";
	$res = mysqli_query($con, $sql_tasks);
	$num_tasks = mysqli_num_rows($res);

	while($row = mysqli_fetch_assoc($res)){
		$names = $row['name'];
		
	echo json_encode($names);
	}
?>