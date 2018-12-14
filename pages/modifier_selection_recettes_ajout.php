<?php
/**
 * Cette page chargée par AJAX effectue l'ajout d'un élément de la barre de recherche. SI il est déjà présent, alors
 * on ne fait rien.
 */
    include "../Donnees.inc.php";
	session_start();
    $elem = $_REQUEST["elem"];
    //$recipes_selected = json_decode($_COOKIE['recetteselection']);
	$recipes_selected = json_decode($_SESSION['recetteselection']);
    $elem_exist = false;
    foreach (array_keys($Hierarchie) as $element) {
        if (strcmp($element, $elem) === 0) {
            $elem_exist = true;
        }
    }
    if ($elem_exist && !in_array($elem, $recipes_selected[0])) {
        array_push($recipes_selected[0], $elem);
        array_push($recipes_selected[1], true);
        //setcookie('recetteselection', json_encode($recipes_selected), time() + 36000, '/');
		$_SESSION['recetteselection'] = json_encode($recipes_selected);
    }
    for ($i = 0; $i < count($recipes_selected[0]); $i++) {
        echo "<span>";
        if ($recipes_selected[1][$i] === true) {
            echo "<span onclick='switchElemSearchMode(\"" . $recipes_selected[0][$i] . "\")' id='selection_elements_wanted'>" . $recipes_selected[0][$i] . "</span>";
        } else {
            echo "<span onclick='switchElemSearchMode(\"" . $recipes_selected[0][$i] . "\")' id='selection_elements_unwanted'>" . $recipes_selected[0][$i] . "</span>";
        }
        echo "<img src='Images_Perso/DeleteRed.png' onClick='deleteIngredientFromSearch(\"" . $recipes_selected[0][$i] . "\")' style='width:20px;height:20px;padding-left:3px; margin-right:8px; cursor: pointer;'/>";
        echo "</span>";
    }
?>