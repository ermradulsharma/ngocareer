<style type="text/css">
    .table .thead-light th {
        color: #495057;
        background-color: #e9ecef;
        border-color: #dee2e6;
    }
    
    .table.applied-job tr th,
    .table.applied-job tr td{
        vertical-align: middle;
        overflow: hidden;
    }
    
    .table.applied-job tr th h3,
    .table.applied-job tr td h3{
        margin-top: 10px;
    }
</style>
<h3 class="page-header">My Applied Job</h3>
<?php echo $this->session->flashdata('message'); ?>
<div class="row">
    <div class="col-md-12">
        <table class="table applied-job">
            <thead class="thead-light">
                <tr>
                    <th scope="col">SL</th>
                    <th scope="col">Job Title</th>
                    <th scope="col" class="text-center">Application Date</th>
                    <th scope="col" class="text-center">Expected Salary</th>
                    <th scope="col" class="text-center">Viewed(by Recruiter)	</th>
                    <th scope="col" class="text-center">Status</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                if(count($applied_jobs)>=1){
                    $row = 1;
                    foreach ($applied_jobs as $key => $job) {
                    ?>

                    <tr>
                        <th scope="row"><?php echo $row;?></th>
                        <td>
                            <h4><?php echo !empty($job->company_name) ? $job->company_name : 'N/A'; ?></h4>
                            <h5><?php echo $job->job_title?></h5>
                        </td>
                        <td class="text-center"><?php echo globalDateFormat($job->applied_at) ?></td>
                        <td class="text-center"><?php echo globalCurrencyFormat($job->expected_salary) ?></td>
                        <td class="text-center">
                            <?php 
                            if($job->viewed == 'Yes'){
                                echo '<i class="fa fa-check"></i>';
                            }else if($job->viewed == 'No'){
                                echo '<i class="fa fa-times"></i>';
                            }
                            ?>
                        </td>
                        <td class="text-center">
                            <?php echo applicantStatus($job->status);?>
                            
                        </td>
                    </tr>
                    <?php
                        $row++;
                    }
                }else{
                    echo '<tr><td colspan="5" class="text-center bold">Data Not Found</td></tr>';
                }
                ?>
                
            </tbody>
        </table>
    </div>
</div>
