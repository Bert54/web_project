<?php

    $user_recipes = json_decode($_COOKIE['user_recipes'], true);

    $GLOBALS['felemu'] = false;
<<<<<<< HEAD
    echo "<p style='border-top-style: solid;border-top-width: 2px'></p>";
    foreach ($user_recipes as $recipe) {
        echo "<p><span id='user_recipe_single' onClick='displayRecipeFromUserList(\"".$recipe."\")'>".$recipe."</span><img src='Images_Perso/DeleteRed.png' onClick='deleteRecipeFromFavourites(\"".$recipe."\")' style='width:20px;height:20px;padding-left:10px;cursor: pointer;'/></p>";
=======

    foreach ($user_recipes as $recipe) {
        echo "<p>".$recipe."</p>";
>>>>>>> 6525fe2dc8b2cd4c379f00bf138642483fd85556
        $GLOBALS['felemu'] = true;

    }

    if ($GLOBALS['felemu'] == false) {
       echo "<p id='user_recipes_list'><i>Vous n'avez actuellement pas de recettes favorites.</i></p>";
    }
<<<<<<< HEAD
    else {
        echo "<p style='border-top-style: solid;border-top-width: 2px;padding-top:15px;'><i id='allUsrRecipes'>Afficher toutes mes recettes</i></p>";
    }
=======
>>>>>>> 6525fe2dc8b2cd4c379f00bf138642483fd85556

?>