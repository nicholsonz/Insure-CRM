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
        $policy = (isset($_POST['policy']) && !empty($_POST['policy']) ? implode(',', $_POST['policy']) : '');
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

// $files = array_diff(scandir($path), array('.', '..'));
?>

<?=template_header('Read')?>

<div class="w3-content update w3-mobile">
<h1><?=$lead['name']?></h1>
    <div>
      <div class="w3-row">
        <div class="w3-col s12 m5 l5 w3-text-white">
        <form action="./action/upld.php?lead=<?=$lead['name']?>" method="post" enctype="multipart/form-data">
            Select file to upload:
            <input type="file" name="fileToUpload" id="fileToUpload">
            <input type="submit" value="Upload File" name="submit">
        </form>
        </div>
        <div id="fileTable" class="w3-col s12 m5 l5 read w3-text-white">
          <h3>Files</h3>
          <?php
              if(true == is_dir(rtrim(("./uplds/leads/$leadName")))) {
                $path = rtrim("./uplds/leads/$leadName");
                $files = scandir($path);
              if (is_array($files) || is_object($files))
                {
                foreach ($files as $file) {
                  $filePath = $path . '/' . $file;
                  if (is_file($filePath)) {
                    echo $file . "&nbsp " . " <a class='view' target='_blank' href='{$filePath}'><i class='fas fa-eye fa-xs'></i></a>" . "&nbsp" . "<button type='button' class='delFile trash' value='{$filePath}'><i class='fas fa-trash-alt fa-xs'></i></button>"."<br>";
                    }
                  }
                }
                }
            ?>
        </div>
      </div>
     <form action="updatelead.php?name=<?=$lead['name']?>" method="post">
       <div class="w3-row">
            <div class="w3-col s12 m5 l5" colspan="3">
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
                        echo "</select>";
                    ?>
            </div>
        </div>
        <div class="w3-row">
            <div class="w3-col s12 m12 l3 w3-margin-right">
                <input type="text" name="name" placeholder="Name" title="Name" value="<?=$lead['name']?>" id="name">
            </div>
            <div class="w3-col s12 m12 l3 w3-margin-right">
                <input type="text" name="email" placeholder="Email" title="Email" value="<?=$lead['email']?>" id="email">
            </div>
            <div class="w3-col s12 m12 l3 w3-margin-right">
                <input onfocus="(this.type='date')" name="birthdate" placeholder="Birthdate" title="Birth Date" value="<?=$lead['birthdate']?>" id="birthdate">
            </div>
        </div>
        <div class="w3-row">
            <div class="w3-col s12 m12 l3 w3-margin-right">
                <input type="text" name="address" placeholder="Street Address" title="Street Address" value="<?=$lead['address']?>" id="address">
            </div>
            <div class="w3-col s12 m12 l3 w3-margin-right">
                <input type="text" name="city" placeholder="City" title="City" value="<?=$lead['city']?>" id="city">
            </div>
        </div>
        <div class="w3-row">
            <div class="w3-col s12 m12 l3 w3-margin-right">
                <!-- <input type="text" name="state" placeholder="State" title="State" value="<?=$lead['state']?>" id="state"> -->
                <select name="state" id="state">
                    <option value="<?=$lead['state']?>"><?=$lead['state']?></option>
                    <option value="AL">Alabama</option>
                    <option value="AK">Alaska</option>
                    <option value="AZ">Arizona</option>
                    <option value="AR">Arkansas</option>
                    <option value="CA">California</option>
                    <option value="CO">Colorado</option>
                    <option value="CT">Connecticut</option>
                    <option value="DE">Delaware</option>
                    <option value="DC">Dist of Columbia</option>
                    <option value="FL">Florida</option>
                    <option value="GA">Georgia</option>
                    <option value="HI">Hawaii</option>
                    <option value="ID">Idaho</option>
                    <option value="IL">Illinois</option>
                    <option value="IN">Indiana</option>
                    <option value="IA">Iowa</option>
                    <option value="KS">Kansas</option>
                    <option value="KY">Kentucky</option>
                    <option value="LA">Louisiana</option>
                    <option value="ME">Maine</option>
                    <option value="MD">Maryland</option>
                    <option value="MA">Massachusetts</option>
                    <option value="MI">Michigan</option>
                    <option value="MN">Minnesota</option>
                    <option value="MS">Mississippi</option>
                    <option value="MO">Missouri</option>
                    <option value="MT">Montana</option>
                    <option value="NE">Nebraska</option>
                    <option value="NV">Nevada</option>
                    <option value="NH">New Hampshire</option>
                    <option value="NJ">New Jersey</option>
                    <option value="NM">New Mexico</option>
                    <option value="NY">New York</option>
                    <option value="NC">North Carolina</option>
                    <option value="ND">North Dakota</option>
                    <option value="OH">Ohio</option>
                    <option value="OK">Oklahoma</option>
                    <option value="OR">Oregon</option>
                    <option value="PA">Pennsylvania</option>
                    <option value="RI">Rhode Island</option>
                    <option value="SC">South Carolina</option>
                    <option value="SD">South Dakota</option>
                    <option value="TN">Tennessee</option>
                    <option value="TX">Texas</option>
                    <option value="UT">Utah</option>
                    <option value="VT">Vermont</option>
                    <option value="VA">Virginia</option>
                    <option value="WA">Washington</option>
                    <option value="WV">West Virginia</option>
                    <option value="WI">Wisconsin</option>
                    <option value="WY">Wyoming</option>
                    </select>
            </div>
            <div class="w3-col s12 m12 l3 w3-margin-right">
                <input type="text" name="zip" placeholder="Zip" title="Zip" value="<?=$lead['zip']?>" id="zip">
            </div>
            <div class="w3-col s12 m12 l3 w3-margin-right">
                <input type="text" name="county" placeholder="County" title="County" value="<?=$lead['county']?>" id="county">
            </div>
        </div>              
        <div class="w3-row">
            <div class="w3-col s12 m12 l3 w3-margin-right">
                <input type="text" name="phone" placeholder="Home Phone" title="Home Phone" value="<?=$lead['phone']?>" id="phone">
            </div>
            <div class="w3-col s12 m12 l3 w3-margin-right">
                <input type="text" name="phone_sec" placeholder="Mobile Phone" title="Secondary Phone" value="<?=$lead['phone_sec']?>" id="phone_sec">
            </div>
        </div>
        <div class="w3-row">
            <div class="w3-col s12 m12 l3 w3-margin-right">
                <input onfocus="(this.type='date')" name="partA_date" placeholder="Part A Date" title="PartA Date" value="<?=$lead['partA_date']?>" id="partA_date">
            </div>
            <div class="w3-col s12 m12 l3 w3-margin-right">
                <input onfocus="(this.type='date')" name="partB_date" placeholder="Part B Date" title="PartB Date" value="<?=$lead['partB_date']?>" id="partB_date">
            </div>
            <div class="w3-col s12 m12 l3 w3-margin-right">
                <input type="text" name="medicare_number" placeholder="Medicare Number" title="Medicare Number" value="<?=$lead['medicare_number']?>" id="medicare_number">
            </div>
        </div>
        <div class="w3-row">
            <div class="w3-col s12 m12 l3 w3-margin-right">
                <input type="text" name="insurer" placeholder="Insurer" value="<?=$lead['insurer']?>" id="insurer">
            </div>
            <div class="w3-col s12 m12 l3 w3-margin-right">
                <select id="policy" name="policy[]" multiple>
                    <option value="Policy" disabled selected>Policy</option>
                    <option value="Health" <?php if(str_contains($lead["policy"], "Health")){ echo "selected"; } ?>>Health</option>
                    <option value="Life" <?php if(str_contains($lead["policy"], "Life")){ echo "selected"; } ?>>Life</option>
                    <option value="Med Supp" <?php if(str_contains($lead["policy"], "Med Supp")){ echo "selected"; } ?>>Med Supp</option>
                    <option value="Med Adv" <?php if(str_contains($lead["policy"], "Med Adv")){ echo "selected"; } ?>>Med Adv</option>
                    <option value="Final Exp" <?php if(str_contains($lead["policy"], "Final Exp")){ echo "selected"; } ?>>Final Exp</option>
                    <option value="Hospital Ind" <?php if(str_contains($lead["policy"], "Hospital Ind")){ echo "selected"; } ?>>Hospital Ind</option>
                    <option value="Annuity" <?php if(str_contains($lead["policy"], "Annuity")){ echo "selected"; } ?>>Annuity</option>
                    <option value="DVH" <?php if(str_contains($lead["policy"], "DVH")){ echo "selected"; } ?>>DVH</option>
                </select>
            </div>
            <div class="w3-col s12 m12 l3 w3-margin-right">
                <select id="appstatus" name="appstatus">
                    <option value="Status" disabled selected>Status</option>
                    <option value="Enrolled" <?php if($lead["appstatus"] == "Enrolled"){ echo "selected"; } ?>>Enrolled</option>
                    <option value="Pending" <?php if($lead["appstatus"] == "Pending"){ echo "selected"; } ?>>Pending</option>
                    <option value="Accepted" <?php if($lead["appstatus"] == "Accepted"){ echo "selected"; } ?>>Accepted</option>
                    <option value="Denied" <?php if($lead["appstatus"] == "Denied"){ echo "selected"; } ?>>Denied</option>
                    <option value="Cancelled" <?php if($lead["appstatus"] == "Cancelled"){ echo "selected"; } ?>>Cancelled</option>
                </select>
            </div>
        </div>
        <div class="w3-row">
            <div class="w3-col s12 m12 l3 w3-margin-right">
                <textarea type="text" name="notes" placeholder="Notes" id="notes"><?=$lead['notes']?></textarea>
            </div>
        </div>
        <div class="w3-row">
            <div class="w3-col s12 m5 l5">
                <input type="hidden" name="created" value="<?=date('Y-m-d\TH:i', strtotime($lead['created']))?>" id="created">
            </div>
        </div>
        <div class="w3-row">
            <div class="w3-col s12 m12 l3 w3-margin-right">
                <input type="submit" value="Update">
            </div>
            <div class="w3-col s12 m12 l3 w3-margin-right w3-margin">
                <a href="./leads.php" class="w3-btn w3-orange w3-hover-amber">Cancel</a>
            </div> 
        </div>       
     </form>
        <?php if ($msg): ?>
        <p><?=$msg?></p>
        <?php endif; ?>
    </div>
</div>
<?php require_once('./require/footer.php');?>
