<?php
    require_once('./require/header.php');


if($rowchk['acct_type'] == "Admin"){   
    include('./admnstr/admin_sql.php');
} else {
    include('./action/user_sql.php');
}
// Home Page template below.

?>

<?=template_header('Task Mngr')?>
<!-- Edit Income Modal -->
<div class="modal fade" id="taskEditModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Edit Task</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form id="updateTask">
            <div class="modal-body">
                <div id="errorMessageUpdate" class="alert alert-warning d-none">
                </div>
                <input type="hidden" name="task_id" id="task_id" > 
                <div class="row">                    
                    <div class="col-md-5">
                        <label for="acct_id">User</label>
                        <?php 
                                    echo "<select class='form-select' name='acct_id' id='acct_id'>"; 
                        if($rowchk['acct_type'] == "Admin"){ 
                            while($row = $res_user->FETCH_ASSOC()){ 
                                echo "<option value='" . htmlspecialchars($row['acct_id']) . "'>" . htmlspecialchars($row['username']) . "</option>";
                            }
                        }else {
                            while($row = $res_acctid->FETCH_ASSOC()) {
                                if($row['acct_id'] = $acct_id){
                                echo "<option value='" . htmlspecialchars($row['acct_id']) . "'>" . htmlspecialchars($row['username']) . "</option>";
                                }
                            }
                        }
                            echo "</select>"
                        ?>
                    </div> <div class="col-md-6">
                    <label for="list_id">Task</label>
                        <?php 
                                    echo "<select class='form-select' name='list_id' id='list_id'>"; 
                        if($rowchk['acct_type'] == "Admin"){ 
                            while($row = $res_listnm->FETCH_ASSOC()){ 
                                echo "<option value='" . htmlspecialchars($row['list_id']) . "'>" . htmlspecialchars($row['list_name']) . "</option>";
                            }
                        }else {
                            while($row = $res_listnm->FETCH_ASSOC()) {
                                if($row['acct_id'] == $acct_id){
                                echo "<option value='" . htmlspecialchars($row['list_id']) . "'>" . htmlspecialchars($row['list_name']) . "</option>";
                                }
                            }
                        }
                            echo "</select>"
                        ?>
                </div>
                    <div class="col-md6">
                        <label for="object">Name/Object</label>
                        <input type="text" name="object" id="object" class="form-control" />
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-11">
                        <label for="details">Details</label>
                        <textarea rows="20" cols="30" name="details" id="details" class="form-control"></textarea>
                    </div>
                </div>               
                <div class="mb-3">
                    <label for="priority">Priority</label>
                        <?php 
                                    echo "<select class='form-select' name='$column_prty' id='$column_prty'>"; 
                        if($rowchk['acct_type'] == "Admin"){ 
                            foreach($enumPrty as $prty) {
                                echo "<option value='$prty'>" . $prty . "</option>";
                             } 
                            }else {
                            foreach($enumPrty as $prty) {
                                echo "<option value='$prty'>" . $prty . "</option>";
                                }
                            }
                            echo "</select>"
                        ?>
                </div>
                <div class="mb-3">
                    <label for="deadline">Deadline</label>
                    <input type="datetime-local" name="deadline" id="deadline" class="form-control" />
                </div>
                <div class="mb-3">
                    <label for="type">Type</label>
                        <?php 
                                    echo "<select class='form-select' name='$column_type' id='$column_type'>"; 
                        if($rowchk['acct_type'] == "Admin"){ 
                            foreach($enumType as $type) {
                                echo "<option value='$type'>" . $type . "</option>";
                             } 
                            }else {
                            foreach($enumType as $type) {
                                echo "<option value='$type'>" . $type . "</option>";
                                }
                            }
                            echo "</select>"
                        ?>
                </div>                
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Update</button>
            </div>
        </form>
        </div>
    </div>
</div>
<div class="w3-content w3-mobile">
    <h1>TASK MANAGER</h1>
	<div class="w3-col s12 m12 l12 w3-camo-fade w3-margin w3-border w3-round w3-border-blue-grey w3-pannel w3-card-4">
    <div class="task-mngr">
        <a href="./manage-list.php">Manage Lists</a>
    </div>
     <div class="">
     </div>
        <a href="./add-task.php" class="add-task">Add Task</a>
      <div id="taskTable">
        <div class="table-viewer tableFixHead" id="taskTable">
        <table class="w3-table w3-hoverable" id="srtTable">
         <thead>
            <tr>
                <!-- <th>S.N.</th> -->
                <th><a href="javascript:SortTable(0,'T');">Task <i class="fa fa-sort"></th>
                <th><a href="javascript:SortTable(1,'T');">Name/Object <i class="fa fa-sort"></th>
                <th>Details</th>
                <th>Priority</th>
                <th><a href="javascript:SortTable(5,'D','dmyy');">Deadline <i class="fa fa-sort"></a></th>
                <th><a href="javascript:SortTable(6,'T');">Type <i class="fa fa-sort"></a></th>
                <th></th>
            </tr>
         </thead>
        <tbody id="tblSrch">
            <?php while ($row = $result->FETCH_ASSOC()): ?>

            <tr>
                <td><?= htmlspecialchars($row['list_name']) ?></td>
                <td><?= htmlspecialchars($row['object']) ?></td>
                <td><?= htmlspecialchars($row['details']) ?></td>
                <td><?= htmlspecialchars($row['priority']) ?></td>
                <td><?= date('m-d-Y H:i A', strtotime($row['deadline'])) ?></td>
                <td><?= htmlspecialchars($row['type']) ?></td>
                <td class="actions">
                    <a href="./update-task.php?task_id=<?= $row['task_id'] ?>" class="w3-btn edit"><i class="fas fa-edit fa-xs"></i></a>
                    <!-- <button type="button" value="<?=$row['task_id'];?>" class="editTaskBtn w3-btn edit"><i class="fas fa-edit fa-xs"></i></button> -->
                    <button type="button" value="<?=$row['task_id'];?>" class="w3-btn delTask trash"><i class="fas fa-trash fa-xs"></i></button>

                </td>
            </tr>
            <?php endwhile; ?>
        </tbody>
        </table>
        </div>
      </div>
<!-- Pagination
     <?php if (ceil($total_pages / $records_per_page) > 0): ?>
        <ul class="pagination">
            <?php if ($page > 1): ?>
            <li class="prev"><a href="taskmngr.php?page=<?php echo $page-1 ?>">Prev</a></li>
            <?php endif; ?>

            <?php if ($page > 3): ?>
            <li class="start"><a href="taskmngr.php?page=1">1</a></li>
            <li class="dots">...</li>
            <?php endif; ?>

            <?php if ($page-2 > 0): ?><li class="page"><a href="taskmngr.php?page=<?php echo $page-2 ?>"><?php echo $page-2 ?></a></li><?php endif; ?>
            <?php if ($page-1 > 0): ?><li class="page"><a href="taskmngr.php?page=<?php echo $page-1 ?>"><?php echo $page-1 ?></a></li><?php endif; ?>

            <li class="currentpage"><a href="taskmngr.php?page=<?php echo $page ?>"><?php echo $page ?></a></li>

            <?php if ($page+1 < ceil($total_pages / $records_per_page)+1): ?><li class="page"><a href="taskmngr.php?page=<?php echo $page+1 ?>"><?php echo $page+1 ?></a></li><?php endif; ?>
            <?php if ($page+2 < ceil($total_pages / $records_per_page)+1): ?><li class="page"><a href="taskmngr.php?page=<?php echo $page+2 ?>"><?php echo $page+2 ?></a></li><?php endif; ?>

            <?php if ($page < ceil($total_pages / $records_per_page)-2): ?>
            <li class="dots">...</li>
            <li class="end"><a href="taskmngr.php?page=<?php echo ceil($total_pages / $records_per_page) ?>"><?php echo ceil($total_pages / $records_per_page) ?></a></li>
            <?php endif; ?>

            <?php if ($page < ceil($total_pages / $records_per_page)): ?>
            <li class="next"><a href="taskmngr.php?page=<?php echo $page+1 ?>">Next</a></li>
            <?php endif; ?>
        </ul>
    <?php endif; ?>
End Pagination-->
    </div>
</div>

<?php require_once('./require/footer.php');?>
