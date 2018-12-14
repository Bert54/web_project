<?php
/**
 * Cette page chargée par AJAX affiche tous les noms des recettes favorites de l'utilisateur si il y a.
 * Si il n'y en a pas, alors on affiche un message décrivant qu'il n'y en a pas.
 */
	include("../bdd_connexion.php");
	session_start();
    //$user_recipes = json_decode($_COOKIE['user_recipes'], true);
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
		$user_recipes =json_decode($_SESSION['user_recipes']);
	}
    $GLOBALS['felemu'] = false;
    echo "<p style='border-top-style: solid;border-top-width: 2px'></p>";
    foreach ($user_recipes as $recipe) {
        echo "<p><span id='user_recipe_single' onClick='displayRecipeFromUserList(\"" . $recipe . "\")'>" . $recipe . "</span><img src='Images_Perso/DeleteRed.png' onClick='deleteRecipeFromFavourites(\"" . $recipe . "\")' style='width:20px;height:20px;padding-left:10px;cursor: pointer;'/></p>";
        $GLOBALS['felemu'] = true;
    }

    if ($GLOBALS['felemu'] == false) {
       echo "<p id='user_recipes_list'><i>Vous n'avez actuellement pas de recettes favorites.</i></p>";
    }
    else {
        echo "<p onclick='displayAllRecipeFromUserList()' style='border-top-style: solid;border-top-width: 2px;padding-top:15px;'><i id='allUsrRecipes'>Afficher toutes mes recettes</i></p>";
    }
	mysqli_close($db_connection);
?>

