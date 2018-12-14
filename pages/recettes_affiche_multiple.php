<?php

/**
 * Cette page chargée par AJAX permet d'afficher des recettes à partir d'un ingrédient par récursivité, c'est-à-dire
 * si cet ingrédient possède une sous-catégorie, alors on relance la recherche avec cette sous-catégorie.
 *
 */
include "../Donnees.inc.php";
session_start();
$elem = $_REQUEST["elem"];
$elemDisplay = array();
//$recipePictures = json_decode($_COOKIE['recipes_pictures']);
//$recipePicturesFormat = json_decode($_COOKIE['recipes_pictures_format']);
$recipePictures = json_decode($_SESSION['recipes_pictures']);
$recipePicturesFormat =json_decode( $_SESSION['recipes_pictures_format']);

echo "<h1 style='position:relative;text-align: center;'>Les recettes</h1>";


$GLOBALS['felem'] = false;
$GLOBALS['recipe_displayed'] = array();

displayElementHierarchy($Recettes, $Hierarchie, $elem, $elemDisplay, $recipePictures, $recipePicturesFormat);
if (!$GLOBALS['felem']) {
    echo "<p><i>Pas de recettes trouvées.</i></i></p>";
}

function displayElementHierarchy($Recettes, $Hierarchie, $elemSearch, $elemDisplay, $recipePictures, $recipePicturesFormat) {
    if (array_key_exists('sous-categorie', $Hierarchie[$elemSearch])) {
        foreach ($Hierarchie[$elemSearch]['sous-categorie'] as $sub_element) {
            displayElementHierarchy($Recettes, $Hierarchie, $sub_element, $elemDisplay, $recipePictures, $recipePicturesFormat);
        }
    }
    else {
        $i = 0;
        foreach ($Recettes as $recipe) {
            if (!in_array($recipe['titre'], $GLOBALS['recipe_displayed']) && in_array($elemSearch, $recipe['index'])) {
                array_push($GLOBALS['recipe_displayed'], $recipe['titre']);
                if ($GLOBALS['felem'] == false) {
                    echo "<ul>";
                    $GLOBALS['felem'] = true;
                } else {
                    echo "<ul id='recipe_separator'>";
                }
                echo "<p><span style='font-size: 25px; color:red;padding-left:2%;font-weight:bold'>" . $recipe['titre'] . "</span></p><br />";
                if (in_array(strtolower($recipe['titre']), $recipePicturesFormat)) {
                    $key = array_search(strtolower($recipe['titre']), $recipePicturesFormat);
                    echo "<img id='recipe_picture' src='./Photos/" . $recipePictures[$key] . "' />";
                }
                echo "<li><span style='font-size: 18px; color:lightskyblue;;'>Ingrédients : </span><br /><br /><span style ='padding-left:2%;'>";
                $elements = explode('|', $recipe['ingredients']);
                echo "<ul>";
                foreach ($elements as $el) {
                    echo "<li>" . $el . "</li>";
                }
                echo "</ul></span></li><br />";
                echo "<li><span style='font-size: 18px; color:lightskyblue;'>Préparation : </span><br /><br /><span style ='padding-left:2%;'>" . $recipe['preparation'] . "</span></li><br />";
                echo "</ol></li>";
                echo "</ul>";
                echo "<a href='#' onClick='addRecipeToFavourites(\"" . $recipe['titre'] . "\")'><p id='add_recipe_fav' style ='padding-left:3%;color:#ffffaa;font-size:18px;'>Ajouter à mes favoris</p></a>";
            }
        }
    }
}

?>