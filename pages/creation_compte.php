<!DOCTYPE html>
<html>
    <!--
        Cette page PHP correspond au formulaire d'inscription d'un nouvel utilisateur.
        Seuls le pseudonyme et le mot de passe (ainsi que la confirmation de mot de passe) sont obligatoires.
    -->
	<header>
		<?php
			header('Content-type: text/html; charset=utf-8');
		?>
		<title>Projet Boissons - Inscription</title>
		<link rel="stylesheet" type="text/css" href="../styles/creation_compte.css">
		<script language='Javascript'>

            /**
             * Cette fonction javascript effectue la vérification du formulaire de création.
             * Si une seule des vérifications effectuées affiche une erreur, alors on empêche la création,
             * sinon on l'effectue.
             */
			function checkFormValidity() {
				pass = document.getElementById('create_account_form').elements["password"].value;
				pass_confirm = document.getElementById('create_account_form').elements["password_confirm"].value;
				var append = "";
				var error_found = false;
				// On vérifie que le pseudonyme entré n'existe pas déjà
				var nickname = document.getElementById('create_account_form').elements["nickname"].value;
				var xhttp = new XMLHttpRequest();
				xhttp.onreadystatechange = function () {
					if (this.readyState === 4 && this.status === 200) {
						append += this.responseText;
					}
				};
				xhttp.open("GET", "verif_pseudonyme.php?nickname=" + nickname, false);
				xhttp.send();
				// Mot de passe trop grand
				if (pass.length > 40) {
					append += "<p style='color:red;'> - Le mot de passe saisie est trop long.</p>";
					error_found = true
				}
				// Mot de passe trop petit
				if (pass.length < 6) {
						append += "<p style='color:red;'> - Le mot de passe saisie est trop court.</p>";
						error_found = true
                }
                // Le mot de passe de confirmation n'est pas égale au mot de passe que l'on a saisit
				if (pass.localeCompare(pass_confirm) != 0) {
					append += "<p style='color:red;'> - Les deux mots de passe saisies ne correspondent pas.</p>";
					error_found = true;
				}
                // Si mail n'est pas vide, alors l'utilisateur souhaite enregistrer son addresse email
				var mail = document.getElementById('create_account_form').elements["mail_address"].value;
				if (mail != "") {
                    // On test sur le format du mail donné est valide
					var mail_regex = new RegExp("^[a-zA-Z0-9\.]+@[a-zA-Z0-9]+\.[a-zA-Z]+$");
					if (!mail_regex.test(mail)) {
						append += "<p style='color:red;'> - L'adresse mail entrée est invalide.</p>";
						error_found = true;
					}
				}
				
				var date_str = document.getElementById('create_account_form').elements["birth_date"].value;
                // Si date n'est pas vide, alors l'utilisateur souhaite enregistrer sa date de naissance
                if (date_str != "") {
                    // On vérifie que l'année de naissance donné par l'utilisateur ne soit pas farfelue
					var date = new Date(date_str);
					var today_date = new Date();
					if (today_date.getFullYear() <= date.getFullYear() || date.getFullYear() <= 1850) {
						append += "<p style='color:red;'> - La date de naissance saisie n'est pas possible.</p>";
						error_found = true;
					}
				}
                // On affiche toutes les erreurs générées si il y a, sinon on effectue la création
				if (append != "" || error_found == true) {
					scroll(0,0);
					doc = document.getElementById("error_result");
					doc.innerHTML = append;
					doc.style.display = 'block';
				}
				else {
					var first_name = document.getElementById('create_account_form').elements["first_name"].value;
					var last_name = document.getElementById('create_account_form').elements["last_name"].value;
					var gender = document.getElementById('create_account_form').elements["gender"].value;
					var address_number = document.getElementById('create_account_form').elements["address_number"].value;
					var address_street = document.getElementById('create_account_form').elements["address_street"].value;
					var city = document.getElementById('create_account_form').elements["address_town"].value;
					var phone_number = document.getElementById('create_account_form').elements["phone_number"].value;
					var parameters = "?nickname=" + encodeURIComponent(nickname) + "&password=" + encodeURIComponent(pass) + "&firstname=" +
									encodeURIComponent(first_name) + "&lastname=" + encodeURIComponent(last_name) + "&gender=" + 
									encodeURIComponent(gender) + "&mail=" + encodeURIComponent(mail) + "&date=" + date_str + "&addrnumber=" +
									encodeURIComponent(address_number) + "&addrstreet=" + encodeURIComponent(address_street) + "&city=" +
									encodeURIComponent(city) + "&phone= " + encodeURIComponent(phone_number);
					var xhttp2 = new XMLHttpRequest();
					xhttp2.open("GET", "creer_compte.php" + parameters, false);
					xhttp2.send();
					document.location.href="../page_principale.php";
				}
			}
			
		</script>
	</header>

	<body>
		<h1 style="text-align: center; border: 2px solid white; border-radius:10px; background-color: #353535; padding:1%;" >Créer un compte</h1>
		<div id="form_body">
			<p><a href='../page_principale.php' style='font-size:22px;'><< Revenir à la page précédente</a></p>
			<div id='error_result'></div>
            <!--Le formulaire de création de compte-->
			<form type='post' id='create_account_form' action='javascript:checkFormValidity()'>
				<fieldset>
				<p> Pseudonyme :  <br /><br /><input type='text' name='nickname' size='80' required /></p><br />
				<p> Mot de passe :  <br /><br /><input type='password' name='password' size='80' required /></p><br />
				<p> Confirmer mot de passe :  <br /><br /><input type='password' name='password_confirm' size='80' required /></p><br />
				<p> Nom :  <br /><br /><input type='text' name='first_name' size='80' /></p><br />
				<p> Prénom :  <br /><br /><input type='text' name='last_name' size='80' /></p><br />
				<p> Genre : <br /><br /><select name="gender">
					<option value="Non précisé">Non précisé</option>
					<option value="Homme">Homme</option>
					<option value="Femme">Femme</option>
				</select></p><br />
				<p> Adresse mail :  <br /><br /><input type='text' name='mail_address' size='80'/></p><br />
				<p> Date de naissance :  <br /><br /><input type='date' name='birth_date' /></p><br />
				<p> Numéro de résidence :  <br /><br /><input type='number' name='address_number' /></p><br />
				<p> Adresse de résidence :  <br /><br /><input type='text' name='address_street' size='80'/></p><br />
				<p> Ville :  <br /><br /><input type='text' name='address_town' size='80'/></p><br />
				<p> Numéro de téléphone (format: 00.00.00.00.00) :  <br /><br /><input type='tel' name='phone_number' pattern='^[0-9]{2}[ _.-]?[0-9]{2}[ _.-]?[0-9]{2}[ _.-]?[0-9]{2}[ _.-]?[0-9]{2}$'/></p><br />
				</fieldset>
				<br />
				<input  type='submit' id='submit_form' name='submit_form' value='Envoyer' />
			</form>
		</div>
	</body>
	
</html>