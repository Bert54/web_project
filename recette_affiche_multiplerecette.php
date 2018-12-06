<?php
include "Donnees.inc.php";
$user_recipes = json_decode($_COOKIE['user_recipes'], true);

$GLOBALS['felem'] = false;

foreach ($user_recipes as $recipeUser) {
    foreach ($Recettes as $recipe) {
        if (strcmp($recipeUser, $recipe['titre']) == 0) {
            if ($GLOBALS['felem'] == false) {
                echo "<ul>";
                $GLOBALS['felem'] = true;
            } else {
                echo "<ul id='recipe_separator'>";
            }
            echo "<p><span style='font-size: 25px; color:red;padding-left:2%;font-weight:bold'>" . $recipe['titre'] . "</span></p><br />";
            echo "<li><span style='font-size: 18px; color:lightskyblue;'>Ingrédients : </span><br /><br /><span style ='padding-left:2%;'>";
            $elements = explode('|', $recipe['ingredients']);
            echo "<ul>";
            foreach ($elements as $el) {
                echo "<li>" . $el . "</li>";
            }
            echo "</ul></span></li><br />";
            echo "<li><span style='font-size: 18px; color:lightskyblue;'>Préparation : </span><br /><br /><span style ='padding-left:2%;'>" . $recipe['preparation'] . "</span></li><br />";
            echo "</ol></li>";
            echo "</ul>";
        }
    }
}

?>