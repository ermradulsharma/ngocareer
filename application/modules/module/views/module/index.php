<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<section class="content-header">
    <h1> Modules  <small>Control panel</small> <?php echo anchor(site_url(Backend_URL . 'module/create'), ' + Add New', 'class="btn btn-default"'); ?> </h1>
    <ol class="breadcrumb">
        <li><a href="<?php echo site_url(Backend_URL) ?>"><i class="fa fa-dashboard"></i> Admin</a></li>
        <li class="active">Modules</li>
    </ol>
</section>

<section class="content">       
    <div class="box">            
        <div class="box-header with-border">                                   
            <div class="col-md-3 col-md-offset-9 text-right">
                <form action="<?php echo site_url(Backend_URL . 'module'); ?>" class="form-inline" method="get">
                    <div class="input-group">
                        <input type="text" class="form-control" name="q" value="<?php echo $q; ?>">
                        <span class="input-group-btn">
                            <?php if ($q <> '') { ?>
                                <a href="<?php echo site_url(Backend_URL . 'module'); ?>" class="btn btn-default">Reset</a>
                            <?php } ?>
                            <button class="btn btn-primary" type="submit">Search</button>
                        </span>
                    </div>
                </form>
            </div>
        </div>

        <div class="box-body">
            <div class="table-responsive">
                <table class="table table-striped table-hover table-bordered table-condensed">
                    <thead>
                        <tr>
                            <th width="40">#ID</th>                                                        
                            <th>Name</th>                                                        
                            <th width="100">Type</th>
                            <th width="100">Date</th>
                            <th width="100">Status</th>
                            <th width="150">Action</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php foreach ($module_data as $module) { ?>
                            <tr>
                                <td><?php echo $module->id; ?></td>                                                                
                                <td><p><?php echo $module->name ?><br/>
                                        <em><?php echo $module->description ?></em></p>                                
                                </td>                                                                
                                <td><?php echo $module->type ?></td>
                                <td><?php echo globalDateFormat($module->added_date) ?></td>
                                <td><?php echo $module->status ?></td>
                                <td>
                                    <?php                            
                                    echo anchor(site_url(Backend_URL . 'module/update/' . $module->id), '<i class="fa fa-fw fa-edit"></i> Edit', 'class="btn btn-xs btn-default"');
                                    echo anchor(site_url(Backend_URL . 'module/delete/' . $module->id), '<i class="fa fa-fw fa-trash"></i> Delete ', 'class="btn btn-xs btn-danger" onclick="javasciprt: return confirm(\'Are You Sure ?\')"');
                                    ?>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>


            <div class="row">                
                <div class="col-md-6">
                    <span class="btn btn-primary">Total Record : <?php echo $total_rows ?></span>
                </div>
                
                <div class="col-md-6 text-right">
                    <?php echo $pagination ?>
                </div>                
            </div>
        </div>
    </div>
</section>