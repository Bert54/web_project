<!DOCTYPE html>
<html>
	<head>
		<?php
			header('Content-type: text/html; charset=utf-8');
			include "Donnees.inc.php";
		?>
        <title>Projet Boissons</title>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <link rel="stylesheet" type="text/css" href="page_principale.css">
		<script language="JavaScript">

            function hideMenuInit(str) {
                document.getElementById(str).style.display='none';
            }

			function showMenuItem(str) {

			    var doc = document.getElementById(str);
                if ($(doc).is (':visible')) {
                    doc.style.display='none';
                }
                else {
                    doc.style.display='block';
                }
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
			
		</script>
	</head>
	<body >
        <dl id="menu">
            <p id='menu_pres'>Recherche par catégories</p>
        <?php
            $i = 0;
            $GLOBALS['j'] = 0;
            foreach ($Hierarchie as $element) {
               if (!array_key_exists('super-categorie', $element)) {
                   echo "<div class='elem_init'>";
                   echo "<dt onClick='showMenuItem(\"menu".$GLOBALS['j']."\")'> <a href='#'>".array_keys($Hierarchie)[$i]."</a></dt>";
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
                        echo "<dt onClick='showMenuItem(\"menu".$GLOBALS['j']."\")'>";
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