<?php
include "Donnees.inc.php";
$elem = $_REQUEST["elem"];
$elemDisplay = array();

echo "<h1 style='position:relative;text-align: center;'>Les recettes</h1>";


$GLOBALS['felem'] = false;
displayElementHierarchy($Recettes, $Hierarchie, $elem, $elemDisplay);
if (!$GLOBALS['felem']) {
    echo "<p><i>Pas de recettes trouvées.</i></i></p>";
}

function displayElementHierarchy($Recettes, $Hierarchie, $elemSearch, $elemDisplay) {
    if (array_key_exists('sous-categorie', $Hierarchie[$elemSearch])) {
        foreach ($Hierarchie[$elemSearch]['sous-categorie'] as $sub_element) {
            displayElementHierarchy($Recettes, $Hierarchie, $sub_element, $elemDisplay);
        }
    }
    else {
        if (!in_array($elemSearch, $elemDisplay)) {
            $i = 0;
            foreach ($Recettes as $recipe) {
                if (in_array($elemSearch, $recipe['index'])) {
                    if ($GLOBALS['felem'] == false) {
                        echo "<ul>";
                        $GLOBALS['felem'] = true;
                    } else {
                        echo "<ul id='recipe_separator'>";
                    }
<<<<<<< HEAD
                    echo "<p><span style='font-size: 25px; color:red;padding-left:2%;font-weight:bold'>" . $recipe['titre'] . "</span></p><br />";
                    echo "<li><span style='font-size: 18px; color:lightskyblue;;'>Ingrédients : </span><br /><br /><span style ='padding-left:2%;'>";
=======
                    echo "<p><span style='font-size: 25px; color:red;padding-left:2%;'>" . $recipe['titre'] . "</span></p><br />";
                    echo "<li><span style='font-size: 18px; color:blue;'>Ingrédients : </span><br /><br /><span style ='padding-left:2%;'>";
>>>>>>> 6525fe2dc8b2cd4c379f00bf138642483fd85556
                    $elements = explode('|', $recipe['ingredients']);
                    echo "<ul>";
                    foreach ($elements as $el) {
                        echo "<li>" . $el . "</li>";
                    }
                    echo "</ul></span></li><br />";
<<<<<<< HEAD
                    echo "<li><span style='font-size: 18px; color:lightskyblue;'>Préparation : </span><br /><br /><span style ='padding-left:2%;'>" . $recipe['preparation'] . "</span></li><br />";
                    echo "</ol></li>";
                    echo "</ul>";
                    echo "<a href='#' onClick='addRecipeToFavourites(\"".$recipe['titre']."\")'><p style ='padding-left:2%;color:#ffffaa;font-size:18px;'>Ajouter cette recette à ma liste des recettes favorites</p></a>";
=======
                    echo "<li><span style='font-size: 18px; color:blue;'>Préparation : </span><br /><br /><span style ='padding-left:2%;'>" . $recipe['preparation'] . "</span></li><br />";
                    echo "</ol></li>";
                    echo "</ul>";
                    echo "<a href='#' onClick='addRecipeToFavourites(\"".$recipe['titre']."\")'><p style ='padding-left:2%;'>Ajouter cette recette à ma liste des recettes favorites</p></a>";
>>>>>>> 6525fe2dc8b2cd4c379f00bf138642483fd85556
                    $i++;
                }
            }
        }
    }
}

?>