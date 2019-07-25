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
        <div class="col-sm-6">
            <div class="row">
                <div class="col-sm-4">
                    <div class="form-group">
                        <label for="exampleInputEmail1">D'ici à :</label>
                        <input type="date" class="form-control" size="10" >
                    </div>

                    <div class="form-group">
                        <label for="exampleInputEmail1">Booster nombre de visiteur de :</label>
                        <input type="number" class="form-control" size="10" >
                    </div>

                    <div class="form-group">
                        <label for="exampleInputEmail1">Booster nombre de vente de :</label>
                        <input type="number" class="form-control" size="10" >
                    </div>

                    <div class="form-group">
                        <label for="exampleInputEmail1">Nouveau visiteur :</label>
                        <input type="number" class="form-control" size="10" >
                    </div>

                    <div class="form-group">
                        <label for="exampleInputEmail1">Nouveau client :</label>
                        <input type="number" class="form-control" size="10" >
                    </div>

                    <div class="form-group">
                        <label for="exampleInputEmail1">Taux d'abandon de pannier :</label>
                        <input type="number" class="form-control" size="10" >
                    </div>
                    <hr>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Recevoir de rapport par mail : </label>
                        <div class="form-check">
                            <input type="radio" class="form-check-input" id="materialUnchecked" name="materialExampleRadios">
                            <label class="form-check-label" for="materialUnchecked">Journalier</label>
                        </div>

                        <div class="form-check">
                            <input type="radio" class="form-check-input" id="materialChecked" name="materialExampleRadios" checked>
                            <label class="form-check-label" for="materialChecked">Hebdomadaire</label>
                        </div>
                        <div class="form-check">
                            <input type="radio" class="form-check-input" id="materialUnchecked" name="materialExampleRadios">
                            <label class="form-check-label" for="materialUnchecked">Mensuelle</label>
                        </div>

                        <div class="form-check">
                            <input type="radio" class="form-check-input" id="materialChecked" name="materialExampleRadios" checked>
                            <label class="form-check-label" for="materialChecked">Annuelle</label>
                        </div>
                        <div>
                            <label>Adresse mail</label>
                            <input type="mail" class="form-control">
                        </div>
                        
                    </div>
                </div>
            </div>
        </div>

        <div class="col-sm-3">
            <h2>Estimation de vente</h2><hr>
            <div>
                <label>Chiffre d'affaire</label>
                <input type="number" class="form-control">
            </div>

            <div >
                <label>Taux de conversion</label>
                <input type="number" class="form-control">
            </div>
            <div >
                <label>Panier moyen</label>
                <input type="number" class="form-control">
            </div>
            <hr>
            <div>
                <button class="btn btn-primary float-right">Enregistrer</button>
            </div>
        </div>
    </div>
</section>