<?php 
require '../include/config.php';

// We need to use sessions, so you should always start sessions using the below code.
if (!session_start() || session_status() === PHP_SESSION_NONE) {
  session_start();
}

if(isset($_GET['id']))
{
    $id = $_GET['id'];

    $get_id = mysqli_prepare($con, "SELECT id, policy, descr, other FROM policies WHERE id=?");
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

if(isset($_POST['update_pol']))
{     
    $id = $_POST['id'];
    $policy = $_POST['policy'];
    $descr = $_POST['descr'];
    $other = $_POST['other'];

    if($policy == NULL || $descr = NULL)
    {
        $res = [
            'status' => 422,
            'message' => 'All fields are mandatory'
        ];
        echo json_encode($res);
        return;
    }
    
    $upd_pol = mysqli_prepare($con, "UPDATE policies SET policy=?, descr=?, other=? WHERE id=?");
      mysqli_stmt_bind_param($upd_pol, "sssi", $policy, $descr, $other, $id);
    $upd_pol->execute();

    if($upd_pol)
    {
        $res = [
            'status' => 200,
            'message' => 'Policy Updated Successfully'
        ];
        echo json_encode($res);
        return;
    }
    else
    {
        $res = [
            'status' => 500,
            'message' => 'Policy Not Updated'
        ];
        echo json_encode($res);
        return;
    }
}

if(isset($_POST['add_pol']))
{     
    $id = $_POST['id'];
    $policy = $_POST['policy'];
    $descr = $_POST['descr'];
    $other = $_POST['other'];

    if($policy == NULL || $descr = NULL)
    {
        $res = [
            'status' => 422,
            'message' => 'All fields are mandatory'
        ];
        echo json_encode($res);
        return;
    }
    
    $upd_pol = mysqli_prepare($con, "INSERT INTO policies (policy, descr, other) VALUES(?,?,?) WHERE id=?");
      mysqli_stmt_bind_param($upd_pol, "sssi", $policy, $descr, $other, $id);
    $upd_pol->execute();

    if($upd_pol)
    {
        $res = [
            'status' => 200,
            'message' => 'Policy Updated Successfully'
        ];
        echo json_encode($res);
        return;
    }
    else
    {
        $res = [
            'status' => 500,
            'message' => 'Policy Not Updated'
        ];
        echo json_encode($res);
        return;
    }
}

?>