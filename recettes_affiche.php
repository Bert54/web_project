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
            echo "<li>" . $recipe['titre'] . "</li>";
            echo "<li>" . $recipe['ingredients'] . "</li>";
            echo "<li>" . $recipe['preparation'] . "</li>";
            echo "<li><ol>";
            foreach ($recipe['index'] as $ind) {
                echo "<li>" . $ind . "</li>";
            }
            echo "</ol></li>";
            echo "</ul>";
            $i++;
        }
    }
?>