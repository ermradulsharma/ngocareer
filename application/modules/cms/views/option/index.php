<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<section class="content-header">
    <h1>Categories <small>Control panel</small></h1>
    <ol class="breadcrumb">
        <li><a href="<?php echo site_url(Backend_URL); ?>"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">All Categories</li>
    </ol>
</section>
<section class="content">
    <div class="row">
        <div class="col-sm-4 col-xs-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title"><i class="fa fa-user-plus" aria-hidden="true"></i> Add New </h3>
                </div>
                <br>
                <div class="panel-body">
                    <form action="admin/cms/category/create_action" method="post" enctype="multipart/form-data">
                        <input type="hidden" name="id" value="0" />
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Parent</label>
                            <div class="col-sm-9">
                                <select name="parent" class="form-control">
                                    <?php echo getCategoryDropDown(); ?>
                                </select>
                            </div>
                            <div class="clearfix"></div>
                        </div>
                        
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Name</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" name="name" id="name" placeholder="Category Name">
                            </div>
                            <div class="clearfix"></div>
                        </div>
                        
                        <div class="form-group">
                            <label class="col-sm-3 control-label">URL</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" name="url" id="url" placeholder="URL">
                            </div>
                            <div class="clearfix"></div>
                        </div>
                        
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Template</label>
                            <div class="col-sm-9">
                                <select name="template" class="form-control">
                                    <?php echo getCategoryTemplates(); ?>
                                </select>
                            </div>
                            <div class="clearfix"></div>
                        </div>
                        
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Description</label>
                            <div class="col-sm-9">
                                <textarea class="form-control" rows="3" name="description" id="description" placeholder="Description"></textarea>
                            </div>
                            <div class="clearfix"></div>
                        </div>
                        
                        <div class="col-sm-12">
                            <div class="btn btn-default btn-file">
                                <i class="fa fa-picture-o"></i> Set Thumbnail 
                                <input type="file" name="thumb" class="file_select" onchange="photoPreview(this, '.upload_image')">
                            </div>
                        </div>
                        <div class="col-sm-12" style="padding: 5px;"></div>
                        
                        <div class="col-sm-12">
                            <div class="thumbnail upload_image">
                                <img src="<?php echo getPhoto('', 'full'); ?>">
                            </div>
                        </div>
                        
                        <div class="col-sm-12 text-right" style="margin-bottom: 15px;">
                            <button type="submit" class="btn btn-primary">Save</button>
                            <a href="<?php echo Backend_URL . 'cms/category'; ?>" class="btn btn-default">Reset</a>
                        </div>

                    </form>

                </div>
            </div>
        </div>
        
        <div class="col-sm-8 col-xs-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-md-4 pull-left">
                            <h3 class="panel-title"><i class="fa fa-list"></i> Category List</h3>
                        </div>
                        <div class="col-md-8 text-right"> </div>
                    </div>
                </div>
                <div class="panel-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th width="25">ID</th>
                                    <th>Name</th>
                                    <th>Parent</th>
                                    <th>slug</th>
                                    <th>Template</th>
                                    <th width="80">Thumb</th>
                                    <th width="80">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($categories as $category) { ?>
                                    <tr>
                                        <td><?php echo $category->id; ?></td>                  
                                        <td><?php echo $category->name ?></td>
                                        <td><?php echo caretoryParentIdByName($category->parent); ?></td>
                                        <td>
                                            <a href="<?php echo site_url( "category/{$category->url}" ); ?>" target="_blank">
                                                <?php echo $category->url; ?>
                                            </a>
                                        </td>
                                        <td><?php echo $category->template; ?></td>                 
                                        <td><img class="img-responsive" src="<?php echo getPhoto($category->thumb); ?>"/></td>
                                        <td><?php
                                                echo anchor(site_url(Backend_URL . 'cms/category/update/' . $category->id), '<i class="fa fa-fw fa-edit"></i>', 'class="btn btn-xs btn-warning"');
                                                echo anchor(site_url(Backend_URL . 'cms/category/delete/' . $category->id), '<i class="fa fa-fw fa-trash"></i>', 'class="btn btn-xs btn-danger" onclick="javasciprt: return confirm(\'Are You Sure ?\')"');
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
    </div>
</section>

<script type="text/javascript">    
    
    $("#name").on('keyup keypress blur change', function () {
        var Text = $(this).val();
        Text = Text.toLowerCase();
        var regExp = /\s+/g;
        Text = Text.replace(regExp, '-');
        $("#url").val(Text);
    });
</script> 
