<style>
    .page-404{
        margin-top: 10px;
        padding: 100px 0px;
        background-color: #FFF;
    }   
</style>


<section class="containter-fulid">
    <div class="container">
        <div class="col-md-12 text-center page-404">
            <h2>404. That’s an error.</h2>
            <p>The requested URL /<?php echo ($this->uri->segment(1)); ?> was not found on this server. That’s all we know</p>
            
            <a href="<?php echo base_url(); ?>" class="take-home">
                <i class="fa fa-long-arrow-left"></i> 
                Back to home page
            </a>
        </div>
    </div>    
</section>