<?php

/**
 * Cette page chargée par AJAX effectue l'affichage des recettes à partir d'un ingrédient qui est une feuille de la
 * hiérarchie.
 */

    include "../Donnees.inc.php";
	include("../bdd_connexion.php");
	session_start();
    $elem = $_REQUEST["elem"];
    $i=0;
    //$recipePictures = json_decode($_COOKIE['recipes_pictures']);
    //$recipePicturesFormat = json_decode($_COOKIE['recipes_pictures_format']);
    $recipePictures = json_decode($_SESSION['recipes_pictures']);
    $recipePicturesFormat =json_decode( $_SESSION['recipes_pictures_format']);
    $found = false;
    echo "<h1 style='position:relative;text-align: center;'>Les recettes</h1>";
    foreach ($Recettes as $recipe) {
        if (in_array($elem, $recipe['index'])) {
            if ($i == 0) {
                echo "<ul>";
            }
            else {
                echo "<ul id='recipe_separator'>";
            }
            echo "<p><b><span style='font-size: 25px; color:red;padding-left:2%;'>" . $recipe['titre'] . "</span></b></p><br />";
            echo "<li><span style='font-size: 18px; color:lightskyblue;'>Ingrédients : </span><br /><br /><span style ='padding-left:2%;'>";
            if (in_array(strtolower($recipe['titre']), $recipePicturesFormat)) {
                $key = array_search(strtolower($recipe['titre']), $recipePicturesFormat);
                echo "<img id='recipe_picture' src='./Photos/".$recipePictures[$key]."' />";
            }
            $elements = explode('|', $recipe['ingredients']);
            echo "<ul>";
            foreach ($elements as $el) {
                echo "<li>". $el ."</li>";
            }
            echo "</ul></span></li><br />";
            echo "<li><span style='font-size: 18px; color:lightskyblue;'>Préparation : </span><br /><br /><span style ='padding-left:2%;'>" . $recipe['preparation'] . "</span></li><br />";
            echo "</ol></li>";
            echo "</ul>";
            echo "<a href='#' onClick='addRecipeToFavourites(\"".$recipe['titre']."\")'><p id='add_recipe_fav' style ='padding-left:3%;color:#ffffaa;font-size:18px;'>Ajouter à mes favoris</p></a>";
            $i++;
            $found = true;
        }
    }
    if (!$found) {
        echo "<p style='display:inline-block; padding-left:5px;'><i>Pas de recettes trouvées.</i></i></p>";
    }
	mysqli_close($db_connection);
?>