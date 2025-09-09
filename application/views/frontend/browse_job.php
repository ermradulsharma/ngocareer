<div class="page-content">
    <div class="container browsejob">
        <h1>Browse Job by Category</h1>        
        <?php echo Ngo::getAllJobsByCategories(); ?>
        
        <hr/>
        <h1>Browse Job by Organization Type</h1>
        
        <?php echo Ngo::orgType(); ?>   
        
        <hr/>
        <h1>Browse Job by Popular Location</h1>
        
        <?php echo Ngo::popularLocations(); ?>                
    </div>
</div>

