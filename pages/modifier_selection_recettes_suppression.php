<?php
/**
 * Cette page chargée par AJAX effectue la suppression d'un élément de la barre de recherche, c'est-à-dire quand on ne*
 * veut plus faire une recherche avec cet élément quand l'utilisateur cloque sur la croix rouge.
 */
include "../Donnees.inc.php";
session_start();
$elem = $_REQUEST["elem"];
//$recipes_selected = json_decode($_COOKIE['recetteselection']);
$recipes_selected = json_decode($_SESSION['recetteselection']);
for ($i = 0 ; $i < count($recipes_selected[0]) ; $i++) {
    if (strcmp($recipes_selected[0][$i], $elem) === 0) {
        unset($recipes_selected[0][$i]);
        unset($recipes_selected[1][$i]);
        $reindex = array_values($recipes_selected[0]);
        $recipes_selected[0] = $reindex;
        $reindex = array_values($recipes_selected[1]);
        $recipes_selected[1] = $reindex;
    }
}
//setcookie('recetteselection', json_encode($recipes_selected), time() + 36000, '/');
$_SESSION['recetteselection'] = json_encode($recipes_selected);
for ($i = 0; $i < count($recipes_selected[0]); $i++) {
    echo "<span>";
    if ($recipes_selected[1][$i] === true) {
        echo "<span onclick='switchElemSearchMode(\"" . $recipes_selected[0][$i] . "\")' id='selection_elements_wanted'>" . $recipes_selected[0][$i] . "</span>";
    } else {
        echo "<span onclick='switchElemSearchMode(\"" . $recipes_selected[0][$i] . "\")' id='selection_elements_unwanted'>" . $recipes_selected[0][$i] . "</span>";
    }
    echo "<img src='Images_Perso/DeleteRed.png' onClick='deleteIngredientFromSearch(\"" . $recipes_selected[0][$i] . "\")' style='position: inline-block; width:20px;height:20px;padding-left:3px; margin-right:8px; cursor: pointer;'/>";
    echo "</span>";
}
?>