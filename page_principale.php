<!DOCTYPE html>

<?php

    /**
     * Ici, on génère toute les variables de session utilisés par l'applications ainsi que leur initialisation
     */
	session_start();
	// variables de session liées à la connexion
	if(!isset($_SESSION['boissons_user_connected'])) {
		$_SESSION['boissons_user_connected'] = false;
		$_SESSION['boissons_user_nickname'] = "";
		$_SESSION['boissons_user_just_connected'] = false;
	}
	
	header('Content-type: text/html; charset=utf-8');
			include "Donnees.inc.php";
			
            $user_recipes = array();
            // Variable de session pour les recettes favorites
            if (!isset($_SESSION['user_recipes'])) {
                //setcookie('user_recipes', json_encode($user_recipes), time()+36000, '/');
				$_SESSION['user_recipes'] = json_encode($user_recipes);
            }
            else {
                $user_recipes = json_decode($_SESSION['user_recipes']);
            }
            // Variables de session pour les images
            $recipes_pictures = array();
            $recipes_pictures = scandir('./Photos');
            $recipes_pictures_format = array();
            $file_extensions = array(".png", ".jpg", ".jpeg", ".bmp", ".svg", ".gif");
            foreach ($recipes_pictures as $recipe_picture) {
                $recipe_picture = str_replace('_', ' ', $recipe_picture);
                $recipe_picture = str_replace('-', ' ', $recipe_picture);
                $recipe_picture = str_replace($file_extensions, "", $recipe_picture);
                array_push($recipes_pictures_format, strtolower($recipe_picture));
            }
            //setcookie('recipes_pictures', json_encode($recipes_pictures), time()+36000, '/');
			$_SESSION['recipes_pictures'] = json_encode($recipes_pictures);
            //setcookie('recipes_pictures_format', json_encode($recipes_pictures_format), time()+36000, '/');
			$_SESSION['recipes_pictures_format'] = json_encode($recipes_pictures_format);
			// Variable de session pour la recherche de recettes par recherche utilisateur
            $selection_array = array();
            $selection_array[0] = array();
            $selection_array[1] = array();
            //setcookie('recetteselection', json_encode($selection_array), time()+36000, '/');
			$_SESSION['recetteselection'] = json_encode($selection_array);
	
?>

<html>
	<head>
        <title>Projet Boissons</title>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <link rel="stylesheet" type="text/css" href="styles/page_principale.css">
        <script type="text/javascript" src="projet_boissons_scripts.js" ></script>
	</head>
        
	<body>
        <div>
            <!--Concerne toute la barre de recherche en haut à gauche-->
            <span id="research_bar">
            <!--Recherche la saisie de l'utilisateur dans les données-->
                <input id="search" type="search" name="liste_recherche" placeholder="Rechercher..."
                     list="hierarchies" />
                <!--Menu déroulant sous la barre de recherche-->
                    <datalist id="hierarchies">
                        <?php
                            $i = 0;
                            foreach($Hierarchie as $element){
                            // Affichage de chaque élément contenant la chaîne saisie
                                echo "<option>".array_keys($Hierarchie)[$i]."</option>";
                            $i++;
                        }
                        ?>
                    </datalist>
                <!--Bouton pour ajouter un élément à la recherche-->
                <input id="submit" type="submit" name="ajouter_ingredient" value="Ajouter"
                       onclick="ajouterIngredient(search.value)"/>

                <!--Bouton pour valider la recherche-->
                <input id="submit" type="submit" name="bouton_recherche" value="Rechercher"
                       onclick="displayRecipeFromIngredientsList()"/></p>
                <!--Ce div est le container de tous les elements que l'utilisateur veut rechercher (ou pas)-->
                <div id="selection">


                </div>
            </span>
            <!--Concerne toute la barre des recettes favorites ainsi que de session en haut à droite-->
            <span id="session_bar">
				<?php
                    /**
                     * Si on est connecté, alors on affiche la possibilité de pouvoir modifier ses informations ou
                     * de se déconnecter. Dans le cas contraire, on affiche lien de création de compte ou de connexion.
                     */
					if ($_SESSION['boissons_user_connected']) {
						echo '<span id="nickname_tab">
							Bienvenue&nbsp;&nbsp;&nbsp;<span id="nickname" onclick="showManagementTab()"><b>'.$_SESSION['boissons_user_nickname'].'</b></span>
						</span>
						<a href="#" onclick="showUserRecipes('.true.')" style="text-shadow: 1px 0 0 #fff, -1px 0 0 #fff, 0 1px 0 #fff, 0 -1px 0 #fff, 1px 1px #fff, -1px -1px 0 #fff, 1px -1px 0 #fff, -1px 1px 0 #fff;">Mes Recettes Favorites</a>
						<span style="display:none" id="user_recipes">
							
						</span>
						<span id="nickname_manage" style="display:none; text-align:center;">
							<span><a id="mod_inf_button" href="pages/modification_compte.php">Modifier mes informations</a></span>
							<span><a id="logout_button" href="pages/logout.php">Se déconnecter</a></span> 
						</span>';
					}
					else {
						echo '<span style="border-right: 1px solid white; position:relative; margin-right:40px; margin-left:20px; padding-right:35px;" >
							<a href="pages/creation_compte.php" style="color:white; text-decoration: underline;">Créer un compte</a>
						</span>
						<span style="border-right: 1px solid white; position:relative; margin-right:40px; padding-right:35px;" >
							<a href="#" onclick="showConnectionTab()" style="color:white; text-decoration: underline;">Se connecter</a>
						</span>
						<a href="#" onclick="showUserRecipes('.false.')" style="text-shadow: 1px 0 0 #fff, -1px 0 0 #fff, 0 1px 0 #fff, 0 -1px 0 #fff, 1px 1px #fff, -1px -1px 0 #fff, 1px -1px 0 #fff, -1px 1px 0 #fff;">Mes Recettes Favorites</a>
						<span style="display:none" id="user_recipes">
							
						</span>
						<span style="display:none; text-align:left;" id="connection">
							<div id="error_result"></div>
							<form type="post" id="login_form" style="border-top-style: solid;border-top-width: 2px;padding-top:15px;" action="javascript:checkConnectionFormValidity()">
								<fieldset>
									<p> Pseudonyme :  <br /><br /><input type="text" name="nickname" size="60" required /></p><br />
									<p> Mot de passe :  <br /><br /><input type="password" name="password" size="60" required /></p><br />
									<br />
									<input type="submit" id="connect_submit" name="submit_form" value="Se connecter" />
								</fieldset>
							</form>
						</span>';
					}
					?>
            </span>
        </div>

        <!--Le menu de recherche par hiérarche à gauche-->
        <dl id="menu">
            <p id='menu_pres'>Recherche par catégories</p>
            <?php

            /**
             * On génère la hiérarchie des éléments par récursivité.
             * Le(s) élément(s) racine sont généré ici
             */
                $i = 0;
                $GLOBALS['j'] = 0;
                foreach ($Hierarchie as $element) {
                   if (!array_key_exists('super-categorie', $element)) {
                       $firstelem = array_keys($element);
                       echo "<div class='elem_init'>";
                       echo "<dt onClick='showMenuItem(\"menu".$GLOBALS['j']."\");showRecipesMultiple(\"".array_keys($Hierarchie)[$i]."\")'> <a href='#'>".array_keys($Hierarchie)[$i]."</a></dt>";
                       echo "</div>";
                       echo "<dl id='menu".$GLOBALS['j']."'>";
                       echo "<script type='text/JavaScript'> hideMenuInit(\"menu".$GLOBALS['j']."\"); </script>";
                       $GLOBALS['j']++;
                       displayElementHierarchy($Recettes, $Hierarchie, $element, 1);
                       echo "</dl>";
                   }
                   $i++;

                }

            /**
             * La fonction récursive. Elle est appelé à chaque fois qu'on a une sous-catégorie dans un élément.
             * Tous les éléments autre que la/les racine(s) sont générés ici
             */
                function displayElementHierarchy($Recettes, $Hierarchie, $elemSearch, $level) {
                    foreach ($elemSearch['sous-categorie'] as $sub_element) {
                        if (array_key_exists('sous-categorie', $Hierarchie[$sub_element])) {
                            echo "<div class='elem".$level % 3 ."'>";
                            echo "<dt onClick='showMenuItem(\"menu".$GLOBALS['j']."\");showRecipesMultiple(\"".$sub_element."\")'>";
                            for ($k = 0 ; $k < $level ; $k++) {
                                echo "&nbsp;&nbsp;&nbsp;";
                            }
                            echo "<a href='#'>".$sub_element."</a></dt>";
                            echo "</div>";
                            echo "<dl id='menu".$GLOBALS['j']."'>";
                            echo "<script type='text/JavaScript'> hideMenuInit(\"menu".$GLOBALS['j']."\"); </script>";
                            $GLOBALS['j']++;
                            $level_temp = $level + 1;
                            displayElementHierarchy($Recettes, $Hierarchie, $Hierarchie[$sub_element], $level_temp);
                            echo "</dl>";
                        }
                        else {
                            echo "<div class='elem".$level % 3 ."'>";
                            echo "<dt onClick='showRecipes(\"".$sub_element."\")'>";
                            for ($k = 0 ; $k < $level ; $k++) {
                                echo "&nbsp;&nbsp;&nbsp;";
                            }
                            echo "<a href='#'>".$sub_element."</a></dt>";
                            echo "</div>";
                            echo "<dl id='menu".$GLOBALS['j']."'>";
                            echo "<script type='text/JavaScript'> hideMenuInit(\"menu".$GLOBALS['j']."\"); </script>";
                            $GLOBALS['j']++;
                            echo "</dl>";
                        }
                    }
                }

            ?>
        </dl>

        <!--Le container qui va servir à afficher les recettes-->
        <div id='recipes'>
            <p style='display:inline-block; padding-left:5px;'><i>Les recettes seront affichées ici.</i></p>
        </div>
		<?php
        /**
         * Bloc PHP permettant, lors de la connexion, de demander à l'utilisateur s'il souhaite mettre à jour sa liste
         * des recettes favorites ou non, si il y a sélectionné quand il n'était pas connecté.
         */
			if ($_SESSION['boissons_user_just_connected']) {
				if (count(json_decode($_SESSION['user_recipes'], true)) > 0) {
					echo "<script type='text/javascript'>updateUserRecipesFromLogin(".true.");</script>";
					$_SESSION['boissons_user_just_connected'] = false;
				}
				else {
					echo "<script type='text/javascript'>updateUserRecipesFromLogin(".false.");</script>";
				}
			}
		?>
	</body>
</html>