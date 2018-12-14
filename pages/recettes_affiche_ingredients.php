<?php

/**
 * Cette page chargée par AJAX effectue une recherche par liste d'ingrédients ainsi que leur mode de recherche.
 * On affiche toute les recettes avec les ingrédients entrés que l'on veut et les ingrédients entrés que l'on
 * ne veut pas.
 * SI on ne trouve pas de recettes ou si on tente d'effectuer une recherche sans ingrédients, alors on en
 * informe l'utilisateur.
 */

include "../Donnees.inc.php";
session_start();
//$recipes_selected = json_decode($_COOKIE['recetteselection']);
$recipes_selected = json_decode($_SESSION['recetteselection']);
if (count($recipes_selected[0]) > 0) {
    $GLOBALS['recipes_to_display'] = array();
    $GLOBALS['felem'] = false;
    //$recipePictures = json_decode($_COOKIE['recipes_pictures']);
    //$recipePicturesFormat = json_decode($_COOKIE['recipes_pictures_format']);
	$recipePictures = json_decode($_SESSION['recipes_pictures']);
	$recipePicturesFormat =json_decode( $_SESSION['recipes_pictures_format']);
    foreach ($Recettes as $recipe) {
            addRecipeToDisplayList($Hierarchie, $recipes_selected[0][0], $recipes_selected[1][0], $recipe);
    }
    for ($i = 1 ; $i < count($recipes_selected[0]) ; $i++) {
        addRecipeToDisplayListFromExistingSource($Hierarchie, $recipes_selected[0][$i], $recipes_selected[1][$i]);
    }
    if (count($GLOBALS['recipes_to_display']) > 0) {
        echo "<h1 style='position:relative;text-align: center;'>Les recettes</h1>";
        foreach ($GLOBALS['recipes_to_display'] as $recipe) {
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
    else {
        echo "<p style='display:inline-block; padding-left:5px;'><i>Pas de recettes trouvées.</i></i></p>";
    }
}
else {
    echo "<p style='display:inline-block; padding-left:5px;'><i>Veuillez sélectionner des ingrédients avant de lancer la recherche.</i></i></p>";
}
?>

<?php

function addRecipeToDisplayList($Hierarchie, $ingredient, $ingredient_stat, $recipe) {
    if ($ingredient_stat === true && in_array($ingredient, $recipe['index']) && !in_array($recipe, $GLOBALS['recipes_to_display'])) {
        array_push($GLOBALS['recipes_to_display'], $recipe);
    }
    else if ($ingredient_stat === false && !in_array($ingredient, $recipe['index']) && !in_array($recipe, $GLOBALS['recipes_to_display'])) {
        array_push($GLOBALS['recipes_to_display'], $recipe);
    }
    if (array_key_exists('sous-categorie', $Hierarchie[$ingredient])) {
        foreach ($Hierarchie[$ingredient]['sous-categorie'] as $sub_element) {
            addRecipeToDisplayList($Hierarchie, $sub_element, $ingredient_stat, $recipe);
        }
    }

}

function addRecipeToDisplayListFromExistingSource($Hierarchie, $ingredient, $ingredient_stat) {
    $GLOBALS['ingredient_list'] = array();
    constructIngredientsList($Hierarchie, $ingredient);
    $i = 0;
    foreach ($GLOBALS['recipes_to_display'] as $recipe) {
        $found = false;
        if ($ingredient_stat) {
            foreach ($GLOBALS['ingredient_list'] as $ingredient_search) {
                if (in_array($ingredient_search, $recipe['index'])) {
                    $found = true;
                }
            }
            if (!$found) {
                unset($GLOBALS['recipes_to_display'][$i]);
                $reindex = array_values($GLOBALS['recipes_to_display']);
                $GLOBALS['recipes_to_display'] = $reindex;
            }
            else {
                $i++;
            }
        }
        else {
            foreach ($GLOBALS['ingredient_list'] as $ingredient_search) {
                if (in_array($ingredient_search, $recipe['index'])) {
                    $found = true;
                }
            }
            if ($found) {
                unset($GLOBALS['recipes_to_display'][$i]);
                $reindex = array_values($GLOBALS['recipes_to_display']);
                $GLOBALS['recipes_to_display'] = $reindex;
            }
            else {
                $i++;
            }
        }
    }
}

function constructIngredientsList($Hierarchie, $ingredient) {
    array_push($GLOBALS['ingredient_list'], $ingredient);
    if (array_key_exists('sous-categorie', $Hierarchie[$ingredient])) {
        foreach ($Hierarchie[$ingredient]['sous-categorie'] as $sub_element) {
            constructIngredientsList($Hierarchie, $sub_element);
        }
    }
}

?>
