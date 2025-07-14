<?php

// Get the total number of records.
$total_pages = $con->query("SELECT COUNT(*) FROM tasks")->fetch_row()[0];

// Check if the page number is specified and check if it's a number, if not return the default page number which is 1.
$page = isset($_GET['page']) && is_numeric($_GET['page']) ? $_GET['page'] : 1;

// Number of results to show on each page.
$records_per_page = 10;


 $stmt = $con->prepare("SELECT t.task_id, t.acct_id, t.task_name, t.details, t.name, t.list_id, t.priority, 
                            DATE_FORMAT(t.deadline, '%b %d, %y %h:%i %p') AS deadline, t.type, tl.list_name, a.username
                           FROM tasks as t
                           LEFT JOIN task_lists AS tl ON t.list_id = tl.id
                           LEFT JOIN accounts AS a ON a.id = t.acct_id
                           ORDER BY t.deadline ASC -- LIMIT ?,?");
	// Calculate the page to get the results we need from our table.
	// $calc_page = ($page - 1) * $records_per_page;
	// $stmt->bind_param('ii', $calc_page, $records_per_page);
	$stmt->execute();
	// Get the results...
	$result = $stmt->get_result();
	$stmt->close();
    while($row = $result->FETCH_ASSOC()) {
        $task_id = $row['task_id'];
    }
    $result->data_seek(0);


// MYSQL statement for the Username of the Task ID selected
$user_stmt = $con->prepare("SELECT UNIQUE(a.username), t.acct_id as acct_id
                            FROM accounts AS a
                            LEFT JOIN tasks AS t on t.acct_id = a.id");
$user_stmt->execute();
$res_user = $user_stmt->get_result();
$user_stmt->close();


?>