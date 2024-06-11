<?php
    require_once('./require/header.php');


?>

<?=template_header('Leads')?>
<div class="w3-content read">
  <div class="col-md-12" id="importFrm">
        <form action="./action/impcsv.php" method="post" enctype="multipart/form-data">
            <input type="file" class="file-upload" name="file" />
            <input type="submit" class="w3-btn" name="importSubmit" value="IMPORT">
        </form>
    </div>
 </div>

 <?php require_once('./require/footer.php');?>
