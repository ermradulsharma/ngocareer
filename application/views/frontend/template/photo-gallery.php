<style>
    .album_wish ul {}
    /*.album_wish ul li, #album li  { margin-bottom: 15px; }*/
    .album_wish ul li, #album li  { padding: 5px; }
    .album_wish ul li img { margin-bottom: 10px; }
    .album_p { display: block !important; text-align: center; }
</style>
<?php if($thumb): ?>
<div class="page-banner hidden-xs">   
    <img src="<?php echo $thumb; ?>" class="img-responsive">
</div>
<?php endif; ?>
<div class="page-banner-mob hidden-lg hidden-md hidden-sm"><img class="img-responsive" src="assets/theme/images/gallery-mob.jpg" /></div>


<section class="blog_section white_bg">

<!--Banner section Start -->
<div class="container-fluid">
    <div class="clearfix">   
        <div class="banner page-banner glance-title">
            <?php echo getCMSPhotoFront($thumb); ?>
            <div class="container">
                <div class="banner-title animate_when_almost_visible fm_bottom-to-top">
                    <?php // echo $title; ?>
                </div>
            </div>
        </div>
    </div>
</div>
<!--Banner section End -->

<div class="container gallery_page">
    <div class="row">
        <div class="col-sm-12">
            <h1 class="my_h1"><?php echo $title; ?></h1>
            <?php echo $content;?>
            
            <?php
            //echo getGallery();
            //$group_id = (int) $this->input->get('group_id');
            $album_id = (int) $this->input->get('album_id');
            
           
            // Get Sub Album 
            echo getGalleryAlbum($album_id);

            // Get Photo
            echo getGallery($album_id);
            
            ?>

        </div>
    </div>
</div>

</section>


<script src="assets/lib/plugins/lightbox/js/lightbox-plus-jquery.min.js"></script>;
<script> jQuery.noConflict();
    lightbox.option({ 'resizeDuration': 200, 'wrapAround': true  }) ;
</script>
