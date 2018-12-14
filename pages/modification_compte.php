<!--
    Cette page PHP correspong au formulaire de modification des informations relatives au compte de l'utilisateur.
    Elle ne peut être appellée que si l'utilisateur est déjà connecté.
-->

<!DOCTYPE html>
<html>

	<header>
		<?php
			session_start();
			header('Content-type: text/html; charset=utf-8');
			/*
			 * Ici, on récupère les informations de l'utilisateur afin de les afficher dans le formuaire
			 */
			$db_connection = new mysqli("localhost", "root", "", "projet_boisson_db");
			if ($db_connection->connect_error) {
				die("Connection failed: " . $db_connection->connect_error);
			}
			$stmt = $db_connection->prepare("SELECT first_name, last_name, gender, mail_address, birth_date, address_street, address_number, address_town, phone_number FROM users WHERE LOWER(nickname) = LOWER(?);");
			$stmt->bind_param("s", $_SESSION['boissons_user_nickname']);
			$stmt->execute();
			$stmt->store_result();
			$stmt->bind_result($first_name, $last_name, $gender, $mail_address, $birth_date, $address_street, $address_number, $address_town, $phone_number);
			$stmt->fetch();
			$_SESSION['first_name'] = $first_name;
			$_SESSION['last_name'] = $last_name;
			$_SESSION['gender'] = $gender;
			$_SESSION['mail_address'] = $mail_address;
			$_SESSION['birth_date'] = $birth_date;
			$_SESSION['address_street'] = $address_street;
			$_SESSION['address_number'] = $address_number;
			$_SESSION['address_town'] = $address_town;
			$_SESSION['phone_number'] = $phone_number;
			$stmt->close();
			mysqli_close($db_connection);
			
			
		?>
		<title>Projet Boissons - Modification compte</title>
		<link rel="stylesheet" type="text/css" href="../styles/creation_compte.css">
		<script language='Javascript'>

            /**
             * Cette fonction javascript effectue la vérification du formulaire de modification.
             * Si une seule des vérifications effectuées affiche une erreur, alors on empêche la modification,
             * sinon on l'effectue.
             */
            function checkFormValidity() {
				pass = document.getElementById('create_account_form').elements["password"].value;
				pass_confirm = document.getElementById('create_account_form').elements["password_confirm"].value;
				var append = "";
				var error_found = false;
				// Quelque chose a été saisit dans le champ de modification de mote de passe : on souhaite donc le modifier
				if (pass.length != 0){
				    // mot de passe trop long
					if (pass.length > 40) {
						append += "<p style='color:red;'> - Le mot de passe saisie est trop long.</p>";
						error_found = true
					}
					// mot de passe trop court
					if (pass.length < 6) {
						append += "<p style='color:red;'> - Le mot de passe saisie est trop court.</p>";
						error_found = true
					}
					// Le mot de passe de confirmation n'est pas égale au mot de passe que l'on a saisit
					if (pass.localeCompare(pass_confirm) != 0) {
						append += "<p style='color:red;'> - Les deux mots de passe saisies ne correspondent pas.</p>";
						error_found = true;
					}
				}
				var mail = document.getElementById('create_account_form').elements["mail_address"].value;
				// Si mail n'est pas vide, alors l'utilisateur souhaite enregistrer son addresse email
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
				// On affiche toutes les erreurs générées si il y a, sinon on effectue la modification
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
					var parameters = "?password=" + encodeURIComponent(pass) + "&firstname=" +
									encodeURIComponent(first_name) + "&lastname=" + encodeURIComponent(last_name) + "&gender=" + 
									encodeURIComponent(gender) + "&mail=" + encodeURIComponent(mail) + "&date=" + date_str + "&addrnumber=" +
									encodeURIComponent(address_number) + "&addrstreet=" + encodeURIComponent(address_street) + "&city=" +
									encodeURIComponent(city) + "&phone= " + encodeURIComponent(phone_number);
					var xhttp2 = new XMLHttpRequest();
					xhttp2.open("GET", "modifier_compte.php" + parameters, false);
					xhttp2.send();
					document.location.href="../page_principale.php";
				}
			}
			
		</script>
	</header>

	<body>
		<h1 style="text-align: center; border: 2px solid white; border-radius:10px; background-color: #353535; padding:1%;" >Modifier votre compte</h1>
		<div id="form_body">
			<p><a href='../page_principale.php' style='font-size:22px;'><< Revenir à la page précédente</a></p>
			<div id='error_result'></div>
            <!--Le formulaire de modification. On remplit les champs avec les informations déjà existant-->
			<form type='post' id='create_account_form' action='javascript:checkFormValidity()'>
				<fieldset>
				<p> Nouveau mot de passe :  <br /><br /><input type='password' name='password' size='80' /></p><br />
				<p> Confirmer nouveau mot de passe :  <br /><br /><input type='password' name='password_confirm' size='80' /></p><br />
				<p> Nom :  <br /><br /><input type='text' name='first_name' size='80' value="<?php echo $_SESSION['first_name']; ?>" /></p><br />
				<p> Prénom :  <br /><br /><input type='text' name='last_name' size='80' value="<?php echo $_SESSION['last_name']; ?>" /></p><br />
				<p> Genre : <br /><br /><select name="gender" >
					<option value="Non précisé" <?php if ($_SESSION['gender'] == "Non précisé") { echo ' selected="selected" '; } ?> >Non précisé</option>
					<option value="Homme" <?php if ($_SESSION['gender'] == "Homme") { echo ' selected="selected" '; } ?> >Homme</option>
					<option value="Femme" <?php if ($_SESSION['gender'] == "Femme") { echo ' selected="selected" '; } ?> >Femme</option>
				</select></p><br />
				<p> Adresse mail :  <br /><br /><input type='text' name='mail_address' size='80' value="<?php echo $_SESSION['mail_address']; ?>" /></p><br />
				<p> Date de naissance :  <br /><br /><input type='date' name='birth_date' value="<?php echo $_SESSION['birth_date']; ?>" /></p><br />
				<p> Numéro de résidence :  <br /><br /><input type='number' name='address_number' value="<?php echo $_SESSION['address_number']; ?>"  /></p><br />
				<p> Adresse de résidence :  <br /><br /><input type='text' name='address_street' size='80' value="<?php echo $_SESSION['address_street']; ?>" /></p><br />
				<p> Ville :  <br /><br /><input type='text' name='address_town' size='80' value="<?php echo $_SESSION['address_town']; ?>" /></p><br />
				<p> Numéro de téléphone (format: 00.00.00.00.00) :  <br /><br /><input type='tel' name='phone_number' value="<?php echo $_SESSION['phone_number']; ?>" pattern='^[0-9]{2}[ _.-]?[0-9]{2}[ _.-]?[0-9]{2}[ _.-]?[0-9]{2}[ _.-]?[0-9]{2}$'/></p><br />
				</fieldset>
				<br />
				<input  type='submit' id='submit_form' name='submit_form' value='Envoyer' />
			</form>
		</div>
	</body>
	<?php
        /* Puisqu'on a finit de générer le forumaire avec les informations de l'utilisateur déjà présentes, on a donc
           plus besoin des variables de session qui les contient. On les supprime en conséquence.
        */
		unset($_SESSION['first_name']);
		unset($_SESSION['last_name']);
		unset($_SESSION['gender']);
		unset($_SESSION['mail_address']);
		unset($_SESSION['birth_date']);
		unset($_SESSION['address_street']);
		unset($_SESSION['address_number']);
		unset($_SESSION['address_town']);
		unset($_SESSION['phone_number']);
	?>
</html>