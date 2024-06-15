<?php
    require_once('./require/header.php');


$pdo = pdo_connect_mysql();
$msg = '';

// Check that the contact ID exists
if (isset($_GET['name'])) {
    // Select the record that is going to be deleted
    $stmt = $pdo->prepare('SELECT * FROM leads WHERE name = ?');
    $stmt->execute([$_GET['name']]);
    $lead = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$lead) {
        exit('Lead doesn\'t exist with that name!');
    }
    // Make sure the user confirms beore deletion
    if (isset($_GET['confirm'])) {
        if ($_GET['confirm'] == 'yes') {
            // User clicked the "Yes" button, delete record
            $stmt = $pdo->prepare('DELETE FROM leads WHERE name = ?');
            $stmt->execute([$_GET['name']]);
            $msg = 'You have deleted the lead!';
            header('Location: leads.php');
        } else {
            // User clicked the "No" button, redirect them back to the read page
            header('Location: leads.php');
            exit;
        }
    }
} else {
    exit('No name specified!');
}
?>

<?=template_header('Delete')?>

<div class="content delete">
	<h2>Delete Lead <?=$lead['name']?></h2>
    <?php if ($msg): ?>
    <p><?=$msg?></p>
    <?php else: ?>
	<p>Are you sure you want to delete lead <?=$lead['name']?>?</p>
    <div class="yesno">
        <a href="delete-lead.php?name=<?=$lead['name']?>&confirm=yes">Yes</a>
        <a href="delete-lead.php?name=<?=$lead['name']?>&confirm=no">No</a>
    </div>
    <?php endif; ?>
</div>
