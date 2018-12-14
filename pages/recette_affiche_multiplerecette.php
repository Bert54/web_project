<?php

/**
 * Cette page chargée par AJAX permet d'afficher plusieurs recettes à partir de leur nom.
 */

	include "../Donnees.inc.php";
	include("../bdd_connexion.php");
	session_start();
	//$recipePictures = json_decode($_COOKIE['recipes_pictures']);
	$recipePictures = json_decode($_SESSION['recipes_pictures']);
	//$recipePicturesFormat = json_decode($_COOKIE['recipes_pictures_format']);
	$recipePicturesFormat =json_decode( $_SESSION['recipes_pictures_format']);

	$GLOBALS['felem'] = false;
	if ($_SESSION['boissons_user_connected']) {
		$stmt = $db_connection->prepare("SELECT fav_recipes FROM user_recipes WHERE LOWER(nickname)=LOWER(?);");
		$stmt->bind_param("s", $_SESSION['boissons_user_nickname']);
		$stmt->execute();
		$stmt->store_result();
		$stmt->bind_result($db_user_recipes);
		$stmt->fetch();
		if (strcmp($db_user_recipes, "") == 0) {
			$user_recipes = array();
		}
		else {
			$user_recipes = explode("|", $db_user_recipes);
		}
		$stmt->close();
	}
	else {
		//$user_recipes = json_decode($_COOKIE['user_recipes'], true);
		$user_recipes = json_decode($_SESSION['user_recipes']);
	}
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
				if (in_array(strtolower($recipe['titre']), $recipePicturesFormat)) {
					$key = array_search(strtolower($recipe['titre']), $recipePicturesFormat);
					echo "<img id='recipe_picture' src='./Photos/".$recipePictures[$key]."' />";
				}
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

	mysqli_close($db_connection);
	
?>