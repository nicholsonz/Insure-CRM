<?php
include 'functions.php';
$pdo = pdo_connect_mysql();
$msg = '';
// Check if POST data is not empty
if (!empty($_POST)) {
    // Post data not empty insert a new record
    // Set-up the variables that are going to be inserted, we must check if the POST variables exist if not we can default them to blank
    $id = isset($_POST['id']) && !empty($_POST['id']) && $_POST['id'] != 'auto' ? $_POST['id'] : NULL;
    // Check if POST variable "name" exists, if not default the value to blank, basically the same for all variables
    $name = isset($_POST['name']) ? $_POST['name'] : '';
    $address = isset($_POST['address']) ? $_POST['address'] : '';
    $city = isset($_POST['city']) ? $_POST['city'] : '';
    $state = isset($_POST['state']) ? $_POST['state'] : '';
    $zip = isset($_POST['zip']) ? $_POST['zip'] : '';
    $county = isset($_POST['county']) ? $_POST['county'] : '';
    $birthdate = isset($_POST['birthdate']) ? $_POST['birthdate'] : date('mm-dd-yyyy');
    $phone = isset($_POST['phone']) ? $_POST['phone'] : '';
    $email = isset($_POST['email']) ? $_POST['email'] : '';
    $partA_date = isset($_POST['partA_date']) ? $_POST['partA_date'] : date('mm-dd-yyyy');
    $partB_date = isset($_POST['partB_date']) ? $_POST['partB_date'] : date('mm-dd-yyyy');
    $medicare_number = isset($_POST['medicare_number']) ? $_POST['medicare_number'] : '';
    $policy = isset($_POST['policy']) ? $_POST['policy'] : '';
    $insurer = isset($_POST['insurer']) ? $_POST['insurer'] : '';
    $appstatus = isset($_POST['appstatus']) ? $_POST['appstatus'] : '';
    $notes = isset($_POST['notes']) ? $_POST['notes'] : '';
    $created = isset($_POST['created']) ? $_POST['created'] : date('Y-m-d H:i:s');
    // Insert new record into the contacts table
    $stmt = $pdo->prepare('INSERT INTO contacts VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)');
    $stmt->execute([$id, $name, $address, $city, $state, $zip, $county, $birthdate, $phone, $email, $partA_date, $partB_date, $medicare_number, $policy, $insurer, $appstatus, $notes, $created]);
    // Output message
    $msg = 'Created Successfully!';
}
?>

<?=template_header('Create')?>

<div class="content update">
	<h2>Create Client</h2>
    <form action="createclient.php" method="post">
        <label for="id">ID</label>
        <input type="text" name="id" placeholder="26" value="auto" id="id">
        <label for="name">Name</label>
        <input type="text" name="name" placeholder="John Doe" id="name">
        <label for="address">Address</label>
        <input type="text" name="address" placeholder="street address" id="address">
        <label for="city">City</label>
        <input type="text" name="city" placeholder="city" id="city">
        <label for="state">State</label>
        <input type="text" name="state" placeholder="state" id="state">
        <label for="zip">Zip</label>
        <input type="text" name="zip" placeholder="zip code" id="zip">
        <label for="county">County</label>
        <input type="text" name="county" placeholder="county" id="county">
        <label for="title">Birth Date</label>
        <input type="date" name="birthdate" id="birthdate">
        <label for="partA_date">Part A</label>
        <input type="date" name="partA_date" id="partA_date">
        <label for="partB_date">Part B</label>
        <input type="date" name="partB_date" id="partB_date">
        <label for="medicare_number">Medicare Number</label>
        <input type="text" name="medicare_number" id="medicare_number">
        <label for="phone">Phone</label>
        <input type="text" name="phone" placeholder="2025550143" id="phone">
        <label for="email">Email</label>
        <input type="text" name="email" placeholder="johndoe@example.com" id="email">
        
        <label for="policy">Policy</label>
        <select id="policy" name="policy">
            <option value="Life">Life</option>
            <option value="Med Supp">Med Supp</option>
            <option value="Med Adv">Med Adv</option>
            <option value="Final Exp">Final Exp</option>
            <option value="Hospital Ind">Hospital Ind</option>
            <option value="Annuity">Annuity</option>
            <option value="DVH">DVH</option>
        </select>
        <label for="insurer">Insurer</label>
        <input type="text" name="insurer" placeholder="insurer" id="insurer">
        <label for="appstatus">App Status</label>
        <select id="appstatus" name="appstatus">
            <option value="Pending">Pending</option>
            <option value="Accepted">Accepted</option>
            <option value="Denied">Denied</option>
            <option value="Cancelled">Cancelled</option>
        </select>
        <label for="notes">Notes</label>
        <input type="text" name="notes" id="notes">
        <label for="created">Created</label>
        <input type="datetime-local" name="created" value="<?=date('Y-m-d\TH:i')?>" id="created">
        <input type="submit" value="Create">
    </form>
    <?php if ($msg): ?>
    <p><?=$msg?></p>
    <?php endif; ?>
</div>

<?=template_footer()?>