<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<section class="content-header">
    <h1>Slider <small>Control panel</small>
        <a class="btn btn-primary" href="admin/slider/create">+ Add New Slide</a>
    </h1>
    <ol class="breadcrumb">
        <li><a href="<?php echo site_url(Backend_URL) ?>"><i class="fa fa-dashboard"></i> Admin</a></li>
        <li class="active">Slider</li>
    </ol>
</section>

<section class="content">
    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">
                List of Slider 
                <span class="text-red"><em>( Drag Drop To Reorder Serial )</em></span>
            </h3>
        </div>
        
        <div class="box-body" id="list">
            <div id="respond"></div>
            <table class="table table-bordered table-striped">
                <tr>
                    <th width="40">S/L</th>
                    <th width="120">Thumb</th>
                    <th>Title & Caption</th>
                    <th width="160">Status</th>
                    <th width="140" class="text-center">Action</th>
                </tr>
                <?php foreach ($slides as $slide) { ?>
                    <tr id="item-<?php echo $slide->id; ?>">
                        <td><?php echo ++$sl; ?></td>
                        <td><img src="<?php echo getSliderPhoto($slide->thumb); ?>" class="img-responsive" width="120"/></td>
                        <td>
                            <h4 class="no-margin">Title: <?php echo $slide->post_title; ?></h4>
                            <p>Caption: <?php echo $slide->content; ?></p>
                        </td>
                        <td id="status_<?php echo $slide->id; ?>"><?php echo slideStatus($slide->status, $slide->id ); ?></td>
                        <td  class="text-center">
                            <a href="admin/slider/update/<?php echo $slide->id; ?>" class="btn btn-primary btn-xs"><i class="fa fa-edit"></i> Edit</a>
                            <span id="<?php echo $slide->id; ?>" class="btn btn-xs remove btn-danger"><i class="fa fa-times"></i> Remove</span>
                        </td>                                
                    </tr>                        
                <?php } ?>
            </table>
        </div>
    </div>
</section>
<?php load_module_asset('slider','js');?>