<?php
defined('BASEPATH') OR exit('No direct script access allowed');
load_module_asset('users', 'css');
load_module_asset('users', 'js');
?>

<section class="content-header">
    <h1>User Details <small>of</small> <?php echo $first_name . ' ' . $last_name; ?> </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Admin </a></li>        
        <li class="active">User list</li>
    </ol>
</section>

<section class="content">

    <?php echo Users_helper::makeTab($id, 'profile'); ?>

    <div class="box box-primary no-border">
        <div class="box-body">
            <table class="table table-striped table-bordered">                
                <tr>
                    <td width="150">Full Name</td>
                    <td><?php echo $first_name . ' ' . $last_name; ?></td>
                </tr>
                <tr>
                    <td>Email Address</td>                 
                    <td><?php echo $email; ?></td>
                </tr>
                <tr>
                    <td>Contact</td>
                    <td><?php echo $contact; ?></td>
                </tr>

                <tr>
                    <td>Registration Date</td>
                    <td><?php echo globalDateFormat($created_at); ?>


                        <em><a> [ counting <?php echo sinceCalculator($created_at); ?> ] </a></em></p>
                </tr>
                </tr>


                <div class="row" style="padding-top20px">
                    <td>Address Line 1</td>                 
                    <td><?php echo $add_line1; ?></td>
                    </tr>
                    <tr>
                        <td>Address Line 2</td>                 
                        <td><?php echo $add_line2; ?></td>
                    </tr>

                    <tr>
                        <td>City</td>                 
                        <td><?php echo $city; ?></td>
                    </tr>


                    <tr>
                        <td>State/Region</td>
                        <td><?php echo $state; ?></td>
                    </tr>


                    <tr>
                        <td>Postcode</td>
                        <td><?php echo $postcode; ?></td>
                    </tr> 


                    <tr>
                        <td>Country</td>
                        <td><?php echo $country_id; ?></td>
                    </tr> 
            </table>



        </div>
    </div>                        

</section>