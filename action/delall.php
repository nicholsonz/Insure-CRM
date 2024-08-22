<?php
    include('../include/dbconfig.php');


    //Check task_id in URL
    if(isset($_POST['delete_task']))
    {
        //Delete the Task from Database
        //Get the Task ID
        $task_id = mysqli_real_escape_string($con, $_POST['task_id']);

        //SQL Query to DELETE TASK
        $sql = "DELETE FROM tasks WHERE task_id='$task_id'";

        //Execute Query
        $res = mysqli_query($con, $sql);

        //CHeck if the Query Executed Successfully or Not
        if($res==true){
          $res = [
              'status' => 200,
              'message' => 'Task Entry Deleted Successfully'
          ];
          echo json_encode($res);
          return;
          } else{
              $res = [
                  'status' => 500,
                  'message' => 'Task Entry Not Deleted'
              ];
              echo json_encode($res);
              return;
          }
    }

    if(isset($_POST['delete_list']))
    {
        //Delete the List from database

        //Get the list_id value from URL or Get Method
        $list_id = mysqli_real_escape_string($con, $_POST['list_id']);

        //Write the Query to DELETE List from DAtabase
        $sql = "DELETE FROM task_lists WHERE list_id='$list_id'";

        //Execute The Query
        $res = mysqli_query($con, $sql);

        //Check whether the query executed successfully or not
        if($res==true) {
          $res = [
              'status' => 200,
              'message' => 'Task List Entry Deleted Successfully'
          ];
          echo json_encode($res);
          return;
          } else{
              $res = [
                  'status' => 500,
                  'message' => 'Task List Entry Not Deleted'
              ];
              echo json_encode($res);
              return;
          }
    }


?>
