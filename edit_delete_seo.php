<!-- Edit -->
<div class="modal fade" id="edit_<?php echo $row['sector_id']; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <center><h4 class="modal-title" id="myModalLabel">Set SEO Infromation</h4></center>
            </div>
            <div class="modal-body">
			<div class="container-fluid">
			<form method="POST" action="new_seo.php?sec=<?php echo $row['sector_id']; ?>">
				<div class="row form-group">
					<div class="col-sm-3">
						<label class="control-label" style="position:relative; top:7px;">Location:</label>
					</div>
					<div class="col-sm-8">
						<input type="text" class="form-control" name="comb" value="<?php echo $row['district_name'] .' - '. $row['sector_name']; ?>"/>
					</div>
				</div>
				<div class="row form-group">
					<div class="col-sm-3">
						<label class="control-label" style="position:relative; top:7px;"> Names :</label>
					</div>
					<div class="col-sm-8">
						<input type="text" required pattern="[A-Za-z]{3,15}" class="form-control" name="name" value="<?php echo @$_POST['name']; ?>">
					</div>
				</div>

                <div class="row form-group">
                    <div class="col-sm-3">
                        <label class="control-label" style="position:relative; top:7px;"> Phone no :</label>
                    </div>
                    <div class="col-sm-8">
                        <input type="text" required pattern="^07[2,3,8]{1}[0-9]{7}" class="form-control" name="phone" value="<?php echo @$_POST['phone']; ?>">
                    </div>
                </div>

                <div class="row form-group">
                    <div class="col-sm-3">
                        <label class="control-label" style="position:relative; top:7px;"> Identity no :</label>
                    </div>
                    <div class="col-sm-8">
                        <input type="text" required pattern="[0-9]{16}" class="form-control" name="id" value="<?php echo @$_POST['id']; ?>">
                    </div>
                </div>

                <div class="row form-group">
                    <div class="col-sm-3">
                        <label class="control-label" style="position:relative; top:7px;"> Username :</label>
                    </div>
                    <div class="col-sm-8">
                        <input type="text" required pattern="[a-z0-9]{3,12}" class="form-control" name="user" value="<?php echo @$_POST['user']; ?>">
                    </div>
                </div>

                <div class="row form-group">
                    <div class="col-sm-3">
                        <label class="control-label" style="position:relative; top:7px;"> Password :</label>
                    </div>
                    <div class="col-sm-8">
                        <input type="password" required class="form-control" name="pass" value="<?php echo @$_POST['pass']; ?>">
                    </div>
                </div>
				
            </div> 
			</div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span> Cancel</button>
                <button type="submit" name="save_seo" class="btn btn-success"><span class="glyphicon glyphicon-check"></span> Update</a>
			</form>
            </div>

        </div>
    </div>
</div>

<!-- Delete -->
<div class="modal fade" id="delete_<?php echo $row['dept_id']; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <center><h4 class="modal-title" id="myModalLabel">Remove Option Information </h4></center>
            </div>
            <div class="modal-body">	
            	<p class="text-center">Are you sure you want to Remove</p>
				<h2 class="text-center"><?php echo $row['deptname'].' [ '.$row['deptacronym']; ?>]</h2>
			</div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span> Cancel</button>
                <a href="option.php?id=<?php echo $row['dept_id']; ?>" class="btn btn-danger"><span class="glyphicon glyphicon-trash"></span> Yes</a>
            </div>

        </div>
    </div>
</div>