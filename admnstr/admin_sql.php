<?php

///////////////////////////// Home Page ///////////////////////////////////////////
// Get Tasks Due number for home page
$sql_tasks = "SELECT * FROM tasks WHERE (NOW() BETWEEN DATE_SUB(DATE(deadline), INTERVAL 8 DAY) AND DATE(deadline)) AND acct_id = '$acct_id' ORDER BY deadline ASC";
$res = mysqli_query($con, $sql_tasks);
$num_tasks = mysqli_num_rows($res);

$sql_tasks2 = "SELECT * FROM tasks WHERE DATE(NOW()) >= DATE(deadline) AND acct_id = '$acct_id' ORDER BY deadline ASC";
$res2 = mysqli_query($con, $sql_tasks2);
$num_tasks2 = mysqli_num_rows($res2);

///////////////////////////// Tasks Page //////////////////////////////////////////
// Get the total number of records.
$total_pages = $con->query("SELECT COUNT(*) FROM tasks")->fetch_row()[0];

// Check if the page number is specified and check if it's a number, if not return the default page number which is 1.
$page = isset($_GET['page']) && is_numeric($_GET['page']) ? $_GET['page'] : 1;

// Number of results to show on each page.
$records_per_page = 10;


 $stmt = $con->prepare("SELECT t.task_id, t.acct_id, t.details, t.object, t.list_id, t.priority, 
                            t.deadline AS deadline, t.type, tl.list_name, a.username
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

// MYSQL statement for getting the List name for the List ID
$list_name = $con->prepare("SELECT UNIQUE(t.list_id), tl.id, tl.list_name
                            FROM tasks AS t
                            LEFT JOIN task_lists AS tl ON tl.id = t.list_id");
$list_name->execute();
$res_listnm = $list_name->get_result();
$list_name->close();


// MYSQL statement for getting Priority enum list for task  
$table_name = "tasks";
$column_prty = "priority";
$query_prty = "SELECT COLUMN_TYPE FROM INFORMATION_SCHEMA.COLUMNS
        WHERE TABLE_NAME = '$table_name' AND COLUMN_NAME = '$column_prty'";
$res_prty = mysqli_query($con, $query_prty);
$row_prty = mysqli_fetch_array($res_prty);
$enumPrty = explode(",", str_replace("'", "", substr($row_prty['COLUMN_TYPE'], 5, (strlen($row_prty['COLUMN_TYPE'])-6))));


// MYSQL statement for getting Type enum list for task 
$table_name = "tasks";
$column_type = "type";
$query_type = "SELECT COLUMN_TYPE FROM INFORMATION_SCHEMA.COLUMNS
        WHERE TABLE_NAME = '$table_name' AND COLUMN_NAME = '$column_type'";
$res_type = mysqli_query($con, $query_type);
$row_type = mysqli_fetch_array($res_type);
$enumType = explode(",", str_replace("'", "", substr($row_type['COLUMN_TYPE'], 5, (strlen($row_type['COLUMN_TYPE'])-6))));

?>