<?php
    include "Donnees.inc.php";
    $elem = $_REQUEST["elem"];
    $i=0;
    echo "<h1 style='text-align: center;'>Les recettes</h1>";
    foreach ($Recettes as $recipe) {
        if (in_array($elem, $recipe['index'])) {
            if ($i == 0) {
                echo "<ul>";
            }
            else {
                echo "<ul id='recipe_separator'>";
            }
            echo "<li><span style='font-size: 25px; color:blue;'>Recette : </span><br /><br /><span style ='padding-left:2%;'>" . $recipe['titre'] . "</span></li><br />";
            echo "<li><span style='font-size: 25px; color:blue;'>Quantités : </span><br /><br /><span style ='padding-left:2%;'>" . $recipe['ingredients'] . "</span></li><br />";
            echo "<li><span style='font-size: 25px; color:blue;'>Préparation : </span><br /><br /><span style ='padding-left:2%;'>" . $recipe['preparation'] . "</span></li><br />";
            echo "<li><span style='font-size: 25px; color:blue;'>Ingrédients : </span><br /><br /><ol><br />";
            foreach ($recipe['index'] as $ind) {
                echo "<li>" . $ind . "</li>";
            }
            echo "</ol></li>";
            echo "</ul>";
            $i++;
        }
    }
?>