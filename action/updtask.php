<?php 
require '../include/config.php';

if(isset($_POST['update_task']))
{
    $task_id = $_POST['task_id'];

    $acct_id = $_POST['acct_id'];
    $task_name = $_POST['task_name'];
    $name = $_POST['name'];
    $details = $_POST['details'];
    $list_id = $_POST['list_id'];
    $priority = $_POST['priority'];
    $deadline = $_POST['deadline'];
    $type = $_POST['type'];


    if($acct_id == NULL || $task_name = NULL || $name = NULL || $details = NULL || $list_id = NULL || $priority = NULL || $deadline = NULL || $type = NULL)
    {
        $res = [
            'status' => 422,
            'message' => 'All fields are mandatory'
        ];
        echo json_encode($res);
        return;
    }

    $upd_task = mysqli_prepare($con, "UPDATE tasks SET acct_id = '?', task_name = '?', name = '?', details = '?', list_id = '?', priority = '?', deadline = '?', type = '?' WHERE task_id = '?'");
      mysqli_stmt_bind_param($upd_task, "isssisbsi", $acct_id, $task_name, $name, $details, $list_id, $priority, $deadline, $type, $task_id);
    $upd_task->execute();

    if($upd_task)
    {
        $res = [
            'status' => 200,
            'message' => 'Task Updated Successfully'
        ];
        echo json_encode($res);
        return;
    }
    else
    {
        $res = [
            'status' => 500,
            'message' => 'Task Not Updated'
        ];
        echo json_encode($res);
        return;
    }
}


if(isset($_GET['task_id']))
{
    $id = $_GET['task_id'];


    $get_id = mysqli_prepare($con, "SELECT * FROM tasks WHERE task_id=?");
      mysqli_stmt_bind_param($get_id, "i", $id);
    $get_id->execute();
    $result = $get_id->get_result();
    $rows = mysqli_num_rows($result);

    if($rows == 1)
    {
        $entry = mysqli_fetch_array($result);

        $res = [
            'status' => 200,
            'message' => 'Entry Fetch Successfully by id',
            'data' => $entry
        ];
        echo json_encode($res);
        return;
    }
    else
    {
        $res = [
            'status' => 404,
            'message' => 'Entry Id Not Found'
        ];
        echo json_encode($res);
        return;
    }
}
?>