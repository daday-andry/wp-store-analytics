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
<style>
        .box {
            float:right;
        }

        .box select {
        background-color: transparent;
        color: white;
        margin-right: 10px;
        padding-right: 15px;
        width: 120px;
        border: none;
        font-size: 20px;
        -webkit-appearance: button;
        appearance: button;
        outline: none;
        }

        .box::before {
        content: "\f13a";
        font-family: FontAwesome;
        position: absolute;
        top: 0;
        right: 0;
        width: 20%;
        height: 100%;
        text-align: center;
        font-size: 28px;
        line-height: 45px;
        color: rgba(255, 255, 255, 0.5);

        pointer-events: none;
        }

        .box select option {
            padding-right: 30px;
            color :#328DC4;
        }

</style>
<!-- This file should primarily consist of HTML with a little bit of PHP. -->
<section>
    <h1>Store analytics</h1><hr>
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
                    <li class="breadcrumb-item"><a href="#" id="init_map_position"><i class="fa fa-globe"></i></a></li>
                    <li class="breadcrumb-item active">Accessories</li>
                </ol>
            </nav>    
            <div class="col-sm-6">
                <ul class="list-group">
                    <li class="list-group-item active">Conversion rate </li>
                    <li class="list-group-item" style="padding-top:-10px">
                        <div  id="chart4"></div>
                        <center><label>2.4 %</label></center>
                        <div class="progress">
                             <div class="progress-bar" role="progressbar" style="width: 25%;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100">25%</div>
                        </div>
                    </li>
                </ul>  
            </div>
            <div class="col-sm-6">
                <ul class="list-group">
                    <li class="list-group-item">Total sales <span class="badge badge-primary"> 22 000 Ar </span></li>
                    <li class="list-group-item">Cart abandonment rate <span class="badge badge-primary"> 70 % </span></li>
                    <li class="list-group-item">
                        Average Order <span class="badge badge-secondary">15 000 Ar</span>                        
                    </li>
                </ul>  
            </div>
            <div class="col-sm-6">
                <div id="convertion_chart"></div>
            </div>

            <div class="col-sm-12">
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        CA Evolution
                        <div class="box">
                            <select>
                                <option>Annually</option>
                                <option>Monthly</option>
                            </select>
                        </div>
                    </div>
                    <div class="panel-body">
                        <div id="ca_evolution_chart"></div>
                        <div class="progress">
                             <div class="progress-bar" role="progressbar" style="width: 30%;" aria-valuenow="30" aria-valuemin="0" aria-valuemax="100">30% of target</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <div>
</section>
<script type="text/javascript">

    //MAP Static data*****************************************************************************************************************************************************************************************************
        var map;
        var geojson;
        var myGeoJSONPath = "/wp-content/plugins/wp-store-analytics/admin/res/custom.geo.json"; 
        var mada_json_map = "/wp-content/plugins/wp-store-analytics/admin/res/mada.geojson"; 
        var legend = L.control({position: 'bottomleft'});



   jQuery(document).ready(function(){
        
        //--> CHART CONTROLLER******************************************************************************************************************************************************************************
            //Conversion rate chart
            var data = [['Surfer', 98],['Order', 2]];
            var plot4 = jQuery.jqplot('convertion_chart', [data], {
            height: 200,
            grid:{
                drawBorder: false,
                background: '#ffffff',
                shadow:false,
                    
            },
            seriesDefaults: {
                renderer:jQuery.jqplot.DonutRenderer,
                rendererOptions:{
                    sliceMargin: 3,
                    startAngle: -90,
                    showDataLabels: true,
                    dataLabels: 'value',
                    totalLabel: true,
                    }
                }
            });
            /*
                plot2 = jQuery.jqplot('convertion_chart', 
                    [[['Surfer', 98],['Order', 2]]], 
                    {
                    grid:{
                        drawBorder: false,
                        background: '#ffffff',
                        shadow:false,
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
                */
            
                // CA Evolution
                var chifre_affaire = [[1, 9200], [2,12100],[3, 12900], [4,16209],[5, 9200], [6,11500], [7,900]];
                var nbr_visiteur = [[1, 900], [2, 1000],[3, 1200], [4,1100],[5, 1100], [6,1000],[7,100]];
                var months = ['Jan', 'Feb', 'Mar', 'Apr',"May","Jun","Jul"];
                plot1 = jQuery.jqplot("ca_evolution_chart", [nbr_visiteur, chifre_affaire], {
                animate: true,
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
                        renderer: jQuery.jqplot.CategoryAxisRenderer,
                        ticks: months
                    },
                    yaxis: {
                        tickOptions: {
                            formatString: " %'d"
                        },
                        rendererOptions: {
                            forceTickAt0: true
                        }
                    },
                    y2axis: {
                        tickOptions: {
                            formatString: "%'d"
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

                // Boutique performance / Objectif
                s1 = [0.20];
        
                plot1 = jQuery.jqplot('chart4',[s1],{
                    height: 200,
                    seriesDefaults: {
                        renderer: jQuery.jqplot.MeterGaugeRenderer,
                        rendererOptions: {
                            //showTickLabels: false,
                            intervals:[0.3,0.5,1],
                            intervalColors:['#66cc66', '#E7E658', '#cc6666']
                        }
                    }
                });




                //Refresh chart
                jQuery(window).on('resize',function(){
                    piePlot.replot();
                });


        



        //--> MAP CONTROLLEUR ************************************************************************************************************
            var myCustomStyle = {
                stroke: true,
                fill: true,
                fillColor: '#fff',
                fillOpacity: 1
            }
    
            map = L.map('map_view',{minZoom: 0,maxZoom: 6}).setView([52.482780222078226,0.3515625],2);

            jQuery.getJSON(myGeoJSONPath,function(data){
            geojson = L.geoJson(data, {
                    clickable: true,
                    style: style,
                    onEachFeature: function (featureData, featureLayer) {
                        
                        featureLayer.on('mouseover',highlightFeature);
                        featureLayer.on('mouseout',resetHighlight);
                        featureLayer.on(
                            'click', function (ev) {
                                var latlng_click = map.mouseEventToLatLng(ev.originalEvent);
                                var continent_name=featureData.properties.continent;
                                var contry_name=featureData.properties.brk_name;
                                var path_html=
                                "<li class='breadcrumb-item'><a href='#' id='init_map_position'><i class='fa fa-globe'></i></a></li>"+
                                "<li class='breadcrumb-item'>"+continent_name+"</li>"+
                                "<li class='breadcrumb-item active'>"+contry_name+"</li>";
                                jQuery("#map_path").html(path_html);
                                map.setView([latlng_click.lat,latlng_click.lng],6);
                                add_contry_layer(mada_json_map); 
                                map.flyTo([latlng_click.lat, latlng_click.lng], 6, {
                                    animate: true,
                                    duration: 1.5
                                }); 
                            }
                        );

                    }
                }).addTo(map);
            })

            legend.addTo(map);


            function add_contry_layer($layer){
                jQuery.getJSON($layer,function(data){
                    L.geoJson(data, {
                        clickable: true,
                        //style: polystyle,
                        onEachFeature: function (featureData, featureLayer) {
                            featureLayer.on('click', function (ev) {
                                
                            });
                        }
                    }).addTo(map);
                })
            }
          jQuery("#map_path").on('click',function(){
                //map.removeLayer(mada_json_map);
                map.flyTo([52.482780222078226, 0.3515625], 2, {
                    animate: true,
                    duration: 1.5
                }); 
            })



    });
    function getColor(d) {
        return d > 1000 ? '#800026' :
            d > 10  ? '#BD0026' :
            d > 8  ? '#E31A1C' :
            d > 6  ? '#FC4E2A' :
            d > 5   ? '#FD8D3C' :
            d > 3   ? '#FEB24C' :
            d > 2   ? '#FED976' :
                        '#FFEDA0';
        }
    function style(feature) {
        return {
            stroke: true,
            fill: true,
            fillColor: getColor(feature.properties.mapcolor9),
            weight: 2,
            opacity: 1,
            color: 'white',
            dashArray: '3',
            fillOpacity: 0.7
        };
    }
    function highlightFeature(e) {
        var layer = e.target;
        layer.setStyle({
            stroke: true,
            fill: true,
            fillColor:"#37B3C2",
            weight: 2,
            color: 'white',
            dashArray: '',
            fillOpacity: 0.7
        });

        if (!L.Browser.ie && !L.Browser.opera && !L.Browser.edge) {
            layer.bringToFront();
        }
    }
    function resetHighlight(e) {
        geojson.resetStyle(e.target);
    }
    
    legend.onAdd = function (map) {
        var div = L.DomUtil.create('div', 'info legend'),
            grades = [0, 2, 3, 5, 6, 8, 10],
            labels = [];

        div.innerHTML+="<h4>Customer distribution </h4>";
        // loop through our density intervals and generate a label with a colored square for each interval
        for (var i = 0; i < grades.length; i++) {
            div.innerHTML +=
                '<i style="background:' + getColor(grades[i] + 1) + '"> &nbsp;&nbsp;&nbsp;&nbsp; </i> &nbsp; ' +
                grades[i]*100 + (grades[i + 1] ? '&ndash;' + (grades[i + 1]*100) + '<br>' : '+');
        }
        return div;
    };

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