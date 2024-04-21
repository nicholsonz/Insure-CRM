<?php
require_once('./functions.php');
$pdo = pdo_connect_mysql();
$msg = '';
// Check that POST data is not empty
if (!empty($_POST)) {
    // Post data not empty insert a new record

    $name = isset($_POST['name']) ? $_POST['name'] : '';
    $address = isset($_POST['address']) ? $_POST['address'] : '';
    $city = isset($_POST['city']) ? $_POST['city'] : '';
    $state = isset($_POST['state']) ? $_POST['state'] : '';
    $zip = isset($_POST['zip']) ? $_POST['zip'] : '';
    $county = isset($_POST['county']) ? $_POST['county'] : '';
    $phone = isset($_POST['phone']) ? $_POST['phone'] : '';
    $phone2 = isset($_POST['phone_sec']) ? $_POST['phone_sec'] : '';
    $email = isset($_POST['email']) ? $_POST['email'] : '';
    $medicare_number = isset($_POST['medicare_number']) ? $_POST['medicare_number'] : '';
    $policy = isset($_POST['policy']) ? $_POST['policy'] : '';
    $insurer = isset($_POST['insurer']) ? $_POST['insurer'] : '';
    $appstatus = isset($_POST['appstatus']) ? $_POST['appstatus'] : '';
    $notes = isset($_POST['notes']) ? $_POST['notes'] : '';
    $created = isset($_POST['created']) ? $_POST['created'] : date('Y-m-d H:i:s');
    // Insert new record into the leads table
    $stmt = $pdo->prepare('INSERT INTO leads VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)');
    $stmt->execute([$name, $address, $city, $state, $zip, $county, $birthdate, $phone, $phone2, $email, $partA_date, $partB_date, $medicare_number, $policy, $insurer, $appstatus, $notes, $created]);
    // Output message
    $msg = 'Created Successfully!';
    header('Location: ./leads.php');
}
?>

<?=template_header('Create')?>

<div class="contentview update">
	<h2>Create Lead</h2>
    <form action="createlead.php" method="post">
<table>
    <tr>
        <td>
        <input type="text" name="name" placeholder="Name" id="name">
        </td>
   </tr>
    <tr>
        <td>
        <input type="text" name="address" placeholder="Street Address" id="address">
        </td>
    </tr>
    <tr>
        <td>
        <input type="text" name="city" placeholder="City" id="city">
        </td>
        <td>
        <input type="text" name="state" placeholder="State" id="state">
        </td>
        <td>
        <input type="text" name="zip" placeholder="Zip" id="zip">
</td>
</tr>
<td>
        <input type="text" name="county" placeholder="County" id="county">
</td>
    <td>
        <label>Birth Date</label>
        <input type="date" name="birthdate" value="0001-01-01" id="birthdate">
    </td>
</tr>
<tr>
    <td>
        <input type="text" name="phone" placeholder="Primary Phone" id="phone">
    </td>
    <td>
        <input type="text" name="phone_sec" placeholder="Secondary Phone" id="phone_sec">
    </td>
    <td>
        <input type="text" name="email" placeholder="Email" id="email">
    </td>
</tr>
<tr>
    <td>
        <label>Part A Date</label>        
        <input type="date" name="partA_date" placeholder="Part A Date" id="partA_date">
</td>
    <td>
        <label>Part B Date</label>
        <input type="date" name="partB_date" placeholder="Part B Date" id="partB_date">
    </td>
    <td>
        <input type="text" name="medicare_number" placeholder="Medicare Number" id="medicare_number">
    </td>
</tr>
<tr>
    <td>    
        <select name="policy" id="policy">
            <option value="Policy" disabled selected>Policy</option>
            <option value="Life">Life</option>
            <option value="Med Supp">Med Supp</option>
            <option value="Med Adv">Med Adv</option>
            <option value="Final Exp">Final Exp</option>
            <option value="Hospital Ind">Hospital Ind</option>
            <option value="Annuity">Annuity</option>
            <option value="DVH">DVH</option>
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
    <a href="./leads.php" class="w3-button w3-orange w3-hover-amber">Cancel</a>
</td>
</tr>
</table>
    </form>
    <?php if ($msg): ?>
    <p><?=$msg?></p>
    <?php endif; ?>
</div>

<?=template_footer()?>