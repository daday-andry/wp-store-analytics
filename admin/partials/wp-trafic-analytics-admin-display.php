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
        <div class="detail col-sm-4">
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
            <div class="detail-graph">

            </div>            
        </div>
    <div>
</section>

