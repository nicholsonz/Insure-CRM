<?php 

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

    $upd_task = mysqli_prepare($con, "UPDATE tasks SET
                acct_id = '?',
                task_name = '?',
                name = '?',
                details = '?',
                list_id = '?',
                priority = '?',
                deadline = '?',
                type = '?'
                WHERE acct_id = '?'
                AND task_id = '?'");
      mysqli_stmt_bind_param($upd_task, "isssisdsii", $acct_id, $task_name, $name, $details, $list_id, $priority, $deadline, $type, $acct_id, $task_id);
    $upd_task->execute();

    if($upd_task)
    {
        $res = [
            'status' => 200,
            'message' => 'Income Updated Successfully'
        ];
        echo json_encode($res);
        return;
    }
    else
    {
        $res = [
            'status' => 500,
            'message' => 'Income Not Updated'
        ];
        echo json_encode($res);
        return;
    }
}
?>