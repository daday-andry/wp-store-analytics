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
<link rel="stylesheet" href="">
<!-- This file should primarily consist of HTML with a little bit of PHP. -->
<h1>Dashboard sss</h1>

<h1>fa fa-address-book</h1>

<i class="fa-lg fa-address-book"></i>
<i class="fa-2x fa-address-book" style="font-size:24px"></i>
<i class="fa-3x fa-address-book" style="font-size:36px"></i>
<i class="fa fa-address-book" style="font-size:48px;color:red"></i>
<br>
<div id="chart1">

</div>


<script type="text/javascript" src="/wp-content/plugins/wp-store-analytics/admin/js/jqplot/jquery.jqplot.js"></script>
<script type="text/javascript" src="/wp-content/plugins/wp-store-analytics/admin/js/jqplot/jqplot.barRenderer.js"></script>



<script type="text/javascript">
jQuery(document).ready(function(){
  /*
  var data = [
    ['Heavy Industry', 40],['Retail', 60] ];
  var plot1 = jQuery.jqplot ('chart1', [data], 
    { 
      seriesDefaults: {
        // Make this a pie chart.
        renderer: jQuery.jqplot.PieRenderer, 
        rendererOptions: {
          // Put data labels on the pie slices.
          // By default, labels show the percentage of the slice.
          showDataLabels: true
        }
      }, 
      legend: { show:true, location: 'e' }
    }
  );
*/
    // A Bar chart from a single series will have all the bar colors the same.
    var line1 = [['Nissan', 4],['Porche', 9],['Acura', 2],['Aston Martin', 5],['Rolls Royce', 6]];
 
    jQuery.jqplot('chart1',[line1], {
        title:'Default Bar Chart',
        seriesDefaults:{
            renderer:jQuery.jqplot.BarRenderer
        },
        axes:{
            xaxis:{
                renderer: jQuery.jqplot.CategoryAxisRenderer
            }
        }
    });



});

</script>