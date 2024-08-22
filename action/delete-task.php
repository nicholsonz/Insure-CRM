<?php
    include('../include/dbconfig.php');


    //Check task_id in URL
    if(isset($_POST['delete_task']))
    {
        //Delete the Task from Database
        //Get the Task ID
        // $task_id = $_GET['task_id'];

            $task_id = mysqli_real_escape_string($con, $_POST['task_id']);

        //SQL Query to DELETE TASK
        $sql = "DELETE FROM tasks WHERE task_id='$task_id'";

        //Execute Query
        $res = mysqli_query($con, $sql);

        //CHeck if the Query Executed Successfully or Not
        if($res==true){
          $res = [
              'status' => 200,
              'message' => 'Account Entry Deleted Successfully'
          ];
          echo json_encode($res);
          return;
          } else{
              $res = [
                  'status' => 500,
                  'message' => 'Account Entry Not Deleted'
              ];
              echo json_encode($res);
              return;
          }
    }

?>
