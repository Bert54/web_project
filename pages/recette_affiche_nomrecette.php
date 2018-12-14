<?php

/**
 * Cette page chargée par AJAX affiche une seule recette à partir d'un nom donné.
 */

include "../Donnees.inc.php";
session_start();
$elem = $_REQUEST["elem"];
//$recipePictures = json_decode($_COOKIE['recipes_pictures']);
//$recipePicturesFormat = json_decode($_COOKIE['recipes_pictures_format']);
$recipePictures = json_decode($_SESSION['recipes_pictures']);
$recipePicturesFormat =json_decode( $_SESSION['recipes_pictures_format']);
foreach($Recettes as $recipe) {
    if (strcmp($elem, $recipe['titre']) == 0) {
        echo "<ul>";
        echo "<p><span style='font-size: 25px; color:red;padding-left:2%;font-weight:bold'>" . $recipe['titre'] . "</span></p><br />";
        if (in_array(strtolower($recipe['titre']), $recipePicturesFormat)) {
            $key = array_search(strtolower($recipe['titre']), $recipePicturesFormat);
            echo "<img id='recipe_picture' src='./Photos/".$recipePictures[$key]."' />";
        }
        echo "<li><span style='font-size: 18px; color:lightskyblue;'>Ingrédients : </span><br /><br /><span style ='padding-left:2%;'>";
        $elements = explode('|', $recipe['ingredients']);
        echo "<ul>";
        foreach ($elements as $el) {
            echo "<li>". $el ."</li>";
        }
        echo "</ul></span></li><br />";
        echo "<li><span style='font-size: 18px; color:lightskyblue;'>Préparation : </span><br /><br /><span style ='padding-left:2%;'>" . $recipe['preparation'] . "</span></li><br />";
        echo "</ol></li>";
        echo "</ul>";
    }
}
?>