<div class="container blog-content">
    <div class="row">        
        <div class="col-md-3">
            <div class="blog-sidebar">
                <h2>Blog Categories</h2>
                <hr class="no-margin"/>
                <?php echo $categories; ?>
            </div>
        </div>
        <div class="col-md-9">
            <?php
            if ($blogs) {
                foreach ($blogs as $blog) {
                    $blog_url = site_url("blog/{$blog->url}/{$blog->post_url}");
                    ?>
                    <div class="blog-box">
                        <div class="row">
                            <div class="col-md-3">
                                <img class="img-responsive" 
                                     src="<?php echo getPhoto($blog->thumb ); ?>" 
                                     alt="<?php echo $blog->post_title; ?>" />
                            </div>
                            <div class="col-md-9">
                                <h1>
                                    <a href="<?php echo $blog_url; ?>">
                                        <?php echo $blog->post_title; ?>
                                    </a>
                                </h1>
                                <p><?php echo getShortContent($blog->content); ?></p>                                        
                                <p><a href="<?php echo $blog_url; ?>">Read more <i class="fa fa-external-link"></i></a></p>                                        
                            </div>
                        </div>
                    </div>
                    <?php
                }
            } else {
                echo '<p class="ajax_notice">No Blog Found!</p>';
            }
            ?>

            <div class="pagination-box">                        
                <?php //echo $pagination; ?>                        
            </div>                 
        </div>
    </div>
</div>