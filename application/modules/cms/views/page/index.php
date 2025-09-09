<?php
    defined('BASEPATH') OR exit('No direct script access allowed');
    load_module_asset('cms', 'css');
    load_module_asset('cms', 'js');
?>
<section class="content-header">
    <h1> Pages  <small>Control panel</small> <?php echo anchor(site_url(Backend_URL . 'cms/create'), ' + Add New', 'class="btn btn-default"'); ?> </h1>
    <ol class="breadcrumb">
        <li><a href="<?php echo Backend_URL; ?>"><i class="fa fa-dashboard"></i> Admin</a></li>        
        <li class="active">CMS</li>
    </ol>
</section>

<section class="content">       
    <div class="box">            
        <div class="box-header with-border"> 
            <div class="row">
                <div class="col-md-3">
                    <h3 class="box-title"><b>List of Page</b></h3>
                </div>
                <div class="col-md-3 pull-right text-right">
                    <form action="<?php echo site_url(Backend_URL . 'cms'); ?>" class="form-inline" method="get">
                        <div class="input-group">
                            <input type="text" class="form-control" name="q" value="<?php echo $q; ?>">
                            <span class="input-group-btn">
                                <?php if ($q <> '') { ?>
                                    <a href="<?php echo site_url(Backend_URL . 'cms'); ?>" class="btn btn-default">Reset</a>
                                <?php } ?>
                                <button class="btn btn-primary" type="submit">Search</button>
                            </span>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="box-body">
            <?php echo $this->session->flashdata('message'); ?>
            <div class="table-responsive">
                <table class="table table-hover table-striped">
                    <thead>
                        <tr>
                            <th width="40">ID</th>				
                            <th>Page Title</th>				
                            <th width="140">Created</th>
                            <th width="50">Status</th>		
                            <th width="90" class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        foreach ($cms_data as $cms) {
                            $cms = (object) $cms;
                            ?>
                            <tr>
                                <td><?php echo $cms->id ?></td>
                                <td><a href="<?php echo $cms->post_url; ?>" target="_blank"><?php echo $cms->post_title; ?></a></td>                    
                                <td><?php echo globalDateTimeFormat($cms->created); ?></td>
                                <td><?php echo statusGroup($cms->status,$cms->id); ?></td>
                                <td class="text-center">
                                    <?php
                                    echo anchor(site_url(Backend_URL . 'cms/update/' . $cms->id), '<i class="fa fa-fw fa-edit"></i>', 'class="btn btn-xs btn-default"');
                                    echo anchor(site_url(Backend_URL . 'cms/delete/' . $cms->id), '<i class="fa fa-fw fa-trash"></i> ', 'class="btn btn-xs btn-danger" onclick="javasciprt: return confirm(\'Are You Sure ?\')"');
                                    ?>
                                </td>
                            </tr>

                            <?php
                            if ($cms->child) {
                                $sl = 0;
                                foreach ($cms->child as $child) {
                                    ?>
                                    <tr>
                                        <td></td>
                                        <td><?php echo ++$sl; ?>) &nbsp;&nbsp; |__ <a href="<?php echo $child->post_url; ?>" target="_blank"><?php echo $child->post_title ?> <i class="fa fa-fw fa-external-link"></i></a></td>                                 
                                        <td><?php echo globalDateTimeFormat($child->created); ?></td>                   
                                        <td><?php echo statusGroup($child->status,$child->id); ?></td>                   
                                        <td>
                                            <?php
                                            echo anchor(site_url(Backend_URL . 'cms/update/' . $child->id), '<i class="fa fa-fw fa-edit"></i>', 'class="btn btn-xs btn-default"');
                                            echo anchor(site_url(Backend_URL . 'cms/delete/' . $child->id), '<i class="fa fa-fw fa-trash"></i> ', 'class="btn btn-xs btn-danger" onclick="javasciprt: return confirm(\'Are You Sure ?\')"');
                                            ?>
                                        </td>
                                    </tr>
                                    <?php }
                                } ?>

                            <?php } ?>
                    </tbody>
                </table>
            </div>
            
            <div class="row">            
                <div class="col-md-6">
                    <span class="btn btn-primary">Total Page: <?php echo $total_rows ?></span>	    
                </div>
                <div class="col-md-6 text-right">
                    <?php echo $pagination ?>
                </div>             
            </div>
        </div>
    </div>
</section>