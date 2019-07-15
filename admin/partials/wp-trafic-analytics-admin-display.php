<?php

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       andrynirina.portfoliobox.net
 * @since      1.0.0
 *
 * @package    Wp_Store_Analytics
 * @subpackage Wp_Store_Analytics/admin/partials
 */
?>
<!-- This file should primarily consist of HTML with a little bit of PHP. -->
<section>
    <h1>Trafic analytics</h1><hr>
</section>
<section>
    <div class="main-content row">
        <div class="map-container col-sm-8">
            <div class="map_view" id="map_view" style="width:100%; height: 800px"> 
            </div>
        </div>
        <div class="detail col-sm-4 row">
            <nav>
                <ol class="breadcrumb" id="map_path">
                    <li class="breadcrumb-item"><a href="#"><i class="fa fa-globe"></i></a></li>
                    <li class="breadcrumb-item active">Accessories</li>
                </ol>
            </nav>    
                <!--span><a href="#">World</a>/<i id="map_path"></i></!--span -->
            <div class="col-sm-8">
                <div class="panel panel-primary">
                    <div class="panel-heading">Overview</div>
                    <div class="panel-body">
                        <ul class="list-group">
                            <li class="list-group-item">Page view <span class="badge badge-light"><?php echo $totalPageViews ?></span></li>
                            <li class="list-group-item">Visitor <span class="badge badge-light"><?php echo $totalVisitors ?></span></li>
                            <li class="list-group-item">New visitor <span class="badge badge-light"><?php echo $onlineVisitors ?></span></li>
                        </ul>
                    </div>
                </div>
            </div>
            
            <div class="col-sm-4">
                <div class="panel panel-primary">
                    <div class="panel-heading">On line</div>
                    <div class="panel-body online_user_count">
                        <i>
                            <?php echo $onlineVisitors ?>
                        </i>
                    </div>
                </div>
            </div>
            

            <div class="col-sm-12">
                <div class="panel panel-primary">
                    <div class="panel-heading">Top trafic source</div>
                    <div class="panel-body">
                        <div id="chart2"></div>
                    </div>
                </div>
            </div>


            <div class="col-sm-6">
                <div class="panel panel-primary">
                    <div class="panel-heading">Bounce Rate</div>
                    <div class="panel-body" id="chart1">
                        
                    </div>
                </div>
            </div>

            <div class="col-sm-6">
                <div class="panel panel-primary">
                    <div class="panel-heading">Detail</div>
                    <div class="panel-body">
                        <ul class="list-group">
                            <li class="list-group-item">Total page view : <?php echo $totalPageViews ?></li>
                            <li class="list-group-item">Total visitor : <?php echo $totalVisitors ?></li>
                            <li class="list-group-item">Total on line : <?php echo $onlineVisitors ?></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    <div>
</section>


<script type="text/javascript">
   jQuery(document).ready(function(){
        //bounce rate chart
        var data = [
            ['Heavy Industry', 80],['Retail', 20]
        ];
        var colors = ['#aa4644','#4573a7'];
        jQuery.jqplot.config.enablePlugins = true;
        var piePlot = jQuery.jqplot('chart1', [data], {
            seriesColors :colors,
            height: 150,
            grid:{
                drawBorder: false,
                background: '#ffffff',
                shadow:false
                },
            seriesDefaults: {
                renderer: jQuery.jqplot.PieRenderer,
                rendererOptions: 
                    {
                        diameter: 100,
                        showDataLabels:true
                    },
                pointLabels: { show: true }
            }
        });


        // Top trafic source chart
        var line1 = [['Google', 10],['Facebook', 8],['Direct accée', 6],['Inknow', 4]];
        var barPlot = jQuery.jqplot('chart2',[line1], {
            seriesDefaults:{
                renderer:jQuery.jqplot.BarRenderer,
                rendererOptions: {
                    // Set the varyBarColor option to true to use different colors for each bar.
                    // The default series colors are used.
                    varyBarColor: true
                }
            },
            axes:{
                xaxis:{
                    renderer: jQuery.jqplot.CategoryAxisRenderer
                }
            }
        });


        //Refresh chart
        jQuery(window).on('resize',function(){
            piePlot.replot();
        });
            

});
</script>