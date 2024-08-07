<?php
    require_once('./require/header.php');

$pdo = pdo_connect_mysql();
$msg = '';

// Check that the contact ID exists
if (isset($_GET['name'])) {
    // Select the record that is going to be converted
    $stmt = $pdo->prepare('SELECT * FROM leads WHERE name = ?');
    $stmt->execute([$_GET['name']]);
    $lead = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$lead) {
        exit('Lead doesn\'t exist with that name!');
    }

    // Make sure the user confirms before conversion
    if (isset($_GET['confirm'])) {
        if ($_GET['confirm'] == 'yes') {
            // User clicked the "Yes" button, convert record
            $stmt = $pdo->prepare('INSERT INTO clients (acct_id, name, address, city, state, zip, county, birthdate, phone, phone_sec, email, partA_date, partB_date, medicare_number, policy, insurer, appstatus, notes, created)
                                   SELECT acct_id, name, address, city, state, zip, county, birthdate, phone, phone_sec, email, partA_date, partB_date, medicare_number, policy, insurer, appstatus, notes, created FROM leads WHERE name = ?');
            $stmt->execute([$_GET['name']]);
            $updstmt = $pdo->prepare('UPDATE `clients` SET created = current_timestamp WHERE name = ?');
            $updstmt->execute([$_GET['name']]);
            if ($updstmt == true){
            $delstmt = $pdo->prepare('DELETE FROM `leads` WHERE name = ?');
            $delstmt->execute([$_GET['name']]);
            }
            $msg = 'You have converted the lead!';
            sleep(3);
            header('Location: leads.php');
        } else {
            // User clicked the "No" button, redirect them back to the read page
            header('Location: leads.php');
            exit;
        }
    }
}
?>
<?=template_header('Convert')?>

<div class="content update">
    <div class="">
        <h2>Convert Lead <?= $lead['name']?></h2>
        <?php if ($msg): ?>
        <p><?=$msg?></p>
        <?php else: ?>
        <p>Are you sure you want to convert the lead <?= $lead['name']?>?</p>
        <div class="yesno">
            <a href="convertlead.php?name=<?= $lead['name']?>&confirm=yes">Yes</a>
            <a href="convertlead.php?name=<?= $lead['name']?>&confirm=no">No</a>
        </div>
    <?php endif; ?>
    </div>
</div>
<?php require_once('./require/footer.php');?>
