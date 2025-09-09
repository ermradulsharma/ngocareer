<h3>Selected Filter</h3>
<form action="ngo-job-search" id="job-search-form" method="get">
    <input type="hidden" name="keyword" id="keyword" value="<?php echo $keyword; ?>">
    <input type="hidden" name="sort_by" id="sort_by" value="<?php echo $sort_by; ?>">
    <input type="hidden" name="location" id="location" value="<?php echo $location; ?>"/>
    <input type="hidden" name="lat" id="lat" value="<?php echo $lat; ?>"/>
    <input type="hidden" name="lng" id="lng" value="<?php echo $lng; ?>"/>


    <div style="padding: 15px 0px;">
        <div class="form-group">
            <div class="row">
                <div class="col-md-5">
                    <label>Category</label>
                </div>
                <div class="col-md-7">
                    <select class="form-control" id="cat" name="cat">
                        <option value="0">Any Category</option>
                        <?php echo Ngo::getJobCategoryDropDown($cat); ?>
                    </select>
                </div>
            </div>
        </div>

        <div class="form-group">
            <div class="row">
                <div class="col-md-5">
                    <label>Organization</label>
                </div>
                <div class="col-md-7">
                    <select class="form-control" id="org" name="org">
                        <option value="0">Any Organization</option>
                        <?php echo Ngo::getOrganizationTypesDropdown($org); ?>
                    </select>
                </div>
            </div>
        </div>

        <div class="form-group">
            <div class="row">
                <div class="col-md-5">
                    <label>Country</label>
                </div>
                <div class="col-md-7">
                    <select class="form-control" id="country_id" name="country_id">
                        <?php echo getDropDownCountries($country_id,'Any Country'); ?>
                    </select>
                </div>
            </div>
        </div>

        <div class="form-group">
            <div class="row">
                <div class="col-md-5">
                    <label>Salary</label>
                </div>
                <div class="col-md-7">                    
                    <select class="form-control" name="salary_range">
                        <?php echo selectOptions($salary_range,
                            [
                                '0' => 'Any Salary Range',
                                '0:1000' => '< 500',                                                                
                                '1001:2000' => '1001 - 1500',                               
                                '2001:3000' => '2001 - 3000',
                                '3001:5000' => '3001 - 5000',
                                '5001:100000' => '> 5001',
                            ]
                        ); ?>
                    </select>
                </div>
            </div>
        </div>

        <div class="form-group">
            <div class="row">
                <div class="col-md-5">
                    <label>Type</label>
                </div>
                <div class="col-md-7">
                    <select class="form-control" name="type_id" id="type_id">
                        <option value="0">Any Job Type</option>
                        <?php echo Ngo::getJobTypeDropDown($type_id); ?>
                    </select>
                </div>
            </div>
        </div>

        <div class="form-group">
            <div class="row">
                <div class="col-md-5">
                    <label>Posted</label>
                </div>
                <div class="col-md-7">
                    <select name="posted" class="form-control">
                        <?php echo Ngo::getPastDaysRange($posted); ?>
                    </select>
                </div>
            </div>
        </div>

        <div class="form-group">
            <div class="row">
                <div class="col-md-5">
                    <label>Deadline</label>
                </div>
                <div class="col-md-7">
                    <select name="deadline" class="form-control">
                        <?php echo Ngo::getDaysRange($deadline); ?>
                    </select>
                </div>
            </div>
        </div>

    </div>
    <div class="apply-clear">
        <a href="ngo-job-search">
            <button class="btn btn-info btn-sm clear-box" type="button">Clear</button>
        </a>
        <button class="btn btn-info btn-sm apply-box" type="submit">apply filter
        </button>
    </div>
</form>