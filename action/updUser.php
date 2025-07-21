<?php 
require '../include/config.php';


if(isset($_GET['id']))
{
    $id = $_GET['id'];

    $get_id = mysqli_prepare($con, "SELECT id, username, email, acct_type FROM accounts WHERE id=?");
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

if(isset($_POST['update_user']))
{     
    $id = $_POST['id'];
    $username = $_POST['username'];
    $email = $_POST['email'];
    $acct_type = $_POST['acct_type'];

    if($username == NULL || $email = NULL || $acct_type = NULL)
    {
        $res = [
            'status' => 422,
            'message' => 'All fields are mandatory'
        ];
        echo json_encode($res);
        return;
    }
    
    $upd_user = mysqli_prepare($con, "UPDATE accounts SET username=?, email=?, acct_type=? WHERE id=?");
      mysqli_stmt_bind_param($upd_user, "sssi", $username, $email, $acct_type, $id);
    $upd_user->execute();

    if($upd_user)
    {
        $res = [
            'status' => 200,
            'message' => 'User Updated Successfully'
        ];
        echo json_encode($res);
        return;
    }
    else
    {
        $res = [
            'status' => 500,
            'message' => 'User Not Updated'
        ];
        echo json_encode($res);
        return;
    }
}


?>