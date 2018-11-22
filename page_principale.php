<!DOCTYPE html>
<html>
	<head>
		<?php
			header('Content-type: text/html; charset=utf-8');
			include "Donnees.inc.php";
            $user_recipes = array();
            if (!isset($_COOKIE['user_recipes'])) {
                setcookie('user_recipes', json_encode($user_recipes), time()+36000);
            }
            else {
                $user_recipes = json_decode($_COOKIE['user_recipes'], true);
            }
            //$user_recipes = array("aaa", "bbb");
            //setcookie('user_recipes', json_encode($user_recipes), time()+36000);

		?>
        <title>Projet Boissons</title>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <link rel="stylesheet" type="text/css" href="page_principale.css">
	
        <script language="JavaScript">

            function addRecipeToFavourites(elem) {
                var xhttp = new XMLHttpRequest();
                xhttp.onreadystatechange = function (elem) {
                    if (this.readyState === 4 && this.status === 200) {
                        document.getElementById("recipes").innerHTML = this.responseText;
                    }
                };
                xhttp.open("GET", "ajoute_recette_fav.php?elem=" + elem, true);
                xhttp.send();
            }

            function hideMenuInit(str) {
                document.getElementById(str).style.display='none';
            }

            function showMenuItem(str) {
                var doc = document.getElementById(str);
                if ($(doc).is(':visible')) {
                    doc.style.display = 'none';
                }
                else {
                    doc.style.display = 'block';
                }
            }

            function showRecipesMultiple(elem) {
                var xhttp = new XMLHttpRequest();
                xhttp.onreadystatechange = function (elem) {
                    if (this.readyState === 4 && this.status === 200) {
                        document.getElementById("recipes").innerHTML = this.responseText;
                    }
                };
                xhttp.open("GET", "recettes_affiche_multiple.php?elem=" + elem, true);
                xhttp.send();
            }

            function showRecipes(elem) {
                if (elem.length === 0) {
                    document.getElementById("recipes").innerHTML = "";
                }
                else {
                    var xhttp = new XMLHttpRequest();
                    xhttp.onreadystatechange = function (elem) {
                        if (this.readyState === 4 && this.status === 200) {
                            document.getElementById("recipes").innerHTML = this.responseText;
                        }
                    };
                }
                xhttp.open("GET", "recettes_affiche.php?elem=" + elem, true);
                xhttp.send();
            }

            function showUserRecipes() {
                var doc = document.getElementById('user_recipes');
                if ($(doc).is(':visible')) {
                    doc.style.display = 'none';
                }
                else {
                    doc.style.display = 'block';
                }
                var xhttp = new XMLHttpRequest();
                xhttp.onreadystatechange = function (elem) {
                    if (this.readyState === 4 && this.status === 200) {
                        document.getElementById('user_recipes').innerHTML = this.responseText;
                    }
                };
                xhttp.open("GET", "user_recipes.php", true);
                xhttp.send();
            }

	    </script>

	</head>
        
	<body>
        <div>
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
                <!--Bouton pour valider la recherche-->
                <input id="submit" type="submit" name="bouton_recherche" value="Rechercher"
                onclick="showRecipesMultiple(search.value)"/></p>
            </span>
            <span id="session_bar">
                <p><a href="#" onclick="showUserRecipes()" >Mes Recettes</a></p>
                <span id="user_recipes">

                </span>
            </span>
        </div>
         
        <dl id="menu">
            <p id='menu_pres'>Recherche par catégories</p>
            <?php
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
         
        <div id='recipes'>
            <p> Les recettes seront affichées ici.</p>
        </div>
	</body>
</html>