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
    <h1>Store analytics</h1><hr>
    <nav class="breadcrumb" role="navigation">
        <span>Map://<i id="map_path"></i></span>
    </nav>
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
            <div class="col-sm-6">
                <div class="panel panel-primary">
                    <div class="panel-heading">Convertion rate</div>
                    <div class="panel-body">
                        <div id="convertion_chart"></div>
                            Taux de convertion = nombre de commandes/nbr visite
                    </div>
                </div>
            </div>

            <div class="col-sm-6">
                <div class="panel panel-primary">
                    <div class="panel-heading"> Fidelization rate </div>
                    <div class="panel-body">
                    Nouveaux clients / clients récurrents
                    </div>
                </div>
            </div>

            <div class="col-sm-6">
                <div class="panel panel-primary">
                    <div class="panel-heading">Average Order</div>
                    <div class="panel-body">
                            Taux de convertion
                    </div>
                </div>
            </div>

            <div class="col-sm-12">
                <div class="panel panel-primary">
                    <div class="panel-heading">CA Evolution</div>
                    <div class="panel-body">
                        <div id="ca_evolution_chart"></div>
                            Taux de convertio
                    </div>
                </div>
            </div>

            <div class="col-sm-6">
                <div class="panel panel-primary">
                    <div class="panel-heading">Cart abandonment rate</div>
                    <div class="panel-body">
                            Taux de convertion
                    </div>
                </div>
            </div>

            <div class="col-sm-12">
                <div class="panel panel-primary">
                    <div class="panel-heading">Product relationship</div>
                    <div class="panel-body">
                        <div id="chart2"></div>
                            Taux de convertion
                    </div>
                </div>
            </div>


            


                        
        </div>
    <div>
</section>
<script type="text/javascript">
   jQuery(document).ready(function(){
        //Conversion rate chart
        /*
        var data = [
            ['Surfer', 80],['Customer', 20]
        ];
        var colors = ['#aa4644','#4573a7'];
        jQuery.jqplot.config.enablePlugins = true;
        var piePlot = jQuery.jqplot('convertion_chart', [data], {
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
        });*/
        plot2 = jQuery.jqplot('convertion_chart', 
            [[['Surfer', 80],['Order', 20]]], 
            {
            grid:{
                drawBorder: false,
                background: '#ffffff',
                shadow:false,
                diameter: 100,
            },
            seriesDefaults: {
                diameter: 80,
                shadow: false, 
                renderer: jQuery.jqplot.PieRenderer, 
                rendererOptions: { 
                startAngle: 180, 
                sliceMargin: 4, 
                showDataLabels: true } ,
                pointLabels: { show: true },
                },
            legend: { show:true, location: 'e' }

            }
        );


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

        // CA Evolution
        var s1 = [[2002, 112000], [2003, 122000], [2004, 104000], [2005, 99000], [2006, 121000], 
                [2007, 148000], [2008, 114000], [2009, 133000], [2010, 161000], [2011, 173000]];
        var s2 = [[2002, 10200], [2003, 10800], [2004, 11200], [2005, 11800], [2006, 12400], 
        [2007, 12800], [2008, 13200], [2009, 12600], [2010, 13100]];
 
        plot1 = jQuery.jqplot("ca_evolution_chart", [s2, s1], {
        // Turns on animatino for all series in this plot.
        animate: true,
        // Will animate plot on calls to plot1.replot({resetAxes:true})
        animateReplot: true,
        cursor: {
            show: true,
            zoom: true,
            looseZoom: true,
            showTooltip: false
        },
        series:[
            {
                pointLabels: {
                    show: true
                },
                renderer: jQuery.jqplot.BarRenderer,
                showHighlight: false,
                yaxis: 'y2axis',
                rendererOptions: {
                    // Speed up the animation a little bit.
                    // This is a number of milliseconds.  
                    // Default for bar series is 3000.  
                    animation: {
                        speed: 2500
                    },
                    barWidth: 15,
                    barPadding: -15,
                    barMargin: 0,
                    highlightMouseOver: false
                }
            }, 
            {
                rendererOptions: {
                    // speed up the animation a little bit.
                    // This is a number of milliseconds.
                    // Default for a line series is 2500.
                    animation: {
                        speed: 2000
                    }
                }
            }
        ],
        axesDefaults: {
            pad: 0
        },
        axes: {
            // These options will set up the x axis like a category axis.
            xaxis: {
                tickInterval: 1,
                drawMajorGridlines: false,
                drawMinorGridlines: true,
                drawMajorTickMarks: false,
                rendererOptions: {
                tickInset: 0.5,
                minorTicks: 1
            }
            },
            yaxis: {
                tickOptions: {
                    formatString: "$%'d"
                },
                rendererOptions: {
                    forceTickAt0: true
                }
            },
            y2axis: {
                tickOptions: {
                    formatString: "$%'d"
                },
                rendererOptions: {
                    // align the ticks on the y2 axis with the y axis.
                    alignTicks: true,
                    forceTickAt0: true
                }
            }
        },
        highlighter: {
            show: true, 
            showLabel: true, 
            tooltipAxes: 'y',
            sizeAdjust: 7.5 , tooltipLocation : 'ne'
        }
    });





        //Refresh chart
        jQuery(window).on('resize',function(){
            piePlot.replot();
        });
            

});
</script>



<!---- Liste des client
<div class="panel panel-primary">
    <div class="panel-heading">Detail</div>
    <div class="panel-body">
    < 
    $args = array(
        'post_type' => 'shop_order',
        'post_status'=>'wc-completed',
        'posts_per_page' => '-1'
        );
        $my_query = new WP_Query($args);
        foreach ($my_query->posts as $key => $order) {
            # code...
            $order = wc_get_order($order->ID);
            $order_data = $order->get_data();
            echo "<strong>".$order_data['shipping']['first_name']." ".$order_data['shipping']['last_name']."</strong><br>";
            echo "&nbsp <span>".$order_data['shipping']['state']."</span>";
            echo "&nbsp <span>".$order_data['shipping']['country']."</span>";
            echo "&nbsp <span>".$order_data['shipping']['city']."</span>";
            echo "&nbsp <span>".$order_data['shipping']['postcode']."</span>";
            echo "&nbsp <span>".$order_data['shipping']['address_1']."</span>";
            echo "&nbsp <span> / ".$order_data['billing']['email']."</span>";
            echo "&nbsp <span> - ".$order_data['billing']['phone']."</span>";
            echo   '<hr>';
        }
    ?>
    </div>
    </div>
    -->