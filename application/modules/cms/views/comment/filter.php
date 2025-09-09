<div class="row">
<form method="get" name="report" action="">                                 
    <div class="col-md-5"></div>
    <div class="col-md-3">
        <div class="input-group">
            <span class="input-group-addon"><i class="fa fa-search"></i></span>
            <input type="text" class="form-control" name="q" placeholder="Comment" value="<?php echo $q; ?>">
        </div>                                                            
    </div>
    <div class="col-md-2">
        <div class="input-group">
            <span class="input-group-addon">Status</span>
            <select name="status" class="form-control">
                <?php
                echo selectOptions($status, [
                    '' => 'Any',
                    'Approve' => 'Approve',
                    'Unapprove' => 'Unapprove',
                    'Pending' => 'Pending',
                ]);
                ?>
            </select>
        </div>
    </div>

    <div class="col-md-2 text-left">
        <button type="submit" class="btn btn-success">
            <i class="fa fa-search" aria-hidden="true"></i> Filter
        </button>
        <button type="button" class="btn btn-default" onclick="location.href = '<?php echo Backend_URL; ?>cms/comment';">
            <i class="fa fa-times" aria-hidden="true"></i> Reset
        </button>
    </div>
</form>
</div>