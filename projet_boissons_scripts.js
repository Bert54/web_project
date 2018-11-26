function addRecipeToFavourites(elem) {
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function (elem) {
        if (this.readyState === 4 && this.status === 200) {
            document.getElementById('user_recipes').innerHTML = this.responseText;
        }
    };
    xhttp.open("GET", "ajoute_recette_fav.php?elem=" + elem, false);
    xhttp.send();
    generateUserRecipe();
}

function deleteRecipeFromFavourites(elem) {
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function (elem) {
        if (this.readyState === 4 && this.status === 200) {
            document.getElementById('user_recipes').innerHTML = this.responseText;
        }
    };
    xhttp.open("GET", "enleve_recette_fav.php?elem=" + elem, false);
    xhttp.send();
    generateUserRecipe();
    document.getElementById('user_recipes').style.display = 'block';
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
    generateUserRecipe();
    var doc = document.getElementById('user_recipes');
    if ($(doc).is(':visible')) {
        doc.style.display = 'none';
    }
    else {
        doc.style.display = 'block';
    }
}

function displayRecipeFromUserList(elem) {
    var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function (elem) {
            if (this.readyState === 4 && this.status === 200) {
                document.getElementById("recipes").innerHTML = this.responseText;
            }
        };
    xhttp.open("GET", "recette_affiche_nomrecette.php?elem=" + elem, true);
    xhttp.send();
}

function generateUserRecipe() {
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function () {
        if (this.readyState === 4 && this.status === 200) {
            document.getElementById('user_recipes').innerHTML = this.responseText;
        }
    };
    xhttp.open("GET", "user_recipes.php", false);
    xhttp.send();
}