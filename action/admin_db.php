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

// MYSQL statement for edit modal Username list selection
$user_stmt = $con->prepare("SELECT a.username
                              FROM accounts AS a
                              ORDER BY a.username DESC");
$user_stmt->execute();
$res_user = $user_stmt->get_result();
$user_stmt->close();

// // MYSQL stmt to match username to acct_id
// $taskid_stmt = $con->prepare("SELECT a.username, t.task_id FROM accounts AS a
//                               LEFT JOIN tasks AS t ON t.acct_id = a.id
//                               WHERE t.task_id = ?");
// $taskid_stmt->execute([$task_id]);
// $res_taskid = $taskid_stmt->get_result();
// $taskid_stmt->close();

?>