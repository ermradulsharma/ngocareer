<form action="<?php echo site_url(Backend_URL . 'candidate'); ?>" class="form-inline" method="get">
    
    <div class="input-group">
        <span class="input-group-addon">            
            Account Status
        </span>
        <select name="status" class="form-control">
            <?php echo selectOptions($status, [
                'Any' => '--Any--',
                'Active' => 'Active',
                'Inactive' => 'Inactive',
                'Pending' => 'Pending',
            ]);?>
        </select>
    </div>
    <div class="input-group">
        <span class="input-group-addon">            
            Gender
        </span>
        <select name="gender" class="form-control">
            <?php echo selectOptions($gender, [
                'Any' => '--Any--',
                'Male' => 'Male',
                'Female' => 'Female',
            ]);?>
        </select>
    </div>
    <div class="input-group">
        <span class="input-group-addon">            
            Job Alert
        </span>
        <select name="alert" class="form-control">
            <?php echo selectOptions($alert, [
                'Any' => '--Any--',
                'Yes' => 'Who Setup',
                'No' => 'Who do not Setup',
            ]);?>
        </select>
    </div>
    
    
    
    <div class="input-group">
        <input type="text" class="form-control" name="q" value="<?php echo $q; ?>">
        <span class="input-group-btn">            
            <button class="btn btn-primary" type="submit">Search</button>
            <a href="<?php echo site_url(Backend_URL . 'candidate'); ?>" class="btn btn-default">Reset</a>
        </span>
    </div>
</form>