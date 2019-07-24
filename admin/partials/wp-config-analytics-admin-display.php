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
<h1>Configuration <small>(Definir vos objectif)</small></h1><hr>

<section>
    <div class="row">
        <div class="col-sm-8">
            <div>
                <label>D'ici à :</label><input type="date">
            </div>
            <div>
                <label> Booster nombre de visiteur de : </label>
                <input type="number" min="1" max="100"/>%
            </div>
            <div>
                <label> Booster nombre de vente de : </label>
                <input type="number" min="1" max="100"/>%
            </div>
            <div>
                <label> Nouveau visiteur : </label>
                <input type="number" min="1"/>
            </div>

            <div>
                <label> Nouveau client : </label>
                <input type="number" min="1"/>
            </div>
        
        </div>




        <div class="col-sm-4">
            <h2>Estimation</h2><hr>
            <div >
                <label>Chiffre d'affaire</label>
            </div>

            <div >
                <label>Taux de conversion</label>
            </div>

            <div >
                <label>Taux de conversion</label>
            </div>

        </div>
    </div>
</section>