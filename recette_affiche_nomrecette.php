<?php
include "Donnees.inc.php";
$elem = $_REQUEST["elem"];
foreach($Recettes as $recipe) {
    if (strcmp($elem, $recipe['titre']) == 0) {
        echo "<ul>";
        echo "<p><span style='font-size: 25px; color:red;padding-left:2%;font-weight:bold'>" . $recipe['titre'] . "</span></p><br />";
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