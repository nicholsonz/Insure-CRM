<?php
    require_once('./require/header.php');
    
$pdo = pdo_connect_mysql();
$msg = '';

// Check that POST data is not empty
if (!empty($_POST)) {
    // Post data not empty insert a new record
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
    // Insert new record into the clients table
    $stmt = $pdo->prepare('INSERT INTO clients VALUES (DEFAULT, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)');
    $stmt->execute([$acct_id, $name, $address, $city, $state, $zip, $county, $birthdate, $phone, $phone2, $email, $partA_date, $partB_date, $medicare_number, $policy, $insurer, $appstatus, $notes, $created]);
    // Output message
    $msg = 'Created Successfully!';
    header('Location: ./clients.php');
}
?>

<?=template_header('Create')?>

<div class="content update">
	<h1>Create Client</h1>
    <div class="">
    <form action="createclient.php" method="post">
<table>
<tr>
    <td><label>Name</label>
        <input type="text" name="name" placeholder="Name" id="name">
    </td>
    <td><label>Email</label>
        <input type="text" name="email" placeholder="Email" id="email">
    </td>
    <td><label>Birthdate</label>
        <input type="date" name="birthdate" placeholder="Birthdate" id="birthdate">
    </td>
</tr>
<tr>
    <td><label>Address</label>
        <input type="text" name="address" placeholder="Street Address" id="address">
    </td>
</tr>
<tr>
    <td><label>City</label>
        <input type="text" name="city" placeholder="City" id="city">
</td>
    <td>    <label>State</label>
        <input type="text" name="state" placeholder="State" id="state">
    </td>
    <td><label>Zip</label>
        <input type="text" name="zip" placeholder="Zip" id="zip">
    </td>
</tr>
<tr>
    <td><label>County</label>
        <input type="text" name="county" placeholder="County" id="county">
    </td>
</tr>
<tr>
    <td><label>Home</label>
        <input type="text" name="phone" placeholder="Home Phone" id="phone">
    </td>
    <td><label>Mobile</label>
        <input type="text" name="phone_sec" placeholder="Mobile Phone" id="phone_sec">
    </td>
</tr>
<tr>
    <td><label>Part A</label>
        <input type="date" name="partA_date" placeholder="Part A Date" id="partA_date">
    </td>
<td><label>Part B</label>
        <input type="date" name="partB_date" placeholder="Part B Date" id="partB_date">
</td>
<td><label>Medicare</label>
        <input type="text" name="medicare_number" placeholder="Medicare Number" id="medicare_number">
        
</td>
</tr>
<tr>
<td>
	<label>Insurer</label>
        <input type="text" name="insurer" placeholder="Insurer" id="insurer">
</td>
    <td><label>Policy</label>
        <select name="policy" id="policy">
            <option value="Policy" disabled selected>Policy</option>
            <option value="Health">Health</option>
            <option value="Life">Life</option>
            <option value="Med Supp">Med Supp</option>
            <option value="Med Adv">Med Adv</option>
            <option value="Final Exp">Final Exp</option>
            <option value="Hospital Ind">Hospital Ind</option>
            <option value="Annuity">Annuity</option>
            <option value="DVH">DVH</option>
        </select>
    </td>
<td><label>Status</label>
        <select id="appstatus" name="appstatus">
            <option value="Status" disabled selected>Status</option>
            <option value="Active Lead">Active Lead</option>
            <option value="Lost Lead">Lost Lead</option>
            <option value="Enrolled">Enrolled</option>
            <option value="Pending">Pending</option>
            <option value="Accepted">Accepted</option>
            <option value="Denied">Denied</option>
            <option value="Cancelled">Cancelled</option>
        </select>
</td>
</tr>
<tr>
<td colspan="2">
        <textarea type="text" name="notes" placeholder="Notes" id="notes"></textarea>
</td>
<td>
        <input type="datetime-local" name="created" value="<?=date('Y-m-d\TH:i')?>" id="created">
</td>
</tr>
<tr>
<td>
   	<input type="submit" value="Create">
</td>
<td>
    <a href="./clients.php" class="w3-button w3-orange w3-hover-amber">Cancel</a>
</td>
</tr>
</table>
    </form>
</div>
</div>
<?php require_once('./require/footer.php');?>
