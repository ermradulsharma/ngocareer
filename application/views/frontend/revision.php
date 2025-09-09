<style type="text/css">
    .preview_box {
        overflow-x: scroll;
        border: 1px dotted red;
    }
</style>
<div class="page-content" style="padding: 15px 0px;">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-6 preview_box">
                <h2>CURRENT</h2>
                <hr>
                <h3><?php echo $current_data->post_title; ?></h3>
                <?php echo getCMSPhoto($current_data->thumb, 'full'); ?>  
                <?php echo $current_data->content; ?>
                <p><strong>SEO Title: </strong><?php echo $current_data->seo_title; ?></p>
                <p><strong>SEO Keyword: </strong><?php echo $current_data->seo_keyword; ?></p>
                <p><strong>SEO Description: </strong><?php echo $current_data->seo_description; ?></p>                                                
            </div>
            
                                                
            <div class="col-md-6 preview_box">
                <h2>OLD</h2>
                <hr>
                <h3><?php echo $past_data->post_title; ?></h3>
                <?php echo getCMSPhoto($past_data->thumb, 'full'); ?>  
                <?php echo $past_data->content; ?>
                <p><strong>SEO Title: </strong><?php echo $past_data->seo_title; ?></p>
                <p><strong>SEO Keyword: </strong><?php echo $past_data->seo_keyword; ?></p>
                <p><strong>SEO Description: </strong><?php echo $past_data->seo_description; ?></p>                                                
            </div>
        </div>
        
    </div>
</div>