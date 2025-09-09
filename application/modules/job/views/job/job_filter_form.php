<div class="row">
<form method="get" name="report" action="">

    <?php if(getLoginUserData('role_id') == 4): ?>
        <div class="col-md-4">
            <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-search"></i></span>
                <input type="text" class="form-control" name="q" placeholder="Keyword" value="<?php echo $q; ?>">
            </div>
        </div>
    <?php else: ?>
        <div class="col-md-2">
            <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-search"></i></span>
                <input type="text" class="form-control" name="q" placeholder="Keyword" value="<?php echo $q; ?>">
            </div>
        </div>
        <div class="col-md-2">
            <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-user"></i></span>
                <select name="user" class="form-control">
                    <option value="0">-- Any Recruiter --</option>
                    <?php echo Ngo::company($user); ?>
                </select>
            </div>
        </div>
    <?php endif; ?>

    <div class="col-md-3">
        <div class="input-group">
            <span class="input-group-addon">Category</span>
            <select name="category" class="form-control">
                <option value="0">-- Any Category --</option>
                <?php echo getJobCategoryDropDown($category); ?>
            </select>
        </div>
    </div>

    <div class="col-md-2">
        <div class="input-group">
            <span class="input-group-addon">Deadline</span>
            <input name="deadline" autocomplete="off"
                   class="form-control js_datepicker"
                   value="<?php echo $deadline; ?>">
        </div>
    </div>
    <div class="col-md-2">
        <div class="input-group">
            <span class="input-group-addon">Status</span>
            <select name="status" class="form-control">
                <?php
                echo selectOptions($status, [
                    '' => '--Any Status--',
                    'Draft' => 'Draft',
                    'Pending' => 'Pending',
                    'Published' => 'Published',
                    'Suspend' => 'Suspend',
                    'Archive' => 'Archive'                    
                ]);
                ?>
            </select>
        </div>
    </div>

    <div class="col-md-1 text-right">
        <button type="submit" class="btn btn-primary">
            <i class="fa fa-search" aria-hidden="true"></i>
        </button>
        <button type="button" class="btn btn-default" onclick="location.href = '<?php echo site_url(Backend_URL.'job'); ?>'">
            <i class="fa fa-times" aria-hidden="true"></i>
        </button>
    </div>
</form>
</div>