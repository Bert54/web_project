<?php

    $user_recipes = json_decode($_COOKIE['user_recipes'], true);

    $GLOBALS['felemu'] = false;

    foreach ($user_recipes as $recipe) {
        echo "<p>".$recipe."</p>";
        $GLOBALS['felemu'] = true;

    }

    if ($GLOBALS['felemu'] == false) {
       echo "<p id='user_recipes_list'><i>Vous n'avez actuellement pas de recettes favorites.</i></p>";
    }

?>