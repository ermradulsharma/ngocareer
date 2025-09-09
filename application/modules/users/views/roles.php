<?php load_module_asset('users', 'css' );?>
<?php load_module_asset('users', 'js' );?>   
<section class="content-header">
    <h1> Role  <small>Permission Management</small> </h1>
    <ol class="breadcrumb">
        <li><a href="<?php echo Backend_URL; ?>"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Dashboard</li>
    </ol>
</section>

<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="">
            <div class="col-md-8 col-xs-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">
                            <i class="fa fa-users" aria-hidden="true"></i> Role / Label
                        </h3>
                    </div>
                    <div class="panel-body no-padding">

                        <div id="ajaxRespond"></div>

                        <!-- /.box-header -->
                        <div class="box-body table-responsive no-padding role_list" >
                            <table class="table table-striped table-hover">
                                <tbody>
                                    <tr>
                                        <th width="20">#</th>
                                        <th>Role/Label</th>                                    
                                        <th width="100">Users</th>
                                        <th width="210">Action</th>
                                    </tr>
                                    <?php foreach ($roles_data as $row) { ?>
                                        <tr class="role_id_<?php echo $row->id; ?>">
                                            <td><?php echo $row->id; ?></td>                                        
                                            <td class="edit_id_<?php echo $row->id; ?>"><?php echo $row->role_name; ?></td>

                                            <td><span class="badge bg-light-blue"><?php echo $row->totalUser; ?></span></td>
                                            <td>
                                                <span onClick="manage_acl(<?php echo $row->id; ?>)" class="btn btn-default btn-xs"><i class="fa fa fa-cogs"></i> ACL</span>
                                                <span onClick="edit_role(<?php echo $row->id; ?>)" class="btn btn-default btn-xs"> <i class="fa fa-edit"></i> Rename</span>
                                                <?php echo Users_helper::Delete($row->id, $row->status); ?>
                                            </td>                                            
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                        <!-- /.box-body -->                   
                    </div>
                </div>
            </div>



            <div class="col-md-4 col-xs-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">
                            <i class="fa fa-user-plus" aria-hidden="true"></i> Add New Role
                        </h3>
                    </div>

                    <div class="panel-body">
                        <div id="ajaxRespondID" style="display:none;">Ajax Message Will Display Here</div>
                        <form id="role" method="post" role="form"  action="<?php Backend_URL; ?>users/roles/create">
                            <div class="form-group">
                                <label for="roleName">Role Name <sup>*</sup></label>
                                <input type="text" name="role_name" id="role_name" class="form-control" required="required"  data-error="Please enter role name" />
                                <div class="help-block with-errors"></div>
                            </div>
                            <button type="button" onClick="add_new_role(event);" class="btn btn-success">Create New Role</button>
                        </form>
                    </div>                
                </div>
            </div>
        </div>
    </div>


    <!-- Modal -->
    <div class="modal fade" id="manageAcl" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form method="POST" id="access_permission">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="myModalLabel">Grand Access with this Role</h4>
                    </div>



                    <div class="modal-body" >
                        <div class="js_update_respond"></div>
                        <div class="acl_respond" style="min-height:200px; max-height:450px; overflow-y:scroll; padding-right: 10px;"></div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal"><span aria-hidden="true">&times;</span> Close</button>
                        <button type="button" class="btn btn-primary " onclick="module_manage();"><i class="fa fa-save"></i> Grand Access</button>
                    </div>
                </form>


            </div>
        </div>
    </div>
</section>
