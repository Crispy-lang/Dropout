<!-- Delete -->
<div class="modal fade" id="delete_<?php echo $row['transfer_id']; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <center><h4 class="modal-title" id="myModalLabel">Remove Option Information </h4></center>
            </div>
            <div class="modal-body">	
            	<p class="text-center">Are you sure you want to Send to school</p>
				<h2 class="text-center"><?php echo $row['Fname'].' [ '.$row['Lname']; ?>]</h2>
			</div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span> Cancel</button>
                <a href="view_rehab_student.php?stid=<?php echo $row['transfer_id']; ?>" class="btn btn-danger"><span class="glyphicon glyphicon-trash"></span> Yes</a>
            </div>

        </div>
    </div>
</div>