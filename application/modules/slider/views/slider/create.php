<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<section class="content-header">
    <h1> Slider  <small><?php echo $button ?></small> <a href="<?php echo site_url(Backend_URL . 'slider') ?>" class="btn btn-default">Back</a> </h1>
    <ol class="breadcrumb">
        <li><a href="<?php echo Backend_URL ?>"><i class="fa fa-dashboard"></i> Admin</a></li>
        <li><a href="<?php echo Backend_URL ?>slider">Slider</a></li>
        <li class="active">Add New</li>
    </ol>
</section>

<section class="content">       
    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title">Add Slide in Slider</h3>
        </div>      

        <div class="box-body">
            <?php echo form_open( $action, array('class' => 'form-horizontal', 'enctype' => 'multipart/form-data', 'method' => 'post')); ?>
            
            <?php echo validation_errors(); ?>
                    
                    
                <div class="row">
                    <div class="col-md-6">                                               
                        
                        <div class="form-group">
                            <label class="col-md-2 control-label" for="name">Title</label>
                            <div class="col-md-10">
                                <input type="text" class="form-control" name="title" id="title" placeholder="Title/Heading" />
                                <?php echo form_error('title') ?>
                            </div>
                        </div>
                        
                        
                        <div class="form-group">
                            <label class="col-md-2 control-label" for="content">Description</label>
                            <div class="col-md-10">
                                <textarea name="content" rows="8" class="form-control" id="content" placeholder="Caption"></textarea>                                
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label class="col-md-2 control-label"></label>
                            <div class="col-md-10">
                                <button type="submit" class="btn btn-primary">Upload Photo</button> 
                                <a href="admin/slider" class="btn btn-default">Cancel</a> 
                            </div>
                        </div>
                        
                        
                    </div>
                    <div class="col-md-6"> 
                        <div class="thumbnail upload_image">                     
                            <img src="<?php echo getSliderPhoto('hello.png', 'full'); ?>">
                        </div>
                        
                        <div class="btn btn-default btn-file">
                            <i class="fa fa-picture-o"></i> Set Thumbnail 
                            <input type="file" 
                                   name="thumb" 
                                   class="file_select" 
                                   onchange="photoPreview(this, '.upload_image')"/>
                        </div>
                    </div>
                </div>               
            </form>
        </div>
    </div>
</section>  
<?php load_module_asset('slider','js');?>