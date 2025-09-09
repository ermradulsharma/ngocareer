<div class="page-banner">   
    <img src="assets/theme/images/news-banner.jpg" class="img-responsive">
</div>
<!-- <div class="container">
    <div class="page-title">
        <h1><?php //echo $category_name; ?></h1>
    </div>
</div> -->
<div class="container">
    <?php if( $posts_data ){ ?>
    <?php foreach ( $posts_data as $post ) :  ?>
    <div class="news-list">
        <div class="row">
            <div class="col-md-4">
                <?php echo getCMSFeaturedThumb($post->thumb,'340,308'); ?>
            </div>
            <div class="col-md-8">
                <h3><?php echo $post->post_title; ?></h3>
                <div class="date"><?php echo globalDateFormat($post->modified); ?></div>
                <p><?php echo getShortContent($post->content, 230); ?></p>
                <p><a class="donation" href="<?php echo $post->post_url; ?>">Read More</a></p>
            </div>
        </div>                
        <div class="clearfix"></div>
    </div>
    <?php endforeach; ?>
    <?php } else{ echo '<p class="alert alert-danger">Post Not Found!</p>'; } ?> 
</div>

