<form class="form-inline">

    <div class="form-group">
        <div class="input-group">
            <span class="input-group-addon">Applied within </span>
            <select name="date" class="form-control">
                <?php echo Ngo::getPastDaysRange($date); ?>
            </select>
        </div>
    </div>
    <div class="form-group">
        <div class="input-group">
            <span class="input-group-addon">Status</span>
            <select id="status" name="status" class="form-control">
                <?php
                echo selectOptions(
                        $status, [
                    '' => '--Any--',
                    'Shortlisted' => 'Shortlisted',
                    'Rejected' => 'Rejected',
                ]);
                ?>
            </select>
        </div>
    </div>
    <div class="form-group">
        <div class="input-group">
            <span class="input-group-btn">
                <button class="btn btn-primary">
                    Filter
                </button>
                <a href="admin/job/applicants/<?= $id; ?>" class="btn btn-default">
                    Clear
                </a>
            </span>            
        </div>
    </div>    
</form>