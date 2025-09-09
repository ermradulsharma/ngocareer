<?php
defined('BASEPATH') or exit('No direct script access allowed');
load_module_asset('cms', 'css');
?>
<section class="content-header">
    <h1> CMS Post <small><?php echo $button ?></small> <a href="<?php echo site_url('admin/cms/posts') ?>" class="btn btn-default">Back</a> </h1>
    <ol class="breadcrumb">
        <li><a href="<?php echo Backend_URL; ?>"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="<?php echo Backend_URL; ?>cms/posts">Posts</a></li>
        <li class="active"><?php echo $button; ?></li>
    </ol>
</section>

<section class="content">
    <?php echo $this->session->flashdata('message'); ?>
    <div id="ajax_respond"></div>
    <div class="row">
        <form class="form-horizontal" action="<?php echo $action; ?>" method="post" enctype="multipart/form-data">
            <input type="hidden" name="post_type" value="post" />
            <input type="hidden" name="id" value="<?php echo $id; ?>" />
            <input type="hidden" name="old_thumb" value="<?php echo $thumb; ?>" />

            <div class="col-md-9">
                <div class="box">
                    <div class="box-body">
                        <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-pencil-square-o"></i> Page Title</span>
                            <input required="required" type="text" name="post_title" class="form-control" id="postTitle" placeholder="Page Title" value="<?php echo $post_title; ?>" />
                        </div>
                        <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-globe"></i> Page-link : <?php echo base_url(); ?></span>
                            <input type="text" name="post_url" class="form-control" value="<?php echo $post_url; ?>" id="postSlug">
                        </div>
                        <div class="form-group no-margin" style="margin-bottom: 15px;">
                            <textarea name="content" rows="10" cols="100" id="content"><?php echo $content; ?></textarea>
                        </div>

                        <div class="input-group" style="margin-top:25px;">
                            <span class="input-group-addon"><i class="fa fa-pencil-square-o"></i> SEO Title</span>
                            <input type="text" name="seo_title" class="form-control" placeholder="Page SEO Title" value="<?php echo $seo_title; ?>">
                        </div>
                        <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-pencil-square-o"></i> SEO Keyword</span>
                            <input type="text" name="seo_keyword" class="form-control" placeholder="SEO Keywords" value="<?php echo $seo_keyword; ?>">
                        </div>
                        <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-pencil-square-o"></i> SEO Description</span>
                            <textarea class="form-control" name="seo_description" rows="3" cols="100" placeholder="SEO Description"><?php echo $seo_description; ?></textarea>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="box">
                    <div class="box-header with-border">
                        <div class="form-group  no-margin">
                            <h3 class="box-title">Post Options</h3>
                        </div>
                    </div>

                    <div class="box-header with-border">
                        <div class="form-group  no-margin">
                            <label for="int" class="control-label">Category:</label>
                            <select name="parent_id" class="form-control">
                                <?php echo getCategoryDropDown($parent_id); ?>
                            </select>
                        </div>
                    </div>

                    <div class="box-header with-border">
                        <div class="form-group  no-margin">
                            <select style="width:100%;" class="form-control" name="status">
                                <?php echo cmsStatus($status); ?>
                            </select>
                        </div>
                    </div>
                    <div class="box-header with-border">
                        <div class="form-group no-margin">
                            <button type="submit" class="btn btn-flat btn-block btn-success"><i class="fa fa-save"></i> <?php echo $button; ?></button>
                        </div>
                    </div>
                </div>

                <div class="box box-success">
                    <div class="box-header with-border">
                        <div class="form-group no-margin">
                            <h3 class="box-title">Upload Feature Image</h3>
                        </div>
                        <div class="thumbnail upload_image">
                            <img src="<?php echo getPhoto($thumb, 'full'); ?>">
                        </div>
                        <div class="btn btn-default btn-file">
                            <i class="fa fa-picture-o"></i> Set Thumbnail
                            <input type="file" name="thumb" class="file_select" onchange="photoPreview(this, '.upload_image')">
                        </div>

                        <?php if($thumb){ ?>
                            <div id="remove_featured_image_btn" style="float: right;">
                                <span onclick="return removeFeaturedImage(<?php echo $id; ?>);" style="color: red;" class="btn btn-link">
                                    Remove Image
                                </span>
                            </div>
                        <?php } ?>

                    </div>
                </div>

            </div>

        </form>
    </div>
</section>

<script src="https://cdn.ckeditor.com/4.7.3/standard/ckeditor.js"></script>
<script>
    CKEDITOR.replace('content', {
        width: ['100%'],
        height: ['350px'],
        customConfig: '<?php echo site_url('assets/lib/plugins/ckeditor/config.js'); ?>'
    });

    $("#postTitle").on('keyup keypress blur change', function() {
        var Text = $(this).val();
        Text = Text.toLowerCase();
        var regExp = /\s+/g;
        Text = Text.replace(regExp, '-');
        $("#postSlug").val(Text);
        $(".pageSlug").text(Text);
    });
</script>

<?php load_module_asset('cms', 'js'); ?>