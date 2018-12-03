<?php
    include "Donnees.inc.php";
    $elem = $_REQUEST["elem"];
    $i=0;
    $elements;
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
            $elements = explode('|', $recipe['ingredients']);
            echo "<ul>";
            foreach ($elements as $el) {
                echo "<li>". $el ."</li>";
            }
            echo "</ul></span></li><br />";
            echo "<li><span style='font-size: 18px; color:lightskyblue;'>Préparation : </span><br /><br /><span style ='padding-left:2%;'>" . $recipe['preparation'] . "</span></li><br />";
            echo "</ol></li>";
            echo "</ul>";
            echo "<a href='#' onClick='addRecipeToFavourites(\"".$recipe['titre']."\")'><p id='add_recipe_fav' style ='padding-left:2%;color:#ffffaa;font-size:18px;'>Ajouter cette recette à ma liste des recettes favorites</p></a>";
            $i++;
            $found = true;
        }
    }
    if (!$found) {
        echo "<p style='position:absolute;'><i>Pas de recettes trouvées.</i></i></p>";
    }
?>