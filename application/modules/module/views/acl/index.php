<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.18/css/dataTables.bootstrap.min.css">

<section class="content-header">
    <h1> Access Control List   <small>Control panel</small></h1>
    <ol class="breadcrumb">
        <li><a href="<?php echo Backend_URL; ?>"><i class="fa fa-dashboard"></i> Admin</a></li>
        <li class="active">ACL</li>
    </ol>
</section>

<section class="content">
    <div class="row">
        <div class="col-sm-3 col-xs-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">
                        <i class="fa fa-user-plus" aria-hidden="true"></i> Add New
                    </h3>
                </div>

                <div class="panel-body">                   
                    <form action="admin/module/acl/create_action" name="acls" method="post">
                        <input type="hidden" name="id" value="0" />
                        <input type="hidden" name="order_id" value="0" /> 
                        
                        <div class="form-group">
                            <label for="module_id">Select Module</label>
                            <select class="form-control" name="module_id" id="module_id">
                                <?php echo get_all_modules();?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="permission_name">Permission Title/Name</label>
                            <input type="text" class="form-control" name="permission_name" id="permission_name" placeholder="Permission Name" />
                        </div>
                        <div class="form-group">
                            <label for="permission_key">Permission Key</label>
                            <input type="text" class="form-control" name="permission_key" id="permission_key" placeholder="Permission Key" />
                        </div>
                        
                        
                        <button type="submit" class="btn btn-primary">Save New</button>
                        <button type="reset" class="btn btn-default">Reset</button> 
                         
                    </form>
                </div>		
            </div>
        </div>



        <div class="col-sm-9 col-xs-12">
            <div class="panel panel-default">
                <div class="panel-heading">                     
                    <h3 class="panel-title">
                        <i class="fa fa-list"></i>
                        Access Control List
                    </h3>
                </div>


                <div class="panel-body">
                    
                    <?php echo $this->session->flashdata('message'); ?>
                    
                    <table class="table table-bordered table-striped" id="mytable">
                        <thead>
                            <tr>
                                <th width="20">S/L</th>                                
                                <th>Module</th>
                                <th>Permission Name</th>
                                <th>Permission Key</th>                                    
                                <th width="80">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php 
                        
                        $id = 0;
                        foreach ($acls_data as $acls) { 
                            $id++;
                            ?>
                            <tr>
                                <td><?php echo $id; ?></td>                                
                                <td><?php echo $acls->name ?></td>
                                <td><?php echo $acls->permission_name ?></td>
                                <td><?php echo  $acls->id .'|'. $acls->permission_key ?></td>
                                <td class="no-padding text-center">
                                    <?php                                           
                                    echo anchor(site_url(Backend_URL . 'module/acl/update/' . $acls->id), '<i class="fa fa-fw fa-edit"></i>', 'class="btn btn-xs btn-default"');
                                    echo anchor(site_url(Backend_URL . 'module/acl/delete/' . $acls->id), '<i class="fa fa-fw fa-trash"></i> ', 'class="btn btn-xs btn-danger" onclick="javasciprt: return confirm(\'Are You Sure ?\')"');
                                    ?>
                                </td>
                            </tr>
                        <?php } ?>
                        </tbody>
                    </table>

                </div>
            </div>
        </div>
    </div>
</section>
<!-- DataTables -->
<script src="https://cdn.datatables.net/1.10.18/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.18/js/dataTables.bootstrap.min.js"></script>

<script type="text/javascript">
    $(document).ready(function () {
        $("#mytable").dataTable({
                "pageLength": 25
            });
    });
</script>