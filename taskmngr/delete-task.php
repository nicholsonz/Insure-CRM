<?php 
    require_once('../functions.php');
    
    //Check task_id in URL
    if(isset($_GET['task_id']))
    {
        //Delete the Task from Database
        //Get the Task ID
        $task_id = $_GET['task_id'];
                       
        //SElect Database
        $db_select = mysqli_select_db($con, DB_NAME) or die();
        
        //SQL Query to DELETE TASK
        $sql = "DELETE FROM tbl_tasks WHERE task_id=$task_id";
        
        //Execute Query
        $res = mysqli_query($con, $sql);
        
        //CHeck if the Query Executed Successfully or Not
        if($res==true)
        {
            //Query Executed Successfully and TAsk Deleted
            $_SESSION['delete'] = "Task Deleted Successfully.";
            
            //redirect to Homepage
            header('location: ./taskmngr.php');
        }
        else
        {
            //FAiled to Delete Task
            $_SESSION['delete_fail'] = "Failed to Delete Task";
            
            //Redirect to Home PAge
            header('location: ./taskmngr.php');
        }
        
    }
    else
    {
        //Redirect to Home
        header('location: ./taskmngr.php');
    }

?>