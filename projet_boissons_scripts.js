// Permet d'ajouter une recette à la liste des recettes favorites
function addRecipeToFavourites(elem) {
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function (elem) {
        if (this.readyState === 4 && this.status === 200) {
            document.getElementById('user_recipes').innerHTML = this.responseText;
        }
    };
    xhttp.open("GET", "pages/ajoute_recette_fav.php?elem=" + elem, false);
    xhttp.send();
    generateUserRecipe();
}

// Permet de supprimer une recette de liste des recettes favorites
function deleteRecipeFromFavourites(elem) {
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function (elem) {
        if (this.readyState === 4 && this.status === 200) {
            document.getElementById('user_recipes').innerHTML = this.responseText;
        }
    };
    xhttp.open("GET", "pages/enleve_recette_fav.php?elem=" + elem, false);
    xhttp.send();
    generateUserRecipe();
    document.getElementById('user_recipes').style.display = 'block';
}

// FOnction automatiquement appélée lors du chargement qui cache l'élément de la hiérachié donné en paramètre
function hideMenuInit(str) {
    document.getElementById(str).style.display='none';
}

// Cache ou montre l'élément de la hiérarchie donné en paramètre
function showMenuItem(str) {
    var doc = document.getElementById(str);
    if ($(doc).is(':visible')) {
        doc.style.display = 'none';
    }
    else {
        doc.style.display = 'block';
    }
}

// Permet l'affichage de multiple recettes à partir de l'élément ainsi que de ses sous-éléments donné en paramètre
function showRecipesMultiple(elem) {
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function (elem) {
        if (this.readyState === 4 && this.status === 200) {
            document.getElementById("recipes").innerHTML = this.responseText;
        }
    };
    xhttp.open("GET", "pages/recettes_affiche_multiple.php?elem=" + elem, true);
    xhttp.send();
}

// Affiche plusieurs recettes depuis un élément qui est une feuille de la hiérarchie
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
    xhttp.open("GET", "pages/recettes_affiche.php?elem=" + elem, true);
    xhttp.send();
}

// Affiche l'onglet des recettes favorite de l'utilisateur
function showUserRecipes(connected) {
    generateUserRecipe();
    var doc = document.getElementById('user_recipes');
	var doc2;
	if (!connected) {
		doc2 = document.getElementById('connection');
	}
	else {
		doc2 = document.getElementById('nickname_manage');
	}
	if ($(doc2).is(':visible')) {
        doc2.style.display = 'none';
    }
    if ($(doc).is(':visible')) {
        doc.style.display = 'none';
    }
    else {
        doc.style.display = 'block';
    }
}

// Affiche l'onglet de connexion
function showConnectionTab() {
    var doc = document.getElementById('connection');
	var doc2 = document.getElementById('user_recipes');
	if ($(doc2).is(':visible')) {
        doc2.style.display = 'none';
    }
    if ($(doc).is(':visible')) {
        doc.style.display = 'none';
    }
    else {
        doc.style.display = 'block';
    }
}

// Affiche l'onglet de gestion de compte
function showManagementTab() {
	var doc = document.getElementById('nickname_manage');
	var doc2 = document.getElementById('user_recipes');
	if ($(doc2).is(':visible')) {
        doc2.style.display = 'none';
    }
    if ($(doc).is(':visible')) {
        doc.style.display = 'none';
    }
    else {
        doc.style.display = 'block';
    }
}


// Affiche une seule recette depuis la liste des recettes favorites (recette donnée en paramètre)
function displayRecipeFromUserList(elem) {
    var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function (elem) {
            if (this.readyState === 4 && this.status === 200) {
                document.getElementById("recipes").innerHTML = this.responseText;
            }
        };
    xhttp.open("GET", "pages/recette_affiche_nomrecette.php?elem=" + elem, true);
    xhttp.send();
}

// Affiche les recettes à partir d'un ingrédient et de ses sous-ingrédients
function displayRecipeFromIngredientsList() {
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function (elem) {
        if (this.readyState === 4 && this.status === 200) {
            document.getElementById("recipes").innerHTML = this.responseText;
        }
    };
    xhttp.open("GET", "pages/recettes_affiche_ingredients.php", true);
    xhttp.send();
}

// Affiche toute les recettes favorites de l'utilisateur
function displayAllRecipeFromUserList() {
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function () {
        if (this.readyState === 4 && this.status === 200) {
            document.getElementById("recipes").innerHTML = this.responseText;
        }
    };
    xhttp.open("GET", "pages/recette_affiche_multiplerecette.php", true);
    xhttp.send();
}

// Génère la liste des recettes favorites de l'utilisateur
function generateUserRecipe() {
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function () {
        if (this.readyState === 4 && this.status === 200) {
            document.getElementById('user_recipes').innerHTML = this.responseText;
        }
    };
    xhttp.open("GET", "pages/user_recipes.php", false);
    xhttp.send();
}

// Ajoute un ingrédient à la liste des ingrédients à rechercher dans la barre de recherche par ingrédients
function ajouterIngredient(elem) {
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function () {
        if (this.readyState === 4 && this.status === 200) {
            document.getElementById('selection').innerHTML = this.responseText;
        }
    };
    xhttp.open("GET", "pages/modifier_selection_recettes_ajout.php?elem=" + elem, true);
    xhttp.send();
    document.getElementById("search").value = "";
}

// Supprime un ingrédient à la liste des ingrédients à rechercher dans la barre de recherche par ingrédients
function deleteIngredientFromSearch(elem) {
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function () {
        if (this.readyState === 4 && this.status === 200) {
            document.getElementById('selection').innerHTML = this.responseText;
        }
    };
    xhttp.open("GET", "pages/modifier_selection_recettes_suppression.php?elem=" + elem, true);
    xhttp.send();
}

// Bascule le mode de recherche d'un ingrédient (si on veut les recettes avec cette ingrédient ou non)
function switchElemSearchMode(elem) {
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function () {
        if (this.readyState === 4 && this.status === 200) {
            document.getElementById('selection').innerHTML = this.responseText;
        }
    };
    xhttp.open("GET", "pages/modifier_selection_recettes_mode.php?elem=" + elem, true);
    xhttp.send();
}

/**
 * Vérifie le formulaire de connexion. Si celui-ci a généré une erreur, alors on l'affiche, sinon on autorise
 * l'utilisateur à se connecter.
*/
function checkConnectionFormValidity() {
	var nickname = document.getElementById('login_form').elements["nickname"].value;
	nickname = encodeURIComponent(nickname);
	var pass = document.getElementById('login_form').elements["password"].value;
	pass = encodeURIComponent(pass);
	var append = "";
	var xhttp = new XMLHttpRequest();
	xhttp.onreadystatechange = function () {
		if (this.readyState === 4 && this.status === 200) {
			append += this.responseText;
		}
	};
	xhttp.open("GET", "pages/verif_connexion_info.php?nickname=" + nickname + "&password=" + pass, false);
	xhttp.send();
	if (append != "") {
		doc = document.getElementById("error_result");
		doc.innerHTML = append;
		doc.style.display = 'block';
	}
	else {
		alert("Vous êtes maintenant connecté(e) en tant que " + nickname + ".");
		document.location.href="page_principale.php";
	}
}

// Met à jour la liste les recettes favorites de l'utilisateur lors de la connexion si celui-ci confirme la mise à jour
function updateUserRecipesFromLogin(hasRecipesInCookie) {
	if (hasRecipesInCookie) {
		var userConfirm = confirm("Souhaitez-vous mettre à jour la liste de vos recettes favorites ?");
		if (userConfirm) {
			var xhttp = new XMLHttpRequest();
			xhttp.onreadystatechange = function () {
				if (this.readyState === 4 && this.status === 200) {
					document.getElementById('selection').innerHTML = this.responseText;
				}
			};
			xhttp.open("GET", "pages/login_maj_recettes_favorites.php", false);
			xhttp.send();
		}
	}
	generateUserRecipe();
}