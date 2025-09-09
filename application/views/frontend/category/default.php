<?php
//$posts_data;
//$category_id;
//$category_thumb;
//$category_name;
//$category_parent_id;
//$category_description;
?>

<!--Banner section Start -->
<div class="container-fluid">
    <div class="row">	
        <div class="banner page-banner news-media-title">
            <img class="img-responsive" src="assets/theme/images/green-banner.jpg">
            <div class="container">
                <div class="banner-title animate_when_almost_visible fm_bottom-to-top">NEWS & MEDIA</div>
            </div>
        </div>
    </div>
</div>
<!--Banner section End --> 

<div class="container">
    <div class="row">
        <div class="col-sm-3 sidebar">
            <?php echo blogCatList( 90 ); ?> 
            <div class="sidenav">
                <div class="class_name" id="">
                    <ul>
                        <li><a href="category/press-release">PRESS RELEASE</a></li>
                        <li><a href="publications">Publications</a></li>
                        <li><a href="photo-gallery">PHOTO GALLERY</a></li>
                        <li><a href="category/events-and-activities">EVENTS AND ACTIVITIES</a></li>
                    </ul>
                </div>       
            </div>
        </div>
        <div class="col-sm-9">
            <h1 class="animate_when_almost_visible fm_right-to-left"><?php echo $category_name; ?></h1>
            <?php if( $posts_data ){ ?>
            <?php foreach ( $posts_data as $post ) :  ?>
            <div class="box animate_when_almost_visible fm_right-to-left newsbox">

                <div class="col-md-12">
                    <p><strong><?php echo $post->post_title; ?></strong></p>
                    <p><?php echo getShortContent($post->content, 230); ?></p>
                    <p class="btn-eq"><a class="custom_btn" href="<?php echo $post->post_url; ?>">Read More</a></p>
                </div>
                <div class="clearfix"></div>
            </div>
            <?php endforeach; ?>
            <?php } else{ echo '<p class="alert alert-danger">Post Not Found!</p>'; } ?>            
        </div>
    </div>
</div>
