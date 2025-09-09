<div class="container blog">
    <div class="row">
        <div class="col-sm-9 no-padding">
            <div class="page-title">
                <h1><?php echo $post_title; ?></h1>
            </div>
            <div class="text-center"><?php echo getPhotoDefault($thumb, 'img-responsive', 1170, 550, 3); ?></div>
            <div class="post-content"><?php echo $content; ?></div>

            <div class="clearfix"></div>

            <div class="news-slide">
                <div class="container">
                    <h2 class="text-center">One the Same Topic</h2>
                    <?php echo getRelatedPost($parent_id, 4); ?>
                </div>
            </div>

            <div class="clearfix"></div>
            <?php
            if (getSettingItem('Commenting') == 'Yes'):
                $this->load->view('frontend/template/comment', [
                    'post_id' => $id
                ]);
            endif;
            ?>
        </div>

        <div class="col-sm-3">
            <div class="blog-right">
                <div class="box-right-blog">
                    <h3>Categories</h3>
                    <ul>
                        <?php
                        foreach ($allCategory as $cat_data): ?>
                            <li><a href="<?php echo site_url('ngo-career-advice/'.$cat_data->url); ?>"><?php echo $cat_data->name; ?></a></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
                <div class="box-right-blog">
                    <h3>Recent Posts</h3>
                    <ul>
                        <?php foreach ($recent_posts as $r): ?>
                            <li><a href="<?php echo site_url($r->post_url); ?>"><?php echo getShortContent($r->post_title, 50); ?></a></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
<!--            <div class="box-right-blog">-->
<!--                <h3>Recent Comments</h3>-->
<!--                <ul>-->
<!--                    --><?php //foreach ($recent_comments as $c): ?>
<!--                        <li>--><?php //echo getShortContent($c->comment, 50); ?><!--</li>-->
<!--                    --><?php //endforeach; ?>
<!--                </ul>-->
<!--            </div>-->
                <div class="box-right-blog">
                    <h3>Archives</h3>
                    <ul>
                        <?php
                        $html = '';
                        for ($i = 1; $i <= 12; $i++) {
                            $name = date("M - Y", strtotime( date( 'Y-m-01' )." -$i months"));
                            $value = date("Y-m", strtotime( date( 'Y-m-01' )." -$i months"));
                            $html .= '<li><a href="ngo-career-advice?archive='.$value.'">'.$name. countArchiveComment($value) .'</a></li>';
                        }
                        echo $html;
                        ?>
                    </ul>
                </div>

                <div class="box-right-blog">
                    <h3>Recent Jobs</h3>
                    <ul>
                        <?php foreach ($recent_jobs as $job): ?>
                            <li><a href="<?php echo site_url("job-details/{$job->id}/" . slugify($job->title) . '.html'); ?>"><?php echo getShortContent($job->title, 50); ?></a></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
