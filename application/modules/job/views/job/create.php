<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<section class="content-header">
    <h1> Job <small><?php echo $button ?></small>
        <a href="<?php echo site_url(Backend_URL . 'job') ?>"
           class="btn btn-default">Back</a></h1>
    <ol class="breadcrumb">
        <li><a href="<?php echo Backend_URL ?>"><i class="fa fa-dashboard"></i> Admin</a></li>
        <li><a href="<?php echo Backend_URL ?>job">Job</a></li>
        <li class="active">Add New</li>
    </ol>
</section>

<script src="https://maps.googleapis.com/maps/api/js?libraries=places,geometry&key=AIzaSyCSuu_Ag9Z2CEMxzzXdCcPNIUtPm0-GIXs"></script>
<section class="content">
    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title">Add New Job</h3>
        </div>

        <div class="box-body">
            <?php echo form_open($action, array('class' => 'form-horizontal', 'method' => 'post')); ?>

            <?php if($login_role_id != 4): ?>
            <div class="form-group">
                <label for="user_id" class="col-sm-2 control-label">Select Company<sup>*</sup></label>
                <div class="col-sm-10">
                    <select class="form-control" name="user_id" id="user_id">
                        <option value="0">-- Select Company --</option>
                        <?php echo Ngo::company($user_id); ?>
                    </select>
                    <?php echo form_error('user_id') ?>
                </div>
            </div>
            <?php endif; ?>

            <div class="form-group">
                <label for="title" class="col-sm-2 control-label">Job Title<sup>*</sup></label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" name="title" id="title" placeholder="Title"
                           value="<?php echo $title; ?>"/>
                    <?php echo form_error('title') ?>
                </div>
            </div>

            <div class="form-group">
                <label for="job_category_id" class="col-sm-2 control-label">Job Category<sup>*</sup></label>
                <div class="col-sm-5">
                    <select class="form-control select2" name="job_category_id" id="job_category_id">
                        <option value="0">-- Select Category --</option>
                        <?php echo getJobCategoryDropDown($job_category_id); ?>
                    </select>
                    <?php echo form_error('job_category_id') ?>
                </div>
                <div class="col-sm-5">
                    <select class="form-control" name="sub_cat_id" id="sub_cat_id">
                        <?php echo getJobSubCategoryDropDown($job_category_id, $sub_cat_id); ?>
                    </select>
                    <?php echo form_error('sub_cat_id') ?>
                </div>
            </div>


            <div class="form-group">
                <label for="location" class="col-sm-2 control-label">Location<sup>*</sup></label>
                <div class="col-sm-10">
                    <div class="input-group">
                        <span class="input-group-addon"><i class="fa fa-map-marker"></i></span>
                        <input type="text" class="form-control" name="location" id="autocomplete" placeholder="Location"
                           value="<?php echo $location; ?>"/>
                        
                        <span class="input-group-addon">Google Map Position</span>
                    </div>
                    
                    <input type="hidden" name="lat" id="latitude" value="<?php echo $lat; ?>"/>
                    <input type="hidden" name="lng" id="longitude" value="<?php echo $lng; ?>"/>
                    <?php echo form_error('location') ?>
                </div>
            </div>

            <div class="form-group">
                <label for="country_id" class="col-sm-2 control-label">Country<sup>*</sup></label>
                <div class="col-sm-10">
                    <select class="form-control select2" name="country_id" id="country_id">
                        <?php echo getDropDownCountries($country_id); ?>
                    </select>
                    <?php echo form_error('country_id') ?>
                </div>
            </div>

            <div class="form-group">
                <label for="job_type_id" class="col-sm-2 control-label">Job Type<sup>*</sup></label>
                <div class="col-sm-10">
                    <select class="form-control" name="job_type_id" id="job_type_id">
                        <option value="0">-- Select Job Type --</option>
                        <?php echo Ngo::getJobTypeDropDown($job_type_id); ?>
                    </select>
                    <?php echo form_error('job_type_id') ?>
                </div>
            </div>
            <div class="form-group">
                <label for="description" class="col-sm-2 control-label">Description<sup>*</sup></label>
                <div class="col-sm-10">
                    <textarea class="form-control" name="description" id="description"
                              placeholder="Description"><?php echo $description; ?></textarea>
                    <?php echo form_error('description') ?>
                </div>
            </div>
            <div class="form-group">
                <label for="job_skill_ids" class="col-sm-2 control-label">Skills</label>
                <div class="col-sm-10">
                    <select class="form-control select2" name="job_skill_ids[]" id="job_skill_ids" multiple>
                        <?php echo getJobSkillsDropDown($job_skill_ids); ?>
                    </select>
                    <?php echo form_error('job_skill_ids') ?>
                </div>
            </div>
            <div class="form-group">
                <label for="job_benefit_ids" class="col-sm-2 control-label">Benefits</label>
                <div class="col-sm-10">
                    <select class="form-control select2" name="job_benefit_ids[]" id="job_benefit_ids" multiple>
                        <?php echo getJobBenefitsDropDown($job_benefit_ids); ?>
                    </select>
                    <?php echo form_error('job_benefit_ids') ?>
                </div>
            </div>
            

            <div class="form-group">
                <label for="deadline" class="col-sm-2 control-label">Application Deadline<sup>*</sup></label>
                <div class="col-sm-2">
                    <input type="text" class="form-control js_datepicker_limit date_picker_icon" name="deadline"
                           id="deadline" autocomplete="off"
                           placeholder="Job Application Deadline" value="<?php echo $deadline; ?>"/>
                    <?php echo form_error('deadline') ?>
                </div>
            </div>
            <div class="form-group">
                <label for="vacancy" class="col-sm-2 control-label">Ref ?<sup>*</sup></label>
                <div class="col-sm-2">
                    <div class="input-group">
                        <span class="input-group-addon">
                            <i class="fa fa-user"></i>
                        </span>
                        <input type="text" class="form-control" name="vacancy" id="vacancy"
                               placeholder="Job Vacancy" onkeypress="return DigitOnly(event);"
                               value="<?php echo $vacancy; ?>"/>
                    </div>
                    <?php echo form_error('vacancy') ?>
                </div>
            </div>

            <div class="form-group">
                <label for="salary_type" class="col-sm-2 control-label">Salary Type<sup>*</sup></label>
                <div class="col-sm-10"
                     style="padding-top:8px;"><?php echo htmlRadio('salary_type', $salary_type, array('Negotiable' => 'Negotiable', 'Range' => 'Range', 'Fixed' => 'Fixed')); ?></div>
            </div>

            <div id="salary_period_area" class="hidden">
                <div class="form-group">
                    <label for="salary_period" class="col-sm-2 control-label">Salary Period<sup>*</sup></label>
                    <div class="col-sm-10"
                         style="padding-top:8px;"><?php
                        echo htmlRadio('salary_period', $salary_period, array(
                            'Hourly' => 'Hourly',
                            'Weekly' => 'Weekly',
                            'Monthly' => 'Monthly',
                            'Yearly' => 'Yearly'
                        ));
                        ?></div>
                </div>
            </div>

            <div id="salary_range_area" class="hidden">
                <div class="form-group">
                    <label for="salary_min" class="col-sm-2 control-label">Salary</label>
                    <div class="col-sm-5">
                        <div class="input-group">
                            <span class="input-group-addon">Min</span>
                            <input type="text" class="form-control" name="salary_min" id="salary_min"
                                   placeholder="Salary Min" onkeypress="return DigitOnly(event);"
                                   value="<?php echo $salary_min; ?>"/>

                            <span class="input-group-addon">Max</span>
                            <input type="text" class="form-control" name="salary_max" id="salary_max"
                                   placeholder="Salary Max" onkeypress="return DigitOnly(event);"
                                   value="<?php echo $salary_max; ?>"/>

                            <span class="input-group-addon">Currency</span>
                            <select class="form-control" name="salary_currency" style="width: 120px;">
                                <?php echo getCurrency($salary_currency); ?>
                            </select>
                        </div>

                        <?php echo form_error('salary_min') ?>
                        <?php echo form_error('salary_max') ?>
                    </div>
                </div>
            </div>

            <div id="salary_fixed_area" class="hidden">
                <div class="form-group">
                    <label for="salary_fixed" class="col-sm-2 control-label">Salary</label>
                    <div class="col-sm-4">
                        <div class="input-group">
                            <input type="text" class="form-control" name="salary_fixed" id="salary_fixed"
                                   placeholder="Salary Amount" onkeypress="return DigitOnly(event);"
                                   value="<?php echo $salary_min; ?>"/>
                            <span class="input-group-addon">Currency</span>
                            <select class="form-control" name="salary_currency_fixed" style="width: 120px;">
                                <?php echo getCurrency($salary_currency); ?>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label for="status" class="col-sm-2 control-label">Status<sup>*</sup></label>
                <div class="col-sm-10"
                     style="padding-top:8px;"><?php echo htmlRadio('status', $status, $status_option); ?></div>
            </div>
            <div class="form-group">
                <label for="is_feature" class="col-sm-2 control-label">Mark as Featured<sup>*</sup></label>
                <div class="col-sm-10"
                     style="padding-top:8px;"><?php echo htmlRadio('is_feature', $is_feature, [
                         '0' => 'No',
                         '1' => 'Yes',
                     ]); ?></div>
            </div>
            <div class="form-group">
                <label for="package_id" class="col-sm-2 control-label">Select Package<sup>*</sup></label>
                <div class="col-sm-10">
                    <?php echo packageHtmlRadio('package_id', $package_id, 'job'); ?>
                    <li>from job</li>
                    <?php echo form_error('package_id') ?>
                </div>
            </div>

            <!-- <div class="form-group">
                <label for="recruiters_note" class="col-sm-2 control-label">Note</label>
                <div class="col-sm-10">
                    <textarea class="form-control" rows="3" name="recruiters_note" id="recruiters_note"
                              placeholder="Recruiters Note"><?php echo $recruiters_note; ?></textarea>
                    <?php //echo form_error('recruiters_note') ?>
                </div>
            </div> -->

            <?php if($login_role_id != 4): ?>
            <div class="form-group">
                <label for="admin_note" class="col-sm-2 control-label">Note to Admin </label>
                <div class="col-sm-10">
                    <textarea class="form-control" rows="3" name="admin_note" id="admin_note"
                              placeholder="Note to Admin"><?php echo $admin_note; ?></textarea>
                    <?php echo form_error('admin_note') ?>
                </div>
            </div>
            <?php endif; ?>

            <div class="col-md-10 col-md-offset-2" style="padding-left:5px;">
                <input type="hidden" name="id" value="<?php echo $id; ?>"/>
                <button type="submit" class="btn btn-primary"><?php echo $button ?></button>
                <a href="<?php echo site_url(Backend_URL . 'job') ?>" class="btn btn-default">Cancel</a>
            </div>
            <?php echo form_close(); ?>
        </div>
    </div>
</section>

<script src="https://cdn.ckeditor.com/4.7.3/standard/ckeditor.js"></script>
<script>
    CKEDITOR.replace('description', {
        width: ['100%'],
        height: ['350px'],
        customConfig: '<?php echo site_url('assets/lib/plugins/ckeditor/config.js'); ?>'
    });
</script>
<?php load_module_asset('job','js');?>