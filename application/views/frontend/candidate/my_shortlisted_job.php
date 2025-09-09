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
<h3 class="page-header">Shortlisted job</h3>
<?php echo $this->session->flashdata('message'); ?>
<div class="row">
    <div class="col-md-12">
        <table class="table applied-job">
            <thead class="thead-light">
                <tr>
                    <th scope="col">SL</th>
                    <th scope="col">Company</th>
                    <th scope="col">Job Title</th>
                    <th scope="col">Deadline</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if (count($shortlisted_jobs) >= 1) {
                    $row = 1;
                    foreach ($shortlisted_jobs as $key => $shortlist) {
                        $job_url = site_url("job-details/{$shortlist->job_id}/" . slugify($shortlist->job_title) . '.html');
                        ?>

                        <tr id="shortlist_<?php echo $shortlist->job_favourite_id;?>">
                            <th scope="row"><?php echo $row; ?></th>
                            <td>
                                <h4><?php echo !empty($shortlist->company_name) ? $shortlist->company_name : 'N/A'; ?></h4>
                            </td>
                            <td>
                                <h5><a target="_blank" href="<?php echo $job_url; ?>"><?php echo $shortlist->job_title ?></a></h5>
                            </td>
                            <td>
                                <?php echo deadline($shortlist->deadline) ?>
                            </td>
                            <td class="text-center">
                                <button type="button" 
                                        class="btn btn-sm btn-danger" 
                                        onclick="deleteShortListJob(<?php echo $shortlist->job_favourite_id; ?>)">
                                    <i class="fa fa-times"></i>
                                </button>
                            </td>
                        </tr>
                        <?php
                        $row++;
                    }
                } else {
                    echo '<tr><td colspan="3" class="text-center bold">Data Not Found</td></tr>';
                }
                ?>

            </tbody>
        </table>
    </div>
</div>
<script type="text/javascript">

    function deleteShortListJob(jobFavouriteId) {
        if(confirm('This will delete the selected job from your shortlist. Are you sure to delete it?')) {
            $.ajax({
                url: 'myaccount/shortlisted_job_delete/' + jobFavouriteId,
                type: "get",
                success: function (jsonRespond) {
                    var res =jQuery.parseJSON(jsonRespond);
                    if (res.Status === 'OK') {
                        toastr.success("You have removed this job from shortlist!");
                        $('tr#shortlist_'+jobFavouriteId).remove();
                    } else {
                         toastr.error(res.Msg);
                    }
                }
            });
            return false;
        }
    }
</script>
