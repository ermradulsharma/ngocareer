<div class="container">
    <div class="event_details">
        <div class="row">
            <div class="col-sm-9">
                <div class="event-details-left">
                    <div class="event-details-left-banner clearfix text-center">
                        <img src="<?php echo getPhoto($image)?>" alt="<?php echo $title;?>"/>
                    </div>
                    <div class="event-details-left-text">
                    <h1><?php echo $title;?></h1>                    
                    <p><b>Location:</b> <?php echo $location;?></p>
                    
                    <p><b>Physical Address :</b> <?php
                        $p_address = '';
                        if($physical_address){
                            $p_address .= $physical_address.', ';
                        }
                        if($region){
                            $p_address .= $region.', ';
                        }
                        if($country_id){
                            $p_address .= getCountryName($country_id).'.';
                        }
                        echo rtrim($p_address, ',');
                        ?></p>

                    <p><b>Date:</b> <?php echo GDF($start_date).' - '.GDF($end_date); ?></p>
                    <p><b>Category:</b> <?php echo $category_name;?></p>
                    <p><b>Summary:</b> <?php echo $summary;?></p>
                    <p><b>Overview:</b> <?php echo $description;?></p>
                    <?php echo $full_description;?>
                    
                    
                    <p><br/><br/><b>Event Link:</b> <a class="btn btn-link" target="_blank" href="<?php echo $event_link;?>"><?php echo $event_link;?></a></p>
                   
                    </div>
                </div>
            </div>
            
            
            
            <div class="col-sm-3 event-right">
                <div class="panel panel-default event-right1">
                    <div class="panel-body">
                        <img class="img-responsive" src="<?php echo getPhoto($company_logo);?>" alt="Company Logo">
                        <h3>Organization Details</h3>
                        <p><b>Company:</b> <?php echo $company_name;?></p>
                        <p><b>Name:</b> <?php echo $organizer_name;?></p>
                        <p><b>Type:</b> <?php echo $organization_type;?></p>
                        <p><b>Details:</b> <?php echo $organization_details;?></p>
                        
                        <p>About Company: <?php echo $about_company; ?></p>
                    </div>
                  </div>
                <div class="panel panel-default event-right2">
                    <div class="panel-body">
                        <h3>Google Map</h3>
                    </div>
                    <?php echo initGoogleMap($lat,$lng,'event-position','Event Position on Google Map'); ?>                    
                  </div>
            </div>
        </div>        
    </div>
    
    <div class="event_categories">
        <h2>Event Categories</h2>        
        <?php echo Ngo::getEventByCategories(); ?>
    </div>
</div>
