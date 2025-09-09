<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<section class="content-header">
    <h1> Login Logs  <small>Graph view</small> </h1>
    <ol class="breadcrumb">
        <li><a href="<?php echo site_url( Backend_URL )?>"><i class="fa fa-dashboard"></i> Admin</a></li>
        <li><a href="<?php echo site_url( Backend_URL . '/users/login_history' )?>"> Login History</a></li>        
        <li class="active">Graph view</li>
    </ol>
</section>

<section class="content">       
    <div class="box no-border" style="background: none;">      
        <div class="clearfix">
           
            <div class="row">
                <div class="col-md-4">                    
                    <div class="box box-success">
                        <div class="box-header with-border">
                            <h3 class="box-title">Browsers</h3>                            
                        </div>
                        <div class="box-body">
                            <div class="box-body text-center">
                                <div class="browsers"  data-width="300px" data-height="225px">                                   
                                </div>
                            </div><!-- /.box-body -->
                        </div><!-- /.box-body -->
                    </div><!-- /.box -->
                </div>
                <div class="col-md-4">                    
                    <div class="box box-success">
                        <div class="box-header with-border">
                            <h3 class="box-title">User Role</h3>                            
                        </div>
                        <div class="box-body">
                            <div class="box-body text-center">
                                <div class="sparkline"  data-width="300px" data-height="225px">                                   
                                </div>
                            </div><!-- /.box-body -->
                        </div><!-- /.box-body -->
                    </div><!-- /.box -->
                </div>
                <div class="col-md-4">                    
                    <div class="box box-success">
                        <div class="box-header with-border">
                            <h3 class="box-title">Devices</h3>                            
                        </div>
                        <div class="box-body">
                            <div class="box-body text-center">
                                <div class="devices"  data-width="300px" data-height="225px">                                   
                                </div>
                            </div><!-- /.box-body -->
                        </div><!-- /.box-body -->
                    </div><!-- /.box -->
                </div>
                

                <div class="col-md-12">
                    <div class="box box-success">
                        <div class="box-header with-border">
                            <h3 class="box-title">Log Chart</h3>                           
                        </div>
                        <div class="box-body">
                            <div class="chart">
                                <canvas id="barChart" style="height:230px"></canvas>
                            </div>
                        </div><!-- /.box-body -->
                    </div><!-- /.box -->
                </div>
           
            </div>
        </div>
    </div>
</section>





<script src="assets/lib/plugins/chartjs/Chart.min.js"></script>
<script src="assets/lib/plugins/sparkline/jquery.sparkline.min.js"></script>

<!-- page script -->
<script>
      $(function () {

        //-------------
        //- Post CHART -
        //-------------

        var postChartData = {
            labels: <?php echo Modules::run('users/login_history/getChart'); ?>,
            datasets: [
                {
                    label: "Vendor",
                    fillColor: "#dd4b39",
                    strokeColor: "",
                    pointColor: "",
                    pointStrokeColor: "#dd4b39",
                    pointHighlightFill: "#fff",
                    pointHighlightStroke: "#dd4b39",
                    data: <?php echo Modules::run('users/login_history/getChartVendor'); ?>
                },
                {
                    label: "Customer",
                    fillColor: "#dd4b39",
                    strokeColor: "#dd4b39",
                    pointColor: "#dd4b39",
                    pointStrokeColor: "#dd4b39",
                    pointHighlightFill: "#fff",
                    pointHighlightStroke: "#dd4b39",
                    data: <?php echo Modules::run('users/login_history/getChartCustomer'); ?>
                }
            ]
        };

        var postChartCanvas = $("#barChart").get(0).getContext("2d");
        var postChart = new Chart(postChartCanvas);
        var postChartData = postChartData;
        postChartData.datasets[1].fillColor = "#00a65a";
        postChartData.datasets[1].strokeColor = "";
        postChartData.datasets[1].pointColor = "";
        var postChartOptions = {
            //Boolean - Whether the scale should start at zero, or an order of magnitude down from the lowest value
            scaleBeginAtZero: true,
            //Boolean - Whether grid lines are shown across the chart
            scaleShowGridLines: true,
            //String - Colour of the grid lines
            scaleGridLineColor: "rgba(0,0,0,.05)",
            //Number - Width of the grid lines
            scaleGridLineWidth: .5,
            //Boolean - Whether to show horizontal lines (except X axis)
            scaleShowHorizontalLines: true,
            //Boolean - Whether to show vertical lines (except Y axis)
            scaleShowVerticalLines: true,
            //Boolean - If there is a stroke on each bar
            barShowStroke: true,
            //Number - Pixel width of the bar stroke
            barStrokeWidth: 1,
            //Number - Spacing between each of the X value sets
            barValueSpacing: 10,
            //Number - Spacing between data sets within X values
            barDatasetSpacing: 1,
            //String - A legend template
            legendTemplate: "<ul class=\"<%=name.toLowerCase()%>-legend\"><% for (var i=0; i<datasets.length; i++){%><li><span style=\"background-color:<%=datasets[i].fillColor%>\"></span><%if(datasets[i].label){%><%=datasets[i].label%><%}%></li><%}%></ul>",
            //Boolean - whether to make the chart responsive
            responsive: true,
            maintainAspectRatio: true
        };

        postChartOptions.datasetFill = false;
        postChart.Bar(postChartData, postChartOptions);
        
      });
    </script>


    
    
    
    
    <!-- page script -->
    <script>

      $(function() {
          
    var myvalues = [<?php if($roles):
                                        $test = '';
                                        foreach ($roles as $role ):
                                        $test .= $role->role.',';
                                        endforeach;
                                        echo rtrim($test, ',');
                                   endif; ?>];
    $('.sparkline').sparkline(myvalues, {
        type: 'pie',
        width: '275px',
        height: '215px',
        sliceColors: ['#5d3092', '#4dc9ec', '#9de49d', '#9074b1', '#66aa00', '#dd4477', '#0099c6', '#990099'],
        borderWidth: 7,
        borderColor: '#f5f5f5',
        tooltipFormat: '<span style="color: {{color}}">&#9679;</span> {{offset:names}} ({{percent.1}}%)',
        tooltipValueLookups: {
            names: {
                <?php
                if($roles): $i = 0; 
                 foreach ($roles as $role_lev ): ?>
                <?php echo $i;  ?>: '<?php echo getRoleName($role_lev->role_id); ?>',
                
        <?php $i++; endforeach; endif;  ?>
                // Add more here
            }
        }
    });
});
      
    
$(function() {
          
    var mydevices = [<?php
        if ($devices):
            $test1 = '';
            foreach ($devices as $device):
                $test1 .= $device->devices . ',';
            endforeach;
            echo rtrim($test1, ',');
        endif;
        ?>];
    $('.devices').sparkline(mydevices, {
        type: 'pie',
        width: '275px',
        height: '215px',
        sliceColors: [ '#9de49d', '#9074b1', 'purple', '#5d3092', '#4dc9ec', '#dd4477', '#0099c6', '#990099'],
        borderWidth: 7,
        borderColor: '#f5f5f5',
        tooltipFormat: '<span style="color: {{color}}">&#9679;</span> {{offset:names}} ({{percent.1}}%)',
        tooltipValueLookups: {
            names: {
        <?php
        if ($devices): $i1 = 0;
            foreach ($devices as $device_lev):
                ?>
                <?php echo $i1; ?>: '<?php echo $device_lev->device; ?>',
                        
                <?php $i1++;
            endforeach;
        endif; ?>
                // Add more here
            }
        }
    });
});


// Browser pic chart 


  
        


$(function() {
          
    var myBrowsers = [<?php
        if ($browsers):
            $test1 = '';
            foreach ($browsers as $browser):
                $test1 .= $browser->count . ',';
            endforeach;
            echo rtrim($test1, ',');
        endif;
        ?>];
    $('.browsers').sparkline(myBrowsers, {
        type: 'pie',
        width: '275px',
        height: '215px',
        sliceColors: [ '#4dc9ec', '#dd4477', '#0099c6', '#990099', '#9de49d', '#9074b1', 'purple', '#5d3092'],
        borderWidth: 7,
        borderColor: '#f5f5f5',
        tooltipFormat: '<span style="color: {{color}}">&#9679;</span> {{offset:names}} ({{percent.1}}%)',
        tooltipValueLookups: {
            names: {
        <?php
        if ($browsers): $i2 = 0;
            foreach ($browsers as $browser_lev):
                ?>
                <?php echo $i2; ?>: '<?php echo $browser_lev->browser; ?>',
                        
                <?php $i2++;
            endforeach;
        endif; ?>
                // Add more here
            }
        }
    });
});
      
    </script>
