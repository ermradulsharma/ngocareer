<div class="row">
<form method="get" name="report" action="">                                 
    <div class="col-md-4">                    
        <div class="input-group">
            <span class="input-group-addon"><i class="fa fa-search"></i></span>
            <input type="text" class="form-control" name="q" placeholder="Keyword" value="<?php echo $q; ?>">
        </div>                                                            
    </div>

    <div class="col-md-3">
        <div class="input-group">
            <span class="input-group-addon">Role</span>
            <select name="role_id" class="form-control">
                <option value="0">--Any Role--</option>
                <?php echo Users_helper::getDropDownRoleName($role_id); ?>
            </select>
        </div>
    </div>
    <div class="col-md-3">
        <div class="input-group">
            <span class="input-group-addon">Status</span>
            <select name="status" class="form-control">
                <?php
                echo selectOptions($status, [
                    '' => '--Any Status--',
                    'Active' => 'Active',
                    'Inactive' => 'Inactive',
                    'Pending' => 'Pending',
                ]);
                ?>
            </select>
        </div>
    </div>

    <div class="col-md-2 text-right">
        <button type="submit" class="btn btn-info">
            <i class="fa fa-search" aria-hidden="true"></i> Filter
        </button>
        <button type="button" class="btn btn-default" onclick="location.href = '<?php echo Backend_URL; ?>users';">
            <i class="fa fa-times" aria-hidden="true"></i> Reset
        </button>
    </div>
</form>
</div>