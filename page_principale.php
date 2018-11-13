<!DOCTYPE html>
<html>
	<head>
		<?php
			header('Content-type: text/html; charset=utf-8');
			include "Donnees.inc.php";
		?>
        <title>Projet Boissons</title>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
		<script language="JavaScript">

			function showMenuItem(str) {

			    document.getElementById('menu2').

			    var doc = document.getElementById(str);
                if ($(doc).is (':visible')) {
                    doc.style.display='none';
                }
                else {
                    doc.style.display='block';
                }
			}
			
		</script>
	</head>
	<body>
		<dl id="menu">
			<dt onClick="showMenuItem('menu2')"> <a href="#">menu1</a></dt>
			<dd id="menu2">
				<ul>
					<?php
						$i = 0;
						foreach ($Hierarchie as $element) {
							if (!array_key_exists('super-categorie', $element)) {
							    echo "<li>".array_keys($Hierarchie)[$i]."</li>";
                            }
                            $i++;
						}
					?>
				</ul>
			</dd>
		</dl>
	</body>
</html>

<?php
			
			/**echo "<dl>";
			foreach ($Recettes as $recette) {
				echo "<li><ul>";
				echo "<li>".$recette['titre']."</li>";
				echo "<li>".$recette['ingredients']."</li>";
				echo "<li>".$recette['preparation']."</li>";
				echo "<li><ol>";
				foreach ($recette['index'] as $ind) {
					echo "<li>".$ind."</li>";
				}
				echo "</ol></li>";
				echo "</ul></li>";
			}
			echo "</dl>"*/
		?>