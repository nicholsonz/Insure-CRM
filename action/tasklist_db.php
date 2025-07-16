
<?php

// Get the total number of records.
$total_pages = $con->query("SELECT COUNT(*) FROM tasks WHERE acct_id = '$acct_id'")->fetch_row()[0];

// Check if the page number is specified and check if it's a number, if not return the default page number which is 1.
$page = isset($_GET['page']) && is_numeric($_GET['page']) ? $_GET['page'] : 1;

// Number of results to show on each page.
$records_per_page = 10;
      
$stmt = $con->prepare("SELECT t.task_id, t.acct_id, t.task_name, t.details, t.name, t.list_id, t.priority, 
                        DATE_FORMAT(t.deadline, '%b %d, %y %h:%i %p') AS deadline, t.type, tl.list_name
                        FROM tasks as t
                        LEFT JOIN task_lists AS tl ON t.list_id = tl.id
                        WHERE t.acct_id = ?
                        ORDER BY t.deadline ASC -- LIMIT ?,?");
// Calculate the page to get the results we need from our table.
// $calc_page = ($page - 1) * $records_per_page;
// $stmt->bind_param('ii', $calc_page, $records_per_page);
$stmt->execute([$acct_id]);
// Get the results...
$result = $stmt->get_result();
$stmt->close();


// MYSQL stmt to match username to acct_id
$acctid_stmt = $con->prepare("SELECT UNIQUE(a.username), t.acct_id as acct_id FROM accounts AS a
                              LEFT JOIN tasks AS t ON t.acct_id = a.id
                              WHERE t.acct_id = ?");
$acctid_stmt->execute([$acct_id]);
$res_acctid = $acctid_stmt->get_result();
$acctid_stmt->close();

// MYSQL statement for getting the List name for the List ID
$list_name = $con->prepare("SELECT UNIQUE(t.list_id), t.acct_id as acct_id, tl.id, tl.list_name
                            FROM tasks AS t
                            LEFT JOIN task_lists AS tl ON tl.id = t.list_id
                            WHERE tl.acct_id = ?");
$list_name->execute([$acct_id]);
$res_listnm = $list_name->get_result();
$list_name->close();

// MYSQL statement for getting priority for task  
$table_name = "tasks";
$column_name = "priority";


$query = "SELECT COLUMN_TYPE FROM INFORMATION_SCHEMA.COLUMNS
        WHERE TABLE_NAME = '$table_name' AND COLUMN_NAME = '$column_name'
        ORDER BY '$column_name' ASC";
$res = mysqli_query($con, $query);

$row = mysqli_fetch_array($res);

$enumList = explode(",", str_replace("'", "", substr($row['COLUMN_TYPE'], 5, (strlen($row['COLUMN_TYPE'])-6))));
?>