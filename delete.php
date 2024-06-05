<?php
    require_once('./require/header.php');
    

$pdo = pdo_connect_mysql();
$msg = '';

// Check that the contact ID exists
if (isset($_GET['name'])) {
    // Select the record that is going to be deleted
    $stmt = $pdo->prepare('SELECT * FROM clients WHERE name = ?');
    $stmt->execute([$_GET['name']]);
    $contact = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$contact) {
        exit('Contact doesn\'t exist with that name!');
    }
    // Make sure the user confirms beore deletion
    if (isset($_GET['confirm'])) {
        if ($_GET['confirm'] == 'yes') {
            // User clicked the "Yes" button, delete record
            $stmt = $pdo->prepare('DELETE FROM clients WHERE name = ?');
            $stmt->execute([$_GET['name']]);
            $msg = 'The client was deleted successfully!';
            sleep(3);
            header('Location: clients.php');
        } else {
            // User clicked the "No" button, redirect them back to the read page
            header('Location: clients.php');
            exit;
        }
    }
} else {
    exit('No name specified!');
}
?>

<?=template_header('Delete')?>

<div class="content delete">
	<h2>Delete Contact <?=$contact['name']?></h2>
    <?php if ($msg): ?>
    <p><?=$msg?></p>
    <?php else: ?>
	<p>Are you sure you want to delete contact <?=$contact['name']?>?</p>
    <div class="yesno">
        <a href="delete.php?name=<?=$contact['name']?>&confirm=yes">Yes</a>
        <a href="delete.php?name=<?=$contact['name']?>&confirm=no">No</a>
    </div>
    <?php endif; ?>
</div>

