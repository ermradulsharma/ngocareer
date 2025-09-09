<?php load_module_asset('users', 'css'); ?>
<?php load_module_asset('users', 'js'); ?>
<section class="content-header">
    <h1> User <small>list</small> &nbsp;&nbsp;
        <?php echo anchor(site_url(Backend_URL . 'users/create'), ' + Add User', 'class="btn btn-default"'); ?>
    </h1>
    <ol class="breadcrumb">
        <li><a href="<?php echo Backend_URL; ?>"><i class="fa fa-dashboard"></i> Admin </a></li>        
        <li class="active">User list</li>
    </ol>
</section>
<style type="text/css">ul.dropdown-menu li {cursor: pointer;}</style>

<section class="content"> 
    <div class="box">

        <div class="box-header">
            <?php $this->load->view('filter_form'); ?>       
        </div>
        <div class="box-body">

            <div class="table-responsive">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th width="40">ID</th>
                            <th width="120">Logo/Photo</th>
                            <th width="120">Name & Role</th>                            
                            <th>Email & Company Name</th>
                            <th>Contact</th>
                            <th width="50" class="text-center">Jobs</th>
                            <th width="50" class="text-center">Events</th>
                            <th width="100" class="text-center">Status</th>
                            <th width="120">Register at</th>
                            
                            <th width="130" class="text-center">Action</th>
                        </tr>   
                    </thead>
                    <tbody>
                        <?php foreach ($users_data as $user) { ?>
                            <tr>
                                <td><?php echo $user->id; ?></td>                                
                                <td>
                                    <img src="<?php echo getPhoto($user->logo); ?>"
                                         class="img-responsive"/>
                                </td>                                
                                <td>
                                    <p><?php echo $user->first_name . ' ' . $user->last_name; ?><br/>
                                    <?php echo $user->role_name; ?>
                                    </p>
                                </td>
                                <td><?php echo $user->email; ?><br/>
                                    <?php echo $user->company_name; ?>                                
                                </td>
                                <td><?php echo $user->contact; ?></td>                                                  
                                <td class="text-center"><?php echo $user->j_qty; ?></td>
                                <td class="text-center"><?php echo $user->e_qty; ?></td>
                                <td><?php echo userStatus($user->status, $user->id); ?></td>
                                <td><?php echo globalDateFormat($user->created_at); ?></td>
                                <td class="text-center"><?php
                                    echo anchor(site_url(Backend_URL . 'users/profile/' . $user->id), '<i class="fa fa-fw fa-external-link"></i> View', 'class="btn btn-xs btn-default"');                                  
                                    echo anchor(site_url(Backend_URL . 'users/update/' . $user->id), '<i class="fa fa-fw fa-edit"></i> Edit', 'class="btn btn-xs btn-primary"');
                                    ?>                                                      
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>     

            </div>
        </div>

        <div class="row" style="padding-top: 10px; padding-bottom: 10px; margin: 0;">
            <div class="col-md-6">
                <span>Total Record : <?php echo $total_rows ?></span>
            </div>
            <div class="col-md-6 text-right">
                <?php echo $pagination ?>
            </div>
        </div>
    </div>
</section>    

<script>
    function statusUpdate(post_id, status){
    $.ajax({
        url: 'admin/users/set_status',
        type: 'POST',
        dataType: "json",
        data: { status: status, post_id: post_id  },
        beforeSend: function(){
            $('#active_status_'+ post_id ).html('Updating...');
        },
        success: function ( jsonRespond ) {
            $('#active_status_'+post_id)
                    .html(jsonRespond.Status)
                    .removeClass( 'btn-default btn-danger btn-warning btn-success')
                    .addClass( jsonRespond.Class );

        }
    });   
}
</script>