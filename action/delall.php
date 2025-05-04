<?php
include('../include/dbconfig.php');

// Set document root for uploaded files
$rootDir = $_SERVER['DOCUMENT_ROOT'];
$files = "";
// We need to use sessions, so you should always start sessions using the below code.
if (session_status() === PHP_SESSION_NONE) {
    session_start();
  }

  $key = $_SESSION["loggedin"];
  // Check if the user is logged in, if not then redirect him to login page
  if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== $key){
  	header("Location: index.php");
    exit();
     }

// Delete Files
if(isset($_POST['delete_file'])) {
  $files .= $rootDir;
  $fileUrl = $_POST['file'];
  $files .= "/clients" . ltrim($fileUrl, '.');
  if($files !== FALSE){
    unlink($files);

    $files = [
      'status' => 200,
      'message' => 'File Entry Deleted Successfully'
    ];
    echo json_encode($files);
    return;
    }else {
      $files = [
        'status' => 500,
        'message' => 'File Entry Not Deleted'
      ];
      echo json_encode($files);
      return;
    }
}

// Delete Task
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

// Delete Task List
    if(isset($_POST['delete_list']))
    {

        //Get the list_id value from URL or Get Method
        $list_id = mysqli_real_escape_string($con, $_POST['list_id']);

        //Write the Query to DELETE List from DAtabase
        $sql = mysqli_prepare($con, "DELETE FROM task_lists WHERE list_id=?");
          mysqli_stmt_bind_param($sql, "i", $list_id);
        $sql->execute();

        if($sql) {
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
// Delete Client
    if(isset($_POST['delete_client']))
    {
        //Delete the List from database

        //Get the list_id value from URL or Get Method
        $name = mysqli_real_escape_string($con, $_POST['name']);

        //Write the Query to DELETE List from DAtabase
        $sql = mysqli_prepare($con, "DELETE FROM clients WHERE name=?");
          mysqli_stmt_bind_param($sql, "s", $name);
        $sql->execute();

        if($sql) {
          $res = [
              'status' => 200,
              'message' => 'Client Deleted Successfully'
          ];
          echo json_encode($res);
          return;
          } else{
              $res = [
                  'status' => 500,
                  'message' => 'Client Not Deleted'
              ];
              echo json_encode($res);
              return;
          }
        }
    // Delete Lead
        if(isset($_POST['delete_lead']))
        {
            //Delete the List from database

            //Get the list_id value from URL or Get Method
            $name = mysqli_real_escape_string($con, $_POST['name']);


            //Write the Query to DELETE List from DAtabase
            $sql = mysqli_prepare($con, "DELETE FROM leads WHERE name=?");
              mysqli_stmt_bind_param($sql, "s", $name);
            $sql->execute();

            if($sql) {
              $res = [
                  'status' => 200,
                  'message' => 'Lead Deleted Successfully'
              ];
              echo json_encode($res);
              return;
              } else{
                  $res = [
                      'status' => 500,
                      'message' => 'Lead Not Deleted'
                  ];
                  echo json_encode($res);
                  return;
              }
        }


?>
