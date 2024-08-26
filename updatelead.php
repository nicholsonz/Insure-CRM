<?php
    require_once('./require/header.php');

$pdo = pdo_connect_mysql();
$msg = '';
// Check if the lead exists
if (isset($_GET['name'])) {
    if (!empty($_POST)) {
        // This part is similar to the create.php, but instead we update a record and not insert
  	    $acct_id = (isset($_POST['acct_id']) && !empty($_POST['acct_id']) ? $_POST['acct_id'] : '');
  	    $name = (isset($_POST['name']) && !empty($_POST['name']) ? $_POST['name'] : '');
        $address = (isset($_POST['address']) && !empty($_POST['address']) ? $_POST['address'] : '');
        $city = (isset($_POST['city']) && !empty($_POST['city']) ? $_POST['city'] : '');
        $state = (isset($_POST['state']) && !empty($_POST['state']) ? $_POST['state'] : '');
        $zip = (isset($_POST['zip']) && !empty($_POST['zip']) ? $_POST['zip'] : '');
        $county = (isset($_POST['county']) && !empty($_POST['county']) ? $_POST['county'] : '');
        $birthdate = (isset($_POST['birthdate']) && !empty($_POST['birthdate']) ? $_POST['birthdate'] : NULL);
        $email = (isset($_POST['email']) && !empty($_POST['email']) ? $_POST['email'] : '');
        $phone = (isset($_POST['phone']) && !empty($_POST['phone']) ? $_POST['phone'] : '');
        $phone2 = (isset($_POST['phone_sec']) && !empty($_POST['phone_sec']) ? $_POST['phone_sec'] : '');
        $partA_date = (isset($_POST['partA_date']) && !empty($_POST['partA_date']) ? $_POST['partA_date'] : NULL);
        $partB_date = (isset($_POST['partB_date']) && !empty($_POST['partB_date']) ? $_POST['partB_date'] : NULL);
        $medicare_number = (isset($_POST['medicare_number']) && !empty($_POST['medicare_number']) ? $_POST['medicare_number'] : '');
        $policy = (isset($_POST['policy']) && !empty($_POST['policy']) ? $_POST['policy'] : '');
        $insurer = (isset($_POST['insurer']) && !empty($_POST['insurer']) ? $_POST['insurer'] : '');
        $appstatus = (isset($_POST['appstatus']) && !empty($_POST['appstatus']) ? $_POST['appstatus'] : '');
        $notes = (isset($_POST['notes']) && !empty($_POST['notes']) ? $_POST['notes'] : '');
        $created = (isset($_POST['created']) && !empty($_POST['created']) ? $_POST['created'] : date('Y-m-d H:i:s'));
        // Update the record
        $stmt = $pdo->prepare('UPDATE leads SET acct_id = ?, name = ?, address = ?, city = ?, state = ?, zip = ?, county = ?, birthdate = ?, email = ?, phone = ?, phone_sec = ?, partA_date = ?, partB_date = ?, medicare_number = ?, policy = ?, insurer = ?, appstatus = ?, notes = ?, created = ? WHERE name = ?');
        $stmt->execute([$acct_id, $name, $address, $city, $state, $zip, $county, $birthdate, $email, $phone, $phone2, $partA_date, $partB_date, $medicare_number, $policy, $insurer, $appstatus, $notes, $created, $_GET['name']]);
        $msg = 'Updated Successfully!';
        header('Location: ./leads.php');
    }
    // Get the lead from the leads table
    $stmt = $pdo->prepare('SELECT * FROM leads WHERE name = ?');
    $stmt->execute([$_GET['name']]);
    $lead = $stmt->fetch(PDO::FETCH_ASSOC);

    $_SESSION['leadName'] = $lead['name'];
    $leadName = $lead['name'];

    if (!$lead) {
        exit('Lead doesn\'t exist with that Phone #!');
    }
} else {
    exit('No Phone # specified!');
}

$path    = "./uplds/leads/$leadName";
$files = scandir($path);
// $files = array_diff(scandir($path), array('.', '..'));
?>

<?=template_header('Read')?>

<div class="w3-content update w3-mobile">
<h1><?=$lead['name']?></h1>
    <div class="">
      <div class="w3-row">
        <div class="w3-col s12 m5 l5">
        <form action="./action/upld.php?lead=<?=$lead['name']?>" method="post" enctype="multipart/form-data">
            Select file to upload:
            <input type="file" name="fileToUpload" id="fileToUpload">
            <input type="submit" value="Upload File" name="submit">
        </form>
        </div>
        <div id="fileTable" class="w3-col s12 m5 l5 read">
          <h3>Files</h3>
          <?php
          foreach ($files as $file) {
            $filePath = $path . '/' . $file;
            if (is_file($filePath)) {
              echo $file . "&nbsp " . " <button class='view' target='_blank' href='{$filePath}'><i class='fas fa-eye fa-xs'></i></button>" . "&nbsp" . "<button type='button' class='delFile trash' value='{$filePath}'><i class='fas fa-trash-alt fa-xs'></i></button>"."<br>";
            }
          }
            ?>
        </div>
      </div>
    <form action="updatelead.php?name=<?=$lead['name']?>" method="post">
      <table>
        <tr>
            <td colspan="2">
                <label>Agent</label>
                <?php
                    $sqlagent = "SELECT id, username
                                FROM accounts
                                ORDER BY username DESC";

                    $result = mysqli_query($con, $sqlagent);

                    echo "<select class='form-select' name='acct_id' id='acct_id'>";

                        while($row = mysqli_fetch_assoc($result))
                        {
                            if($acct_id == $row['id']){
                            echo "<option value='".$row['id']."' selected>" . $row['username'] . "</option>";
                            }else{
                            echo "<option value='" . $row['id'] . "'>" . $row['username'] . "</option>";

                            }
                        }
                        echo "</select></td>";
                    ?>
            </td>
        </tr>
        <tr>
            <td><label>Name</label>
                <input type="text" name="name" placeholder="Name" value="<?=$lead['name']?>" id="name">
            </td>
            <td><label>Email</label>
                <input type="text" name="email" placeholder="Email" value="<?=$lead['email']?>" id="email">
            </td>
            <td><label>Birthdate</label>
                <input type="date" name="birthdate" placeholder="Birthdate" value="<?=$lead['birthdate']?>" id="birthdate">
            </td>
        </tr>
        <tr>
            <td><label>Address</label>
                <input type="text" name="address" placeholder="Street Address" value="<?=$lead['address']?>" id="address">
            </td>
        </tr>
        <tr>
            <td><label>City</label>
                <input type="text" name="city" placeholder="City" value="<?=$lead['city']?>" id="city">
        </td>
            <td>    <label>State</label>
                <input type="text" name="state" placeholder="State" value="<?=$lead['state']?>" id="state">
            </td>
            <td><label>Zip</label>
                <input type="text" name="zip" placeholder="Zip" value="<?=$lead['zip']?>" id="zip">
            </td>
        </tr>
        <tr>
            <td><label>County</label>
                <input type="text" name="county" placeholder="County" value="<?=$lead['county']?>" id="county">
            </td>
        </tr>
        <tr>
            <td><label>Home</label>
                <input type="text" name="phone" placeholder="Home Phone" value="<?=$lead['phone']?>" id="phone">
            </td>
            <td><label>Mobile</label>
                <input type="text" name="phone_sec" placeholder="Mobile Phone" value="<?=$lead['phone_sec']?>" id="phone_sec">
            </td>
        </tr>
        <tr>
            <td><label>Part A</label>
                <input type="date" name="partA_date" placeholder="Part A Date" value="<?=$lead['partA_date']?>" id="partA_date">
            </td>
        <td><label>Part B</label>
                <input type="date" name="partB_date" placeholder="Part B Date" value="<?=$lead['partB_date']?>" id="partB_date">
        </td>
        <td><label>Medicare</label>
                <input type="text" name="medicare_number" placeholder="Medicare Number" value="<?=$lead['medicare_number']?>" id="medicare_number">

        </td>
        </tr>
        <tr>
        <td>
            <label>Insurer</label>
                <input type="text" name="insurer" placeholder="Insurer" value="<?=$lead['insurer']?>" id="insurer">
        </td>
            <td><label>Policy</label>
                <select id="policy" name="policy">
                    <option value="Policy" disabled selected>Policy</option>
                    <option <?php if($lead["policy"] == "Health"){ echo "selected"; } ?>>Health</option>
                    <option <?php if($lead["policy"] == "Life"){ echo "selected"; } ?>>Life</option>
                    <option <?php if($lead["policy"] == "Med Supp"){ echo "selected"; } ?>>Med Supp</option>
                    <option <?php if($lead["policy"] == "Med Adv"){ echo "selected"; } ?>>Med Adv</option>
                    <option <?php if($lead["policy"] == "Final Exp"){ echo "selected"; } ?>>Final Exp</option>
                    <option <?php if($lead["policy"] == "Hospital Ind"){ echo "selected"; } ?>>Hospital Ind</option>
                    <option <?php if($lead["policy"] == "Annuity"){ echo "selected"; } ?>>Annuity</option>
                    <option <?php if($lead["policy"] == "DVH"){ echo "selected"; } ?>>DVH</option>
                </select>
        </td>
        <td><label>Status</label>
                <select id="appstatus" name="appstatus">
                    <option value="Status" disabled selected>Status</option>
                    <option value="Enrolled" <?php if($lead["appstatus"] == "Enrolled"){ echo "selected"; } ?>>Enrolled</option>
                    <option value="Pending" <?php if($lead["appstatus"] == "Pending"){ echo "selected"; } ?>>Pending</option>
                    <option value="Accepted" <?php if($lead["appstatus"] == "Accepted"){ echo "selected"; } ?>>Accepted</option>
                    <option value="Denied" <?php if($lead["appstatus"] == "Denied"){ echo "selected"; } ?>>Denied</option>
                    <option value="Cancelled" <?php if($lead["appstatus"] == "Cancelled"){ echo "selected"; } ?>>Cancelled</option>
                </select>
        </td>
        </tr>
        <tr>
            <td colspan="2"><label>Notes</label>
                <textarea type="text" name="notes" placeholder="Notes" id="notes"><?=$lead['notes']?></textarea>
        </td>
        <td>
            <label>Created</label>
                <input type="datetime-local" name="created" value="<?=date('Y-m-d\TH:i', strtotime($lead['created']))?>" id="created">
        </td>
        </tr>
        <tr>
            <td>
                <input type="submit" value="Update">
            </td>
            <td>
                <a href="./leads.php" class="w3-button w3-orange w3-hover-amber">Cancel</a>
            </td>
        </tr>
      </table>
    </form>

    <?php if ($msg): ?>
    <p><?=$msg?></p>
    <?php endif; ?>
</div>
</div>
<?php require_once('./require/footer.php');?>
