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
        <div class="detail col-sm-4">
            <div class="panel panel-primary">
                <div class="panel-heading">Detail</div>
                <div class="panel-body">
                <?php 
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
            <div class="detail-graph">

            </div>            
        </div>
    <div>
</section>

